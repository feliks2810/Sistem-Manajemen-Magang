@extends('layouts.panel')

@section('title', 'Edit peserta — Admin')
@section('page_title', 'Manajemen peserta magang')

@section('content')
<h1 class="mb-6 text-xl font-bold text-slate-800">Edit peserta</h1>

<form action="{{ route('admin.peserta.update', $peserta) }}" method="post" class="max-w-xl space-y-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    @csrf @method('PUT')
    <h2 class="font-semibold text-slate-700">Akun</h2>
    <div>
        <label class="mb-1 block text-sm font-medium">Nama</label>
        <input name="name" value="{{ old('name', $peserta->user->name) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email', $peserta->user->email) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Kata sandi baru (opsional)</label>
        <input type="password" name="password" class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Ulangi kata sandi</label>
        <input type="password" name="password_confirmation" class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>

    <h2 class="pt-4 font-semibold text-slate-700">Data magang</h2>
    <div>
        <label class="mb-1 block text-sm font-medium">NIM</label>
        <input name="nim" value="{{ old('nim', $peserta->nim) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Jurusan</label>
        <input name="jurusan" value="{{ old('jurusan', $peserta->jurusan) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Institusi</label>
        <input name="institusi" value="{{ old('institusi', $peserta->institusi) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Telepon</label>
        <input name="phone" value="{{ old('phone', $peserta->phone) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Alamat</label>
        <textarea name="alamat" rows="2" class="w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('alamat', $peserta->alamat) }}</textarea>
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="mb-1 block text-sm font-medium">Periode mulai</label>
            <input type="date" name="periode_mulai" value="{{ old('periode_mulai', $peserta->periode_mulai->format('Y-m-d')) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Periode selesai</label>
            <input type="date" name="periode_selesai" value="{{ old('periode_selesai', $peserta->periode_selesai->format('Y-m-d')) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
        </div>
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Pembimbing</label>
        <select name="pembimbing_id" class="w-full rounded-lg border border-slate-300 px-3 py-2">
            <option value="">— Belum ditetapkan —</option>
            @foreach($pembimbing as $pb)
                <option value="{{ $pb->id }}" @selected(old('pembimbing_id', $peserta->pembimbing_id) == $pb->id)>{{ $pb->user->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">Perbarui</button>
</form>
@endsection
