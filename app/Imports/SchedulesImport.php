<?php

// File: app/Imports/SchedulesImport.php

namespace App\Imports;

use App\Models\Hairdresser;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SchedulesImport implements ToCollection, WithHeadingRow, WithEvents
{
    public $processedRows = 0; // Jumlah baris Excel yang diproses
    public $createdSchedules = 0; // Jumlah entri jadwal yang berhasil dibuat
    public $skippedEntries = 0;   // Jumlah entri jadwal individual yang dilewati (karena error/duplikat)

    public $duplicateSchedules = []; // Format: ['sheet' => ..., 'row' => ..., 'data' => ..., 'reason' => ..., 'details' => 'Layanan X pada jam Y']
    public $notFoundHairdressers = [];
    public $notFoundLocations = [];
    public $notFoundServices = [];     // Format: ['sheet' => ..., 'row' => ..., 'service_name' => ...]
    public $invalidAssociations = [];  // Format: ['sheet' => ..., 'row' => ..., 'reason' => ...]
    public $invalidDataFormat = [];    // Format: ['sheet' => ..., 'row' => ..., 'errors' => ...]

    private $currentSheetName;
    private $currentLocation;
    private $currentHairdresser;
    private $currentRowNumber;

    public function collection(Collection $rows)
    {
        if (!$this->currentLocation || !$this->currentHairdresser) {
            // PERBAIKAN: Panggil sebagai metode instance
            $this->skippedEntries += $rows->count() * $this->estimate_entries_per_row($rows->first());
            Log::warning("[IMPORT] Skipping sheet '{$this->currentSheetName}' due to invalid location or hairdresser parsed from sheet name.");
            return;
        }

        if (!$this->currentHairdresser->locations()->where('locations.id', $this->currentLocation->id)->exists()) {
            $this->invalidAssociations[] = [
                'sheet' => $this->currentSheetName,
                'row' => 'N/A (Sheet Level)',
                'reason' => "Hairdresser '{$this->currentHairdresser->name}' tidak bertugas di lokasi '{$this->currentLocation->name}'."
            ];
            // PERBAIKAN: Panggil sebagai metode instance
            $this->skippedEntries += $rows->count() * $this->estimate_entries_per_row($rows->first());
            Log::warning("[IMPORT] Skipping sheet '{$this->currentSheetName}': Hairdresser '{$this->currentHairdresser->name}' not at location '{$this->currentLocation->name}'.");
            return;
        }

        foreach ($rows as $index => $row) {
            $this->processedRows++;
            $this->currentRowNumber = $index + 2;

            $trimmedRow = $row->map(fn($item) => is_string($item) ? trim($item) : $item);

            $validator = Validator::make($trimmedRow->toArray(), [
                'tanggal' => 'required',
                'waktu' => 'required|string',
                'layanan' => 'required|string',
            ]);

            if ($validator->fails()) {
                $this->invalidDataFormat[] = ['sheet' => $this->currentSheetName, 'row' => $this->currentRowNumber, 'data' => $trimmedRow->toArray(), 'errors' => $validator->errors()->all()];
                // PERBAIKAN: Panggil sebagai metode instance
                $this->skippedEntries += $this->estimate_entries_per_row($trimmedRow);
                continue;
            }

            // 1. Parse Tanggal
            try {
                $dateValue = $trimmedRow['tanggal'];
                if (is_numeric($dateValue) && $dateValue > 1) {
                    $dateString = ExcelDate::excelToDateTimeObject($dateValue)->format('Y-m-d');
                } elseif (is_string($dateValue)) {
                    $dateString = Carbon::parse(str_replace('/', '-', $dateValue))->format('Y-m-d');
                } else {
                    throw new \Exception("Format tanggal tidak valid.");
                }
            } catch (\Exception $e) {
                $this->invalidDataFormat[] = ['sheet' => $this->currentSheetName, 'row' => $this->currentRowNumber, 'data' => $trimmedRow->toArray(), 'errors' => ['Error parsing tanggal: ' . $e->getMessage()]];
                // PERBAIKAN: Panggil sebagai metode instance
                $this->skippedEntries += $this->estimate_entries_per_row($trimmedRow);
                continue;
            }

            // 2. Parse Multiple Layanan
            $serviceNamesInput = array_map('trim', array_filter(explode(',', $trimmedRow['layanan'])));
            if (empty($serviceNamesInput)) {
                $this->invalidDataFormat[] = ['sheet' => $this->currentSheetName, 'row' => $this->currentRowNumber, 'data' => $trimmedRow->toArray(), 'errors' => ['Kolom Layanan kosong atau tidak valid.']];
                $this->skippedEntries++;
                continue;
            }

            // 3. Parse Multiple Waktu
            $timeInputs = array_map('trim', array_filter(explode(',', $trimmedRow['waktu'])));
            if (empty($timeInputs)) {
                $this->invalidDataFormat[] = ['sheet' => $this->currentSheetName, 'row' => $this->currentRowNumber, 'data' => $trimmedRow->toArray(), 'errors' => ['Kolom Waktu kosong atau tidak valid.']];
                $this->skippedEntries += count($serviceNamesInput);
                continue;
            }

            foreach ($serviceNamesInput as $serviceNameExcel) {
                $serviceNameNormalized = strtolower($serviceNameExcel);
                $service = Service::whereRaw('LOWER(name) = ?', [$serviceNameNormalized])->first();

                if (!$service) {
                    $this->notFoundServices[] = ['sheet' => $this->currentSheetName, 'row' => $this->currentRowNumber, 'service_name' => $serviceNameExcel];
                    $this->skippedEntries += count($timeInputs);
                    continue;
                }

                if (!$this->currentHairdresser->services()->where('services.id', $service->id)->exists()) {
                    $this->invalidAssociations[] = [
                        'sheet' => $this->currentSheetName,
                        'row' => $this->currentRowNumber,
                        'reason' => "Hairdresser '{$this->currentHairdresser->name}' tidak menyediakan layanan '{$service->name}'."
                    ];
                    $this->skippedEntries += count($timeInputs);
                    continue;
                }

                foreach ($timeInputs as $timeInput) {
                    try {
                        $timeString = Carbon::parse($timeInput)->format('H:i:s');
                        $datetimeCombined = Carbon::createFromFormat('Y-m-d H:i:s', $dateString . ' ' . $timeString, config('app.timezone', 'Asia/Jakarta'));
                    } catch (\Exception $e) {
                        $this->invalidDataFormat[] = [
                            'sheet' => $this->currentSheetName,
                            'row' => $this->currentRowNumber,
                            'data' => $trimmedRow->toArray(),
                            'errors' => ["Error parsing waktu '{$timeInput}': " . $e->getMessage()]
                        ];
                        $this->skippedEntries++;
                        continue;
                    }

                    $scheduleDataForCheck = [
                        'hairdresser_id' => $this->currentHairdresser->id,
                        'service_id' => $service->id,
                        'location_id' => $this->currentLocation->id,
                        'available_at' => $datetimeCombined->format('Y-m-d H:i:s')
                    ];

                    if (Schedule::where($scheduleDataForCheck)->exists()) {
                        $this->duplicateSchedules[] = [
                            'sheet' => $this->currentSheetName,
                            'row' => $this->currentRowNumber,
                            'details' => "Layanan: {$service->name}, Waktu: {$datetimeCombined->format('H:i')}",
                            'reason' => 'Jadwal duplikat'
                        ];
                        $this->skippedEntries++;
                        continue;
                    }

                    try {
                        Schedule::create($scheduleDataForCheck);
                        $this->createdSchedules++;
                    } catch (\Exception $e) {
                        Log::error("[IMPORT] Gagal menyimpan jadwal: Sheet '{$this->currentSheetName}', Baris {$this->currentRowNumber}, Layanan '{$service->name}', Waktu {$timeInput}. Error: " . $e->getMessage());
                        $this->invalidDataFormat[] = [
                            'sheet' => $this->currentSheetName,
                            'row' => $this->currentRowNumber,
                            'details' => "Gagal simpan: Layanan: {$service->name}, Waktu: {$timeInput}",
                            'errors' => ['Gagal menyimpan jadwal: ' . substr($e->getMessage(), 0, 100) . '...']
                        ];
                        $this->skippedEntries++;
                    }
                }
            }
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->currentSheetName = $event->getSheet()->getTitle();
                $this->currentLocation = null;
                $this->currentHairdresser = null;
                $this->currentRowNumber = 1;

                Log::info("[IMPORT] Processing sheet: {$this->currentSheetName}");

                $parts = explode(' - ', $this->currentSheetName, 2);
                if (count($parts) === 2) {
                    $locationNameFromSheet = strtolower(trim($parts[0]));
                    $hairdresserNameFromSheet = strtolower(trim($parts[1]));

                    $this->currentLocation = Location::whereRaw('LOWER(name) = ?', [$locationNameFromSheet])->first();
                    if (!$this->currentLocation) {
                        $originalLocationName = trim($parts[0]);
                        $this->notFoundLocations[$originalLocationName] = ($this->notFoundLocations[$originalLocationName] ?? 0) + 1;
                        Log::warning("[IMPORT] Location '{$originalLocationName}' from sheet '{$this->currentSheetName}' not found.");
                    }

                    $this->currentHairdresser = Hairdresser::whereRaw('LOWER(name) = ?', [$hairdresserNameFromSheet])->first();
                    if (!$this->currentHairdresser) {
                        $originalHairdresserName = trim($parts[1]);
                        $this->notFoundHairdressers[$originalHairdresserName] = ($this->notFoundHairdressers[$originalHairdresserName] ?? 0) + 1;
                        Log::warning("[IMPORT] Hairdresser '{$originalHairdresserName}' from sheet '{$this->currentSheetName}' not found.");
                    }
                } else {
                    Log::warning("[IMPORT] Sheet name '{$this->currentSheetName}' does not match 'Lokasi - Nama Hairdresser'. Skipping.");
                    $this->invalidDataFormat[] = [
                        'sheet' => $this->currentSheetName,
                        'row' => 'N/A (Nama Sheet)',
                        'data' => [],
                        'errors' => ["Nama sheet '{$this->currentSheetName}' tidak sesuai format 'Nama Lokasi - Nama Hairdresser'. Sheet ini dilewati."]
                    ];
                }
            },
        ];
    }

    private function estimate_entries_per_row($row)
    { // $row sekarang adalah satu baris (Collection atau array)
        if (!$row) return 1;
        // Jika $row adalah Collection, akses dengan ->get() atau key array jika sudah toArray()
        $layananKey = 'layanan'; // Sesuaikan dengan nama heading kolom Anda
        $waktuKey = 'waktu';   // Sesuaikan dengan nama heading kolom Anda

        $layananValue = $row instanceof Collection ? $row->get($layananKey) : ($row[$layananKey] ?? '');
        $waktuValue = $row instanceof Collection ? $row->get($waktuKey) : ($row[$waktuKey] ?? '');

        $numServices = count(array_filter(explode(',', $layananValue ?? '')));
        $numTimes = count(array_filter(explode(',', $waktuValue ?? '')));
        return max(1, $numServices * $numTimes);
    }
}
