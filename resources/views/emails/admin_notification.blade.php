<!DOCTYPE html>
<html>

<head>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@400..700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&family=Zen+Maru+Gothic:wght@300;400;500;700;900&display=swap"
        rel="stylesheet">
    <style>
        body {
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #25D366;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #128C7E;
        }
    </style>
</head>

<body class="font-elMessiri">
    <div class="container">
        <h2>Notifikasi Booking Baru</h2>

        <p>Berikut detail booking yang baru saja dibayar:</p>

        <table>
            <tr>
                <th>ID Booking</th>
                <td>BOOK-{{ $booking->id }}</td>
            </tr>
            <tr>
                <th>Nama Pelanggan</th>
                <td>{{ $booking->name }}</td>
            </tr>
            <tr>
                <th>No. HP</th>
                <td>{{ $booking->phone }}</td>
            </tr>
            <tr>
                <th>Layanan</th>
                <td>{{ $booking->service->name }}</td>
            </tr>
            <tr>
                <th>Jadwal</th>
                <td>{{ $booking->schedule->available_at }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $booking->address }}</td>
            </tr>
            <tr>
                <th>Total Pembayaran</th>
                <td>Rp {{ number_format($booking->price, 0, ',', '.') }}</td>
            </tr>
        </table>

        <a href="https://wa.me/6283869158630?text={{ $wa_message }}" class="button">
            Kirim Konfirmasi order ke Whatsapp
        </a>

        <p style="margin-top: 30px; font-size: 0.9em; color: #777;">
            Email ini dikirim secara otomatis. Harap tidak membalas email ini.
        </p>
    </div>
</body>

</html>
