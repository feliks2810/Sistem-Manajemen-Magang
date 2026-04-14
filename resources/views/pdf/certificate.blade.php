<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Cinzel:wght@600;700;900&family=Birthstone&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        @page {
            margin: 0;
            size: a4 landscape;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
            width: 297mm;
            height: 210mm;
            color: #1a202c;
            background-color: #fcfdfd;
        }
        .page {
            position: relative;
            width: 297mm;
            height: 210mm;
            page-break-after: always;
            overflow: hidden;
            box-sizing: border-box;
            background: #ffffff;
        }
        
        /* Premium Background Texture (Faint watermark effect) */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Cinzel', serif;
            font-size: 200pt;
            color: rgba(0, 95, 107, 0.03);
            z-index: 0;
            white-space: nowrap;
        }

        /* Elaborate Decorative Frame */
        .border-outer {
            position: absolute;
            top: 5mm; left: 5mm; right: 5mm; bottom: 5mm;
            border: 1px solid #c5a059;
        }
        .border-main {
            position: absolute;
            top: 3mm; left: 3mm; right: 3mm; bottom: 3mm;
            border: 4px double #005f6b;
        }
        .border-inner {
            position: absolute;
            top: 3mm; left: 3mm; right: 3mm; bottom: 3mm;
            border: 1px solid #c5a059;
        }

        /* Corner Ornaments */
        .ornament {
            position: absolute;
            width: 30mm;
            height: 30mm;
            z-index: 10;
        }
        .ornament svg {
            width: 100%;
            height: 100%;
            fill: #005f6b;
        }
        .top-left { top: -2px; left: -2px; }
        .top-right { top: -2px; right: -2px; transform: rotate(90deg); }
        .bottom-left { bottom: -2px; left: -2px; transform: rotate(-90deg); }
        .bottom-right { bottom: -2px; right: -2px; transform: rotate(180deg); }

        /* Main Content Wrapper */
        .content {
            position: relative;
            z-index: 20;
            text-align: center;
            padding-top: 25mm;
        }

        /* Logo & Header */
        .hospital-header {
            margin-bottom: 8mm;
        }
        .hospital-name {
            font-family: 'Cinzel', serif;
            font-size: 26pt;
            color: #005f6b;
            letter-spacing: 4px;
            font-weight: 900;
            margin: 0;
        }
        .hospital-sub {
            font-size: 9pt;
            color: #c5a059;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: -2mm;
        }

        .certificate-label {
            font-family: 'Cinzel', serif;
            font-size: 48pt;
            color: #005f6b;
            margin: 10mm 0 2mm 0;
            font-weight: 700;
        }
        .certificate-type {
            font-family: 'Montserrat', sans-serif;
            font-size: 14pt;
            letter-spacing: 6px;
            color: #c5a059;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5mm;
        }
        .cert-number {
            font-size: 10pt;
            color: #64748b;
            margin-bottom: 12mm;
        }

        /* Body Text */
        .text-present {
            font-size: 14pt;
            font-style: italic;
            color: #475569;
        }
        .recipient-name {
            font-family: 'Cinzel', serif;
            font-size: 38pt;
            color: #002d34;
            margin: 6mm 0;
            padding-bottom: 2mm;
            border-bottom: 2px solid #c5a059;
            display: inline-block;
            min-width: 60%;
        }
        .cert-body {
            width: 75%;
            margin: 8mm auto;
            font-size: 13pt;
            line-height: 1.8;
            color: #334155;
        }
        .highlight {
            color: #005f6b;
            font-weight: 700;
        }

        /* Premium CSS Seal */
        .seal-container {
            position: absolute;
            left: 50%;
            bottom: 35mm;
            transform: translateX(-50%);
            width: 35mm;
            height: 35mm;
        }
        .seal {
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, #e6b800 0%, #c5a059 100%);
            border-radius: 50%;
            border: 2px dashed #005f6b;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .seal::before {
            content: 'OFFICIAL';
            color: #005f6b;
            font-size: 6pt;
            font-weight: 900;
            letter-spacing: 1px;
            border: 1px solid #005f6b;
            padding: 2px 4px;
        }

        /* Signatures */
        .signatures {
            position: absolute;
            bottom: 20mm;
            width: 100%;
            padding: 0 40mm;
            box-sizing: border-box;
        }
        .sign-col {
            width: 45%;
            text-align: center;
        }
        .sign-name {
            font-family: 'Cinzel', serif;
            font-size: 12pt;
            font-weight: 700;
            border-bottom: 1px solid #1e293b;
            display: inline-block;
            padding: 0 15mm 2mm 15mm;
            margin-bottom: 1mm;
        }
        .sign-rank {
            font-size: 9pt;
            color: #64748b;
            text-transform: uppercase;
        }

        /* BACK PAGE: TRANSCRIPT */
        .transcript-page {
            padding: 20mm;
        }
        .transcript-header {
            text-align: center;
            border-bottom: 3px solid #005f6b;
            padding-bottom: 5mm;
            margin-bottom: 10mm;
        }
        .transcript-title {
            font-family: 'Cinzel', serif;
            font-size: 28pt;
            color: #005f6b;
        }
        
        .score-table {
            width: 100%;
            border-collapse: collapse;
        }
        .score-table th {
            background-color: #005f6b;
            color: #ffffff;
            font-family: 'Cinzel', serif;
            padding: 12pt;
            border: 1px solid #004b54;
        }
        .score-table td {
            padding: 10pt;
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        .criteria-name { text-align: left !important; font-weight: 600; padding-left: 20pt !important; }
        .total-row { background-color: #f1f5f9; font-weight: 700; }
        .average-row { background-color: #e2e8f0; font-weight: 900; font-size: 13pt; }

    </style>
</head>
<body>
    <!-- Front Page -->
    <div class="page">
        <div class="watermark">AWAL BROS</div>
        
        <div class="border-outer">
            <div class="border-main">
                <div class="border-inner">
                    <!-- CSS Ornaments -->
                    <div class="ornament top-left">
                        <svg viewBox="0 0 100 100"><path d="M0 0 L100 0 L100 10 L10 10 L10 100 L0 100 Z"/></svg>
                    </div>
                    <div class="ornament top-right">
                        <svg viewBox="0 0 100 100"><path d="M0 0 L100 0 L100 10 L10 10 L10 100 L0 100 Z"/></svg>
                    </div>
                    <div class="ornament bottom-left">
                        <svg viewBox="0 0 100 100"><path d="M0 0 L100 0 L100 10 L10 10 L10 100 L0 100 Z"/></svg>
                    </div>
                    <div class="ornament bottom-right">
                        <svg viewBox="0 0 100 100"><path d="M0 0 L100 0 L100 10 L10 10 L10 100 L0 100 Z"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="hospital-header">
                <h2 class="hospital-name">RS AWAL BROS</h2>
                <div class="hospital-sub">Human Resource Development</div>
            </div>

            <div class="certificate-label">SERTIFIKAT</div>
            <div class="certificate-type">PROGRAM {{ $programName }}</div>
            <div class="cert-number">No. Sertifikat: {{ $nomor }}</div>

            <div class="text-present">Diberikan dengan hormat kepada :</div>
            <div class="recipient-name">{{ strtoupper($peserta->user->name) }}</div>

            <div class="cert-body">
                Telah melaksanakan dan menyelesaikan program <span class="highlight">{{ $programName }}</span> 
                pada unit kerja terkait di RS Awal Bros dengan hasil yang memuaskan.
                Program dilaksanakan mulai tanggal <span class="highlight">{{ \Carbon\Carbon::parse($peserta->magang_start)->translatedFormat('d F Y') }}</span> 
                sampai dengan <span class="highlight">{{ \Carbon\Carbon::parse($peserta->magang_end)->translatedFormat('d F Y') }}</span>.
            </div>

            <div class="seal-container">
                <div class="seal"></div>
            </div>

            <div class="signatures">
                <table style="width: 100%;">
                    <tr>
                        <td class="sign-col" align="center">
                            <div style="margin-bottom: 20mm;">Batam, {{ $tanggal }}</div>
                            <div class="sign-name">{{ $peserta->pembimbing->user->name ?? 'Pembimbing' }}</div><br>
                            <span class="sign-rank">Pembimbing Lapangan</span>
                        </td>
                        <td width="10%">&nbsp;</td>
                        <td class="sign-col" align="center">
                            <div style="margin-bottom: 20mm;">&nbsp;</div>
                            <div class="sign-name">MANAGER HRD</div><br>
                            <span class="sign-rank">RS Awal Bros</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Back Page: Assessment -->
    <div class="page transcript-page">
        <div class="border-outer" style="opacity: 0.1;"></div>
        
        <div class="transcript-header">
            <h1 class="transcript-title">TRANSKRIP NILAI</h1>
            <p style="margin-top: -3mm; color: #64748b;">LAMPIRAN SERTIFIKAT NOMOR: {{ $nomor }}</p>
        </div>

        <div style="margin: 0 auto; width: 90%;">
            <table class="score-table">
                <thead>
                    <tr>
                        <th width="10%">NO</th>
                        <th width="60%">ASPEK PENILAIAN</th>
                        <th width="15%">NILAI</th>
                        <th width="15%">ABJAD</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $criteria = ['Disiplin', 'Kerjasama', 'Inisiatif dan Kreatif', 'Tanggung Jawab', 'Kerajinan'];
                    @endphp
                    @foreach($criteria as $index => $c)
                        @php
                            $scoreObj = $scores->first(fn($s) => $s->rubric->nama == $c);
                            $val = $scoreObj ? number_format($scoreObj->nilai, 0) : '-';
                            $pred = $scoreObj ? $scoreObj->predicate : '-';
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="criteria-name">{{ $c }}</td>
                            <td>{{ $val }}</td>
                            <td>{{ $pred }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="2" style="text-align: right; padding-right: 20pt;">TOTAL SKOR</td>
                        <td>{{ number_format($total, 0) }}</td>
                        <td>-</td>
                    </tr>
                    <tr class="average-row">
                        <td colspan="2" style="text-align: right; padding-right: 20pt; color: #005f6b;">NILAI RATA-RATA</td>
                        <td style="color: #005f6b;">{{ number_format($nilai, 0) }}</td>
                        <td style="color: #005f6b;">{{ $nilai >= 86 ? 'A' : ($nilai >= 70 ? 'B' : ($nilai >= 51 ? 'C' : 'D')) }}</td>
                    </tr>
                </tfoot>
            </table>

            <div style="margin-top: 15mm; border: 1px dashed #cbd5e1; padding: 15pt;">
                <h4 style="margin: 0 0 5pt 0; color: #005f6b; font-family: 'Cinzel', serif;">KETERANGAN PENILAIAN</h4>
                <table style="width: 100%; border: none; font-size: 9pt;">
                    <tr style="border: none;">
                        <td style="border: none; text-align: left;">86 - 100 : Sangat Baik (A)</td>
                        <td style="border: none; text-align: left;">70 - 85 : Baik (B)</td>
                        <td style="border: none; text-align: left;">51 - 69 : Cukup (C)</td>
                        <td style="border: none; text-align: left;">0 - 50 : Kurang (D)</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
