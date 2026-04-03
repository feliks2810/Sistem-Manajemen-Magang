<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function checkIn(): RedirectResponse
    {
        $profile = Auth::user()->pesertaProfile;
        if (! $profile) {
            abort(404);
        }

        $today = Carbon::today()->toDateString();
        if (! Carbon::today()->isWeekday()) {
            return back()->with('error', 'Absensi hanya pada hari kerja (Senin–Jumat).');
        }

        $att = Attendance::query()->firstOrCreate(
            [
                'peserta_profile_id' => $profile->id,
                'tanggal' => $today,
            ],
            ['status' => 'alpa']
        );

        if ($att->status === 'izin' || $att->status === 'sakit') {
            return back()->with('error', 'Hari ini tercatat '.$att->status.'.');
        }

        if ($att->check_in_at) {
            return back()->with('error', 'Anda sudah check-in hari ini.');
        }

        $att->update([
            'check_in_at' => now(),
            'status' => 'hadir',
        ]);

        return back()->with('success', 'Check-in berhasil.');
    }

    public function checkOut(): RedirectResponse
    {
        $profile = Auth::user()->pesertaProfile;
        if (! $profile) {
            abort(404);
        }

        $today = Carbon::today()->toDateString();
        $att = Attendance::query()
            ->where('peserta_profile_id', $profile->id)
            ->where('tanggal', $today)
            ->first();

        if (! $att || ! $att->check_in_at) {
            return back()->with('error', 'Lakukan check-in terlebih dahulu.');
        }

        if ($att->check_out_at) {
            return back()->with('error', 'Anda sudah check-out hari ini.');
        }

        $att->update(['check_out_at' => now()]);

        return back()->with('success', 'Check-out berhasil.');
    }
}
