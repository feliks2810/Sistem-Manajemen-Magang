<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\PesertaProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $profile = Auth::user()->pembimbingProfile;
        $peserta = PesertaProfile::query()
            ->with('user')
            ->where('pembimbing_id', $profile?->id)
            ->orderBy('nim')
            ->get();

        $pendingLeaves = LeaveRequest::query()
            ->with(['pesertaProfile.user'])
            ->whereHas('pesertaProfile', fn ($q) => $q->where('pembimbing_id', $profile?->id))
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('pembimbing.dashboard', compact('peserta', 'pendingLeaves', 'profile'));
    }
}
