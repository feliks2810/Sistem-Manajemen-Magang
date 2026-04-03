<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function __invoke(): View
    {
        $profile = Auth::user()->pesertaProfile;
        $rows = Attendance::query()
            ->where('peserta_profile_id', $profile?->id)
            ->orderByDesc('tanggal')
            ->paginate(31);

        return view('peserta.history', compact('rows', 'profile'));
    }
}
