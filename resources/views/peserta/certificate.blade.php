@extends('layouts.panel')

@section('title', 'Sertifikat — Peserta')
@section('page_title', 'Hasil & Sertifikat')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Hasil & Sertifikat</h1>
    <p class="mt-1 text-sm text-slate-500">Unduh sertifikat resmi penyelesaian program magang Anda.</p>
</div>

@if($message)
    <div class="max-w-lg space-y-4">
        <div class="rounded-[14px] border border-amber-200 bg-amber-50 p-5 flex items-start gap-3">
            <svg class="h-5 w-5 shrink-0 text-amber-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="text-sm font-bold text-amber-800">Sertifikat Belum Tersedia</p>
                <p class="mt-0.5 text-sm text-amber-700">{{ $message }}</p>
            </div>
        </div>

        <div class="rounded-[14px] border border-slate-200 bg-white p-5">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Syarat Mendapatkan Sertifikat</p>
            <ul class="space-y-2.5">
                @foreach([
                    'Penilaian akhir telah diberikan oleh pembimbing',
                    'Status penilaian sudah di-finalisasi (bukan draft)',
                    'Data profil magang sudah dilengkapi (NIM, dll.)',
                ] as $syarat)
                <li class="flex items-center gap-2.5 text-sm text-slate-600">
                    <span class="flex h-4 w-4 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-slate-50">
                        <svg class="h-2.5 w-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4"/></svg>
                    </span>
                    {{ $syarat }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>

@elseif($certificate)
    <div class="max-w-2xl space-y-4">

        {{-- Main Certificate Card --}}
        <div class="rounded-[14px] border border-slate-200 bg-white p-8 shadow-sm">

            {{-- Top: Icon + Title + Badge --}}
            <div class="flex items-start justify-between mb-8">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Sertifikat Penyelesaian Magang</h2>
                        <p class="text-xs text-slate-400 font-mono mt-0.5">{{ $certificate->nomor_sertifikat }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    Siap Unduh
                </span>
            </div>

            {{-- Stats Row --}}
            <div class="mb-8 grid grid-cols-2 gap-px overflow-hidden rounded-xl border border-slate-100 bg-slate-100">
                <div class="bg-white px-6 py-5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Kehadiran</p>
                    <p class="mt-1 text-3xl font-bold tracking-tight text-slate-900">{{ $certificate->kehadiran_persen }}<span class="text-lg font-medium text-slate-400">%</span></p>
                </div>
                <div class="bg-white px-6 py-5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nilai Akhir</p>
                    <p class="mt-1 text-3xl font-bold tracking-tight text-slate-900">{{ $certificate->nilai_akhir }}</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('peserta.certificate.download') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition-all hover:bg-slate-50 hover:text-slate-900">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Unduh PDF
                </a>
                <form action="{{ route('peserta.certificate.refresh') }}" method="post">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition-all hover:bg-slate-50 hover:text-slate-900">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Perbarui Data
                    </button>
                </form>
            </div>
        </div>

        {{-- Note --}}
        <p class="px-1 text-xs text-slate-400">Tekan <strong class="text-slate-500">Perbarui Data</strong> hanya jika ada perubahan nilai atau kehadiran terbaru yang perlu disinkronkan.</p>
    </div>
@endif
@endsection
