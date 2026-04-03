@extends('layouts.panel')

@section('title', 'Detail pengajuan — Pembimbing')
@section('page_title', 'Detail izin / sakit')

@section('content')
<h1 class="mb-6 text-2xl font-bold text-slate-800">Detail pengajuan</h1>

<div class="max-w-2xl space-y-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <p><strong>Peserta:</strong> {{ $leave->pesertaProfile->user->name }} ({{ $leave->pesertaProfile->nim }})</p>
    <p><strong>Periode:</strong> {{ $leave->tanggal_mulai->format('d/m/Y') }} – {{ $leave->tanggal_selesai->format('d/m/Y') }}</p>
    <p><strong>Jenis:</strong> {{ $leave->jenis }}</p>
    <p><strong>Alasan:</strong> {{ $leave->alasan }}</p>
    <p><strong>Status:</strong> {{ $leave->status }}</p>
    @if($leave->bukti_path)
        <p>
            <strong>Bukti:</strong>
            <a href="{{ asset('storage/'.$leave->bukti_path) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat file</a>
        </p>
    @endif

    @if($leave->status === 'pending')
        <div class="flex flex-wrap gap-3 pt-4">
            <form action="{{ route('pembimbing.leaves.approve', $leave) }}" method="post">
                @csrf
                <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">Setujui</button>
            </form>
            <form action="{{ route('pembimbing.leaves.reject', $leave) }}" method="post" class="flex flex-wrap items-end gap-2">
                @csrf
                <div>
                    <label class="mb-1 block text-sm">Catatan (opsional)</label>
                    <input name="catatan_pembimbing" class="rounded border border-slate-300 px-3 py-2">
                </div>
                <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700">Tolak</button>
            </form>
        </div>
    @endif
</div>
<p class="mt-4"><a href="{{ route('pembimbing.leaves.index') }}" class="text-indigo-600 hover:underline">← Kembali</a></p>
@endsection
