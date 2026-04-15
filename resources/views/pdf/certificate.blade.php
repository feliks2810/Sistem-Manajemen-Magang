
<div style="width: 297mm; height: 210mm; font-family: Arial, sans-serif; color: #333; background-color: #ffffff; margin: 0; padding: 0; position: relative; overflow: hidden;">
    <!-- Top Bar using a Table with thick border-top -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="border-top: 10mm solid #d32f2f; line-height: 1px;">&nbsp;</td>
        </tr>
    </table>

    <div style="padding: 20mm; text-align: center;">
        <div style="font-size: 32px; font-weight: bold; color: #d32f2f; margin-top: 5mm;">
            RS AWAL BROS
        </div>
        
        <div style="font-size: 60px; font-weight: bold; color: #1565c0; margin: 15px 0;">
            SERTIFIKAT
        </div>
        
        <div style="font-size: 18px; margin-bottom: 5mm;">
            Diberikan kepada:
        </div>
        
        <table width="80%" align="center" cellpadding="0" cellspacing="0" border="0" style="margin: 10mm auto; border-bottom: 3px solid #000;">
            <tr>
                <td align="center" style="padding-bottom: 5px;">
                    <span style="font-size: 40px; font-weight: bold; color: #000;">{{ strtoupper($peserta->user?->name ?? 'NAMA LENGKAP') }}</span>
                </td>
            </tr>
        </table>
        
        <div style="font-size: 16px; color: #666; margin-top: 15px;">
            Sebagai
        </div>
        
        <div style="font-size: 24px; font-weight: bold; color: #000; margin-top: 10px;">
            {{ $peserta->institusi }}
        </div>
        
        <div style="font-size: 16px; line-height: 1.8; margin: 15mm 40mm;">
            Telah Melaksanakan Program <strong>{{ $programName }}</strong> di RS Awal Bros Botania pada<br>
            tanggal {{ $peserta->periode_mulai?->translatedFormat('d F Y') }} – {{ $peserta->periode_selesai?->translatedFormat('d F Y') }}
        </div>

        <table width="100%" style="margin-top: 15mm;">
            <tr>
                <td width="50%" align="center">
                    <div style="border: 2px solid #d32f2f; color: #d32f2f; font-weight: bold; font-size: 11px; padding: 12px; display: inline-block;">
                        RS AWAL BROS<br>BOTANIA
                    </div>
                </td>
                <td width="50%" align="center">
                    <div style="font-size: 15px;">Batam, {{ $tanggal }}</div>
                    <div style="height: 35mm;">&nbsp;</div>
                    <div style="font-size: 18px; font-weight: bold; text-decoration: underline;">dr. Retno Kusumo, MARS</div>
                    <div style="font-size: 15px; color: #555;">Direktur RS Awal Bros Botania</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Bottom Bar Row -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="position: absolute; bottom: 0;">
        <tr>
            <td style="border-bottom: 10mm solid #1565c0; line-height: 1px;">&nbsp;</td>
        </tr>
    </table>
</div>
