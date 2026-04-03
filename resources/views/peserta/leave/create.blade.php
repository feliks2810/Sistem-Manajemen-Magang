@extends('layouts.panel')

@section('title', 'Izin / sakit — Peserta')
@section('page_title', 'Pengajuan izin atau sakit')

@section('content')
<h1 class="mb-6 text-2xl font-bold text-slate-800">Pengajuan izin atau sakit</h1>

<form action="{{ route('peserta.leave.store') }}" method="post" enctype="multipart/form-data" class="max-w-xl space-y-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    @csrf
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="mb-1 block text-sm font-medium">Mulai</label>
            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Selesai</label>
            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
        </div>
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Jenis</label>
        <select name="jenis" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
            <option value="izin" @selected(old('jenis')==='izin')>Izin</option>
            <option value="sakit" @selected(old('jenis')==='sakit')>Sakit</option>
        </select>
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Alasan</label>
        <textarea name="alasan" rows="3" required class="w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('alasan') }}</textarea>
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Bukti (PDF/JPG/PNG, opsional)</label>
        <input type="file" name="bukti" accept=".pdf,.jpg,.jpeg,.png" class="text-sm">
    </div>
    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">Kirim</button>
</form>
@endsection
