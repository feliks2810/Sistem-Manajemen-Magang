@extends('layouts.panel')

@section('title', 'Beranda — Pembimbing')
@section('page_title', 'Ringkasan')

@section('content')
<h1 class="mb-6 text-2xl font-bold text-slate-800">Dashboard pembimbing</h1>

<div class="mb-8 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
    <h2 class="mb-3 font-semibold text-slate-800">Peserta bimbingan</h2>
    <ul class="divide-y divide-slate-100">
        @forelse($peserta as $p)
            <li class="flex flex-wrap items-center justify-between gap-2 py-3">
                <span><span class="font-mono text-slate-600">{{ $p->nim }}</span> — {{ $p->user->name }}</span>
                <a href="{{ route('pembimbing.evaluation.edit', $p) }}" class="text-sm text-indigo-600 hover:underline">Penilaian</a>
            </li>
        @empty
            <li class="py-4 text-slate-500">Belum ada peserta yang ditugaskan.</li>
        @endforelse
    </ul>
</div>

<div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
    <h2 class="mb-3 font-semibold text-slate-800">Pengajuan izin / sakit (menunggu)</h2>
    @forelse($pendingLeaves as $lr)
        <div class="mb-3 flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-3">
            <div>
                <p class="font-medium">{{ $lr->pesertaProfile->user->name }}</p>
                <p class="text-sm text-slate-600">{{ $lr->tanggal_mulai->format('d/m/Y') }} – {{ $lr->tanggal_selesai->format('d/m/Y') }} · {{ $lr->jenis }}</p>
            </div>
            <a href="{{ route('pembimbing.leaves.show', $lr) }}" class="text-indigo-600 hover:underline">Detail</a>
        </div>
    @empty
        <p class="text-slate-500">Tidak ada pengajuan tertunda.</p>
    @endforelse
    <a href="{{ route('pembimbing.leaves.index') }}" class="mt-2 inline-block text-sm text-indigo-600 hover:underline">Lihat semua</a>
</div>
@endsection
