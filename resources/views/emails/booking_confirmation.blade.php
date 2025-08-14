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
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>

<body class="font-elMessiri">
    <div class="header">
        <h2>Terima Kasih Telah Melakukan Booking</h2>
    </div>

    <div class="content">
        <p>Halo {{ $booking->name }},</p>
        <p>Pembayaran untuk booking Anda telah kami terima. Berikut detailnya:</p>

        <table>
            <tr>
                <th>ID Booking</th>
                <td>BOOK-{{ $booking->id }}</td>
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
                <th>Total Pembayaran</th>
                <td>Rp {{ number_format($booking->price, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>Lunas</td>
            </tr>
        </table>

        <p style="margin-top: 20px;">
            Jika Anda memiliki pertanyaan, silakan hubungi kami di orvesalon@gmail.com atau +6283869158630.
        </p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>

</html>
