<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; text-align: center; padding: 40px; }
        h1 { font-size: 28px; margin-bottom: 8px; }
        .sub { font-size: 14px; color: #444; margin-bottom: 32px; }
        .name { font-size: 22px; font-weight: bold; margin: 24px 0; }
        .meta { font-size: 13px; margin-top: 32px; }
        .line { border-bottom: 2px solid #333; width: 200px; margin: 40px auto 8px; }
    </style>
</head>
<body>
    <h1>SERTIFIKAT MAGANG</h1>
    <p class="sub">Diberikan kepada</p>
    <p class="name">{{ $peserta->user->name }}</p>
    <p>NIM {{ $peserta->nim }}</p>
    <p class="meta">Nomor: {{ $nomor }}</p>
    <p class="meta">Telah menyelesaikan kegiatan magang dengan kehadiran {{ number_format($kehadiran, 2) }}% dan nilai akhir {{ number_format($nilai, 2) }}.</p>
    <p class="meta">Diterbitkan pada {{ $tanggal }}</p>
    <div class="line"></div>
    <p style="font-size:12px;">{{ config('app.name') }}</p>
</body>
</html>
