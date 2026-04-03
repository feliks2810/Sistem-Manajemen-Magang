<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LeaveController extends Controller
{
    public function create(): View
    {
        return view('peserta.leave.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $profile = Auth::user()->pesertaProfile;
        if (! $profile) {
            abort(404);
        }

        $data = $request->validate([
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'jenis' => ['required', 'in:izin,sakit'],
            'alasan' => ['required', 'string', 'max:2000'],
            'bukti' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpg,jpeg,png'],
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti-izin/'.$profile->id, 'public');
        }

        LeaveRequest::query()->create([
            'peserta_profile_id' => $profile->id,
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_selesai' => $data['tanggal_selesai'],
            'jenis' => $data['jenis'],
            'alasan' => $data['alasan'],
            'bukti_path' => $buktiPath,
            'status' => 'pending',
        ]);

        return redirect()->route('peserta.dashboard')->with('success', 'Pengajuan izin/sakit dikirim. Menunggu verifikasi pembimbing.');
    }
}
