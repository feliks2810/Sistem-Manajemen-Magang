@extends('layouts.panel')

@section('title', 'Beranda — Admin')
@section('page_title', 'Ringkasan')

@section('content')
<div class="mb-6 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <h1 class="text-xl font-semibold tracking-tight text-slate-900 md:text-2xl">Selamat datang, {{ auth()->user()->name }}</h1>
        <p class="mt-1 text-sm text-slate-500">Ringkasan aktivitas magang dan absensi.</p>
    </div>
    <a href="{{ route('admin.absensi.index') }}" class="mt-2 inline-flex shrink-0 items-center text-sm font-medium text-blue-600 hover:text-blue-700 sm:mt-0">Lihat semua absensi →</a>
</div>

{{-- Metric cards --}}
<div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="flex items-start justify-between rounded-[12px] border border-slate-200/80 bg-white p-5 shadow-sm">
        <div>
            <p class="text-sm font-medium text-slate-500">Peserta magang aktif</p>
            <p class="mt-2 text-2xl font-bold tracking-tight text-slate-900">{{ $pesertaAktif }}</p>
            @if($trendPeserta)
                <p class="mt-2 flex items-center gap-1 text-xs font-medium {{ $trendPeserta['up'] ? 'text-emerald-600' : 'text-red-600' }}">
                    @if($trendPeserta['up'])<span>↑</span>@else<span>↓</span>@endif
                    {{ $trendPeserta['pct'] }}% <span class="font-normal text-slate-400">vs bulan lalu</span>
                </p>
            @else
                <p class="mt-2 text-xs text-slate-400">—</p>
            @endif
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-[10px] bg-blue-50 text-blue-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
    </div>

    <div class="flex items-start justify-between rounded-[12px] border border-slate-200/80 bg-white p-5 shadow-sm">
        <div>
            <p class="text-sm font-medium text-slate-500">Pembimbing</p>
            <p class="mt-2 text-2xl font-bold tracking-tight text-slate-900">{{ $pembimbingCount }}</p>
            <p class="mt-2 text-xs text-slate-400">Akun terdaftar</p>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-[10px] bg-violet-50 text-violet-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
    </div>

    <div class="flex items-start justify-between rounded-[12px] border border-slate-200/80 bg-white p-5 shadow-sm">
        <div>
            <p class="text-sm font-medium text-slate-500">Kehadiran hari ini</p>
            <p class="mt-2 text-2xl font-bold tracking-tight text-slate-900">{{ $totalKehadiranHariIni }}</p>
            @if($trendHadir)
                <p class="mt-2 flex items-center gap-1 text-xs font-medium {{ $trendHadir['up'] ? 'text-emerald-600' : 'text-red-600' }}">
                    @if($trendHadir['up'])<span>↑</span>@else<span>↓</span>@endif
                    {{ $trendHadir['pct'] }}% <span class="font-normal text-slate-400">vs kemarin</span>
                </p>
            @else
                <p class="mt-2 text-xs text-slate-400">Status hadir</p>
            @endif
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-[10px] bg-emerald-50 text-emerald-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
    </div>

    <div class="flex items-start justify-between rounded-[12px] border border-slate-200/80 bg-white p-5 shadow-sm">
        <div>
            <p class="text-sm font-medium text-slate-500">Menunggu verifikasi</p>
            <p class="mt-2 text-2xl font-bold tracking-tight text-slate-900">{{ $pendingVerifikasi }}</p>
            <p class="mt-2 text-xs text-slate-400">Pengajuan izin / sakit</p>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-[10px] bg-amber-50 text-amber-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="mb-6 grid gap-4 lg:grid-cols-5">
    <div class="rounded-[12px] border border-slate-200/80 bg-white p-5 shadow-sm lg:col-span-3">
        <div class="mb-4 flex items-start justify-between gap-2">
            <div>
                <h2 class="text-base font-semibold text-slate-900">Tren kehadiran</h2>
                <p class="text-xs text-slate-500">Jumlah absensi status hadir per bulan</p>
            </div>
        </div>
        <div class="h-64">
            <canvas
                id="chart-area-kehadiran"
                data-labels='@json($chartLabels)'
                data-hadir='@json($chartHadir)'
            ></canvas>
        </div>
    </div>
    <div class="rounded-[12px] border border-slate-200/80 bg-white p-5 shadow-sm lg:col-span-2">
        <div class="mb-4">
            <h2 class="text-base font-semibold text-slate-900">Hadir vs izin & sakit</h2>
            <p class="text-xs text-slate-500">Perbandingan per bulan (6 bulan terakhir)</p>
        </div>
        <div class="h-64">
            <canvas
                id="chart-bar-absensi"
                data-labels='@json($chartLabels)'
                data-hadir='@json($chartHadir)'
                data-izin-sakit='@json($chartIzinSakit)'
            ></canvas>
        </div>
    </div>
</div>

{{-- Recent activity --}}
<div class="overflow-hidden rounded-[12px] border border-slate-200/80 bg-white shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 px-5 py-4">
        <div>
            <h2 class="text-base font-semibold text-slate-900">Aktivitas terbaru</h2>
            <p class="text-xs text-slate-500">Absensi hari ini — seperti daftar pesanan terbaru</p>
        </div>
        <a href="{{ route('admin.peserta.create') }}" class="rounded-[10px] bg-blue-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-700">+ Peserta</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/80 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <th class="px-5 py-3">Nama</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Masuk</th>
                    <th class="px-5 py-3">Pulang</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($aktivitasTerbaru as $r)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-5 py-3.5 font-medium text-slate-900">{{ $r->pesertaProfile->user->name ?? '—' }}</td>
                        <td class="px-5 py-3.5">
                            @php
                                $label = match ($r->status) {
                                    'hadir' => 'Hadir',
                                    'izin' => 'Izin',
                                    'sakit' => 'Sakit',
                                    default => ucfirst($r->status),
                                };
                            @endphp
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold
                                @if($r->status === 'hadir') bg-emerald-100 text-emerald-800
                                @elseif($r->status === 'izin') bg-amber-100 text-amber-800
                                @elseif($r->status === 'sakit') bg-blue-100 text-blue-800
                                @else bg-slate-100 text-slate-700 @endif">{{ $label }}</span>
                        </td>
                        <td class="px-5 py-3.5 font-mono text-slate-600">{{ $r->check_in_at ? str_replace(':', '.', $r->check_in_at->format('H:i')) : '—' }}</td>
                        <td class="px-5 py-3.5 font-mono text-slate-600">{{ $r->check_out_at ? str_replace(':', '.', $r->check_out_at->format('H:i')) : '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-12 text-center text-slate-500">Belum ada aktivitas absensi hari ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6 flex flex-wrap gap-4 text-sm text-slate-600">
    <a href="{{ route('admin.pembimbing.create') }}" class="font-medium text-blue-600 hover:text-blue-700">Tambah pembimbing</a>
    <span class="text-slate-200">|</span>
    <a href="{{ route('admin.penilaian.export') }}" class="font-medium text-blue-600 hover:text-blue-700">Export penilaian (CSV)</a>
</div>
@endsection

@push('scripts')
    @vite(['resources/js/admin-dashboard.js'])
@endpush
