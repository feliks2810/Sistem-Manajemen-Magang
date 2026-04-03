@extends('layouts.panel')

@section('title', 'Beranda — Peserta')
@section('page_title', 'Ringkasan')

@section('content')
<h1 class="mb-6 text-2xl font-bold text-slate-800">Dashboard</h1>

@if($profile)
<div class="mb-6 grid gap-4 sm:grid-cols-2">
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-500">Status magang</p>
        <p class="text-lg font-semibold text-slate-800">Aktif</p>
        <p class="mt-1 text-sm text-slate-600">{{ $profile->periode_mulai->format('d M Y') }} – {{ $profile->periode_selesai->format('d M Y') }}</p>
    </div>
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-500">Kehadiran (perkiraan)</p>
        <p class="text-3xl font-semibold text-indigo-700">{{ $persen }}%</p>
    </div>
</div>

<div class="mb-6 flex flex-wrap gap-3">
    <form action="{{ route('peserta.absensi.checkin') }}" method="post">
        @csrf
        <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 font-medium text-white hover:bg-emerald-700">Check-in</button>
    </form>
    <form action="{{ route('peserta.absensi.checkout') }}" method="post">
        @csrf
        <button type="submit" class="rounded-lg bg-slate-700 px-4 py-2 font-medium text-white hover:bg-slate-800">Check-out</button>
    </form>
    <a href="{{ route('peserta.leave.create') }}" class="rounded-lg border border-amber-300 bg-amber-50 px-4 py-2 font-medium text-amber-900 hover:bg-amber-100">Ajukan izin / sakit</a>
</div>

<div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
    <p class="text-sm text-slate-600"><strong>Pembimbing:</strong> {{ $profile->pembimbing?->user?->name ?? 'Belum ditetapkan' }}</p>
</div>
@else
<p class="text-slate-600">Profil peserta belum tersedia. Hubungi admin.</p>
@endif
@endsection
