@extends('layouts.panel')

@section('title', 'Profil — Peserta')
@section('page_title', 'Profil saya')

@section('content')
<h1 class="mb-6 text-2xl font-bold text-slate-800">Profil</h1>

@if($profile)
<form action="{{ route('peserta.profile.update') }}" method="post" enctype="multipart/form-data" class="max-w-xl space-y-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    @csrf @method('PUT')
    <p><strong>Nama:</strong> {{ $profile->user->name }}</p>
    <p><strong>Email:</strong> {{ $profile->user->email }}</p>
    <p><strong>NIM:</strong> {{ $profile->nim }}</p>
    <div>
        <label class="mb-1 block text-sm font-medium">Telepon</label>
        <input name="phone" value="{{ old('phone', $profile->phone) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Alamat</label>
        <textarea name="alamat" rows="2" class="w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('alamat', $profile->alamat) }}</textarea>
    </div>
    <div class="border-t border-slate-100 pt-4">
        <h2 class="mb-2 font-semibold">Upload dokumen</h2>
        <div class="mb-2">
            <label class="mb-1 block text-sm">Nama dokumen</label>
            <input name="nama_dokumen" placeholder="Opsional" class="w-full rounded-lg border border-slate-300 px-3 py-2">
        </div>
        <input type="file" name="dokumen" accept=".pdf,.jpg,.jpeg,.png" class="text-sm">
    </div>
    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">Simpan</button>
</form>

@if($profile->documents->isNotEmpty())
<div class="mt-8">
    <h2 class="mb-3 font-semibold">Dokumen terunggah</h2>
    <ul class="space-y-2">
        @foreach($profile->documents as $d)
            <li><a href="{{ asset('storage/'.$d->path) }}" target="_blank" class="text-indigo-600 hover:underline">{{ $d->nama }}</a></li>
        @endforeach
    </ul>
</div>
@endif
@else
<p>Profil tidak tersedia.</p>
@endif
@endsection
