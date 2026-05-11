<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Penilaian Magang - {{ $profile->user->name }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.5; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #00B1C0; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #00B1C0; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #666; font-size: 14px; }
        .info-table { width: 100%; margin-bottom: 30px; }
        .info-table td { padding: 5px 0; vertical-align: top; }
        .info-table .label { width: 150px; font-weight: bold; color: #555; }
        .scores-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .scores-table th, .scores-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .scores-table th { background-color: #f5f5f5; color: #333; font-weight: bold; }
        .scores-table .text-center { text-align: center; }
        .scores-table .text-right { text-align: right; }
        .footer { margin-top: 50px; text-align: right; }
        .footer p { margin: 5px 0; }
        .signature-box { display: inline-block; text-align: left; width: 250px; margin-top: 20px; }
        .signature-line { border-bottom: 1px solid #333; height: 80px; margin-bottom: 10px; }
        .comment-box { border: 1px solid #ddd; background-color: #fafafa; padding: 15px; border-radius: 5px; margin-bottom: 30px; }
        .comment-title { font-weight: bold; margin-bottom: 10px; color: #444; }
        .category-box { padding: 10px; background-color: #e0f2f1; border: 1px solid #b2dfdb; border-radius: 5px; text-align: center; font-size: 16px; font-weight: bold; color: #00695c; margin-bottom: 30px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Penilaian Magang</h1>
        <p>Rumah Sakit Awal Bros</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Peserta</td>
            <td>: {{ $profile->user->name }}</td>
            <td class="label">Nama Pembimbing</td>
            <td>: {{ $evaluation->pembimbingProfile->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">NIM</td>
            <td>: {{ $profile->nim }}</td>
            <td class="label">Tanggal Penilaian</td>
            <td>: {{ $evaluation->finalized_at ? $evaluation->finalized_at->format('d/m/Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="label">Institusi/Universitas</td>
            <td colspan="3">: {{ $profile->universitas ?? '-' }}</td>
        </tr>
    </table>

    <table class="scores-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%">No</th>
                <th style="width: 55%">Aspek Penilaian</th>
                <th class="text-center" style="width: 20%">Bobot Maksimal</th>
                <th class="text-center" style="width: 20%">Nilai (0-100)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluation->rubricScores as $index => $score)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $score->rubric->nama }}</td>
                    <td class="text-center">{{ $score->rubric->bobot_maks }}%</td>
                    <td class="text-center">{{ $score->nilai }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-right" style="font-weight: bold; padding-right: 15px;">TOTAL NILAI AKHIR</td>
                <td class="text-center" style="font-weight: bold; font-size: 16px;">{{ $evaluation->total_nilai }}</td>
            </tr>
        </tbody>
    </table>

    <div class="category-box">
        Kategori Penilaian: {{ $evaluation->kategori }}
    </div>

    <div class="comment-box">
        <div class="comment-title">Komentar & Umpan Balik Pembimbing:</div>
        <p style="margin: 0;">{{ $evaluation->komentar_final ?: 'Tidak ada komentar.' }}</p>
    </div>

    <div class="footer">
        <div class="signature-box">
            <p>Pekanbaru, {{ $evaluation->finalized_at ? $evaluation->finalized_at->format('d F Y') : date('d F Y') }}</p>
            <p>Pembimbing Magang,</p>
            <div class="signature-line"></div>
            <p style="font-weight: bold;">{{ $evaluation->pembimbingProfile->user->name ?? '-' }}</p>
        </div>
    </div>

</body>
</html>
