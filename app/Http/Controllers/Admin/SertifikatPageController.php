<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesertaProfile;
use Illuminate\View\View;

class SertifikatPageController extends Controller
{
    public function __invoke(): View
    {
        $pesertaList = PesertaProfile::query()->with('user')->orderBy('nim')->get();

        return view('admin.sertifikat', compact('pesertaList'));
    }
}
