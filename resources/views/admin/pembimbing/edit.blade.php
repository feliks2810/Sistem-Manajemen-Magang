@extends('layouts.panel')

@section('title', 'Edit pembimbing — Admin')
@section('page_title', 'Manajemen akun pembimbing')

@section('content')
<h1 class="mb-6 text-xl font-bold text-slate-800">Edit pembimbing</h1>

<form action="{{ route('admin.pembimbing.update', $pembimbing) }}" method="post" class="max-w-xl space-y-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    @csrf @method('PUT')
    <div>
        <label class="mb-1 block text-sm font-medium">Nama</label>
        <input name="name" value="{{ old('name', $pembimbing->user->name) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email', $pembimbing->user->email) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Kata sandi baru (opsional)</label>
        <input type="password" name="password" class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Ulangi kata sandi</label>
        <input type="password" name="password_confirmation" class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">NIP</label>
        <input name="nip" value="{{ old('nip', $pembimbing->nip) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium">Telepon</label>
        <input name="phone" value="{{ old('phone', $pembimbing->phone) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2">
    </div>
    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">Perbarui</button>
</form>
@endsection
