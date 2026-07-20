<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PesertaProfile;
use App\Models\Attendance;
use Carbon\Carbon;

class AutoAlfaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:auto-alfa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set status alpa bagi peserta yang tidak absen hari ini (Jalan pukul 17:05)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->toDateString();
        
        // Find all active peserta (periode belum selesai atau hari ini terakhir)
        $pesertas = PesertaProfile::whereDate('periode_selesai', '>=', $today)->get();
        
        $count = 0;
        foreach ($pesertas as $peserta) {
            $attendance = Attendance::where('peserta_profile_id', $peserta->id)
                ->whereDate('tanggal', $today)
                ->first();
                
            if (!$attendance) {
                Attendance::create([
                    'peserta_profile_id' => $peserta->id,
                    'tanggal'            => $today,
                    'status'             => 'alpa',
                    'is_valid'           => false,
                    'keterangan'         => 'Otomatis Alpa (Tidak ada absen masuk)',
                ]);
                $count++;
            }
        }
        
        $this->info("Auto alfa completed for {$count} records.");
    }
}
