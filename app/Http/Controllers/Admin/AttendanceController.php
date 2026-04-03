<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\PesertaProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $pesertaId = $request->integer('peserta_id') ?: null;
        $q = Attendance::query()
            ->with(['pesertaProfile.user'])
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        if ($pesertaId) {
            $q->where('peserta_profile_id', $pesertaId);
        }

        $rows = $q->paginate(30)->withQueryString();
        $pesertaList = PesertaProfile::query()->with('user')->orderBy('nim')->get();

        return view('admin.attendance.index', compact('rows', 'pesertaList', 'pesertaId'));
    }
}
