<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Evaluation;
use App\Models\PesertaProfile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificateService
{
    public function __construct(
        protected AttendanceStatsService $attendanceStats
    ) {}

    public function generateOrRefresh(PesertaProfile $peserta): Certificate
    {
        $eval = Evaluation::query()
            ->where('peserta_profile_id', $peserta->id)
            ->where('is_final', true)
            ->latest()
            ->first();

        $nilai = $eval ? (float) $eval->total_nilai : 0.0;
        $persen = $this->attendanceStats->attendancePercent($peserta);

        $nomor = 'CERT-'.now()->format('Y').'-'.str_pad((string) $peserta->id, 5, '0', STR_PAD_LEFT);

        $pdf = Pdf::loadView('pdf.certificate', [
            'peserta' => $peserta->load('user'),
            'nomor' => $nomor,
            'kehadiran' => $persen,
            'nilai' => $nilai,
            'tanggal' => now()->translatedFormat('d F Y'),
        ])->setPaper('a4', 'landscape');

        $dir = 'certificates';
        $filename = $dir.'/'.Str::slug($peserta->nim.'-'.$nomor).'.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        return Certificate::query()->updateOrCreate(
            ['peserta_profile_id' => $peserta->id],
            [
                'nomor_sertifikat' => $nomor,
                'file_path' => $filename,
                'kehadiran_persen' => $persen,
                'nilai_akhir' => $nilai,
                'generated_at' => now(),
            ]
        );
    }
}
