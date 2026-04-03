@extends('layouts.panel')

@section('title', 'Tambah pembimbing — Admin')
@section('page_title', 'Manajemen akun pembimbing')

@section('content')
<h1 class="mb-6 text-xl font-bold text-slate-800">Tambah pembimbing</h1>

<form action="{{ route('admin.pembimbing.store') }}" method="post" class="max-w-xl space-y-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    @csrf
    <div>
        <label class="mb-1 block text-sm font-medium">Nama</label>
        <input name="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Kata sandi</label>
        <input type="password" name="password" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Ulangi kata sandi</label>
        <input type="password" name="password_confirmation" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">NIP</label>
        <input name="nip" value="{{ old('nip') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Telepon</label>
        <input name="phone" value="{{ old('phone') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">Simpan</button>
</form>
@endsection
