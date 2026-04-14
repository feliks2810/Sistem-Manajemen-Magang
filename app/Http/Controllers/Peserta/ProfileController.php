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
            'nim' => ['required', 'string', 'max:32'],
            'jurusan' => ['required', 'string', 'max:128'],
            'institusi' => ['required', 'string', 'max:128'],
            'phone' => ['required', 'string', 'max:32'],
            'alamat' => ['required', 'string'],
            'avatar' => ['nullable', 'image', 'max:5120', 'mimes:jpg,jpeg,png'],
            'dokumen' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpg,jpeg,png'],
            'nama_dokumen' => ['nullable', 'string', 'max:128'],
            'kategori_dokumen' => ['nullable', 'string', 'in:Surat Pengantar Magang,Surat Balasan Instansi,Lainnya'],
        ]);

        // 1. Update Peserta Profiles
        $profile->update([
            'nim' => $data['nim'],
            'jurusan' => $data['jurusan'],
            'institusi' => $data['institusi'],
            'phone' => $data['phone'],
            'alamat' => $data['alamat'],
        ]);

        // 2. Update Avatar in Users table
        $avatarUploaded = false;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            Auth::user()->update([
                'avatar_path' => $avatarPath
            ]);
            $avatarUploaded = true;
        }

        // 3. Document Upload
        if ($request->hasFile('dokumen')) {
            $kategori = $data['kategori_dokumen'] ?? 'Lainnya';
            $nama = $data['nama_dokumen'] ?: ($kategori !== 'Lainnya' ? $kategori : $request->file('dokumen')->getClientOriginalName());
            
            $path = $request->file('dokumen')->store('dokumen/'.$profile->id, 'public');
            Document::query()->create([
                'peserta_profile_id' => $profile->id,
                'nama' => $nama,
                'path' => $path,
            ]);
        }

        $message = $avatarUploaded
            ? 'Profil diperbarui dan foto profil berhasil diupload! 🎉'
            : 'Profil berhasil diperbarui.';

        return redirect()->route('peserta.profile')->with('success', $message);
    }
}
