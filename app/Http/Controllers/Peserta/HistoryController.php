<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function __invoke(Request $request): View
    {
        $profile = Auth::user()->pesertaProfile;
        
        $month = $request->integer('month') ?: now()->month;
        $year = $request->integer('year') ?: now()->year;

        $query = Attendance::query()
            ->where('peserta_profile_id', $profile?->id);

        // All time stats for comparison if needed, but focus on selected month
        $recap = [
            'hadir' => (clone $query)->whereYear('tanggal', $year)->whereMonth('tanggal', $month)->where('status', 'hadir')->count(),
            'izin' => (clone $query)->whereYear('tanggal', $year)->whereMonth('tanggal', $month)->where('status', 'izin')->count(),
            'sakit' => (clone $query)->whereYear('tanggal', $year)->whereMonth('tanggal', $month)->where('status', 'sakit')->count(),
            'alpha' => (clone $query)->whereYear('tanggal', $year)->whereMonth('tanggal', $month)->where('status', 'alpha')->count(),
        ];

        $rows = $query->orderByDesc('tanggal')
            ->paginate(31)
            ->withQueryString();

        return view('peserta.history', compact('rows', 'profile', 'recap', 'month', 'year'));
    }
}
