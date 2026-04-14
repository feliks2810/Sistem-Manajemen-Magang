<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesertaProfile;
use App\Services\CertificateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function generate(Request $request, CertificateService $cert): RedirectResponse
    {
        $data = $request->validate([
            'peserta_profile_id' => ['required', 'exists:peserta_profiles,id'],
        ]);

        $peserta = PesertaProfile::query()
            ->findOrFail($data['peserta_profile_id']);
        $cert->generateOrRefresh($peserta);

        return redirect()
            ->route('admin.sertifikat.page')
            ->with('success', 'Sertifikat PDF berhasil dibuat/diperbarui.');
    }
}
