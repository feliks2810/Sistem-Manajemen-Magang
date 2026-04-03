<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Services\AttendanceStatsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(AttendanceStatsService $stats): View
    {
        $profile = Auth::user()->pesertaProfile;
        $persen = $profile ? $stats->attendancePercent($profile) : 0;

        return view('peserta.dashboard', compact('profile', 'persen'));
    }
}
