<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $profile = Auth::user()->pesertaProfile;
        $profile?->load('documents');

        return view('peserta.profile', compact('profile'));
    }

    public function update(Request $request): RedirectResponse
    {
        $profile = Auth::user()->pesertaProfile;
        if (! $profile) {
            abort(404);
        }

        $data = $request->validate([
            'phone' => ['nullable', 'string', 'max:32'],
            'alamat' => ['nullable', 'string'],
            'dokumen' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpg,jpeg,png'],
            'nama_dokumen' => ['nullable', 'string', 'max:128'],
        ]);

        $profile->update([
            'phone' => $data['phone'] ?? $profile->phone,
            'alamat' => $data['alamat'] ?? $profile->alamat,
        ]);

        if ($request->hasFile('dokumen')) {
            $nama = $data['nama_dokumen'] ?: $request->file('dokumen')->getClientOriginalName();
            $path = $request->file('dokumen')->store('dokumen/'.$profile->id, 'public');
            Document::query()->create([
                'peserta_profile_id' => $profile->id,
                'nama' => $nama,
                'path' => $path,
            ]);
        }

        return redirect()->route('peserta.profile')->with('success', 'Profil diperbarui.');
    }
}
