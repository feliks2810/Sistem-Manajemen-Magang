<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendance;
use Carbon\Carbon;

class AutoCheckoutCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:auto-checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Melakukan checkout otomatis pukul 17:00 jika peserta lupa checkout';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today()->toDateString();
        
        $attendances = Attendance::whereDate('tanggal', $today)
            ->whereNotNull('check_in_at')
            ->whereNull('check_out_at')
            ->get();
            
        $count = 0;
        foreach ($attendances as $attendance) {
            // Check out time exactly at 17:00
            $checkoutTime = Carbon::createFromTime(17, 0, 0);
            
            // Re-check valid logic: duration check in this case will be check_in_at to 17:00.
            // Minimum checkout time is 16:00 (Mon-Thu) and 16:30 (Fri). Since it's 17:00, that passes.
            // But what if they checked in at 12:00? 12 to 17 is 5 hours. (Less than 7 hours)
            $durationHours = $attendance->check_in_at->diffInHours($checkoutTime);
            $isValid = $durationHours >= 7;

            $attendance->update([
                'check_out_at' => $checkoutTime,
                'is_valid'     => $isValid,
                'keterangan'   => trim($attendance->keterangan . ' (Auto Checkout)'),
            ]);
            $count++;
        }
        
        $this->info("Auto checkout completed for {$count} records.");
    }
}
