@extends('layouts.panel')

@section('title', 'Pembimbing — Admin')
@section('page_title', 'Manajemen akun pembimbing')

@section('content')
<div class="mb-4 flex flex-wrap items-center justify-between gap-3">
    <h1 class="text-xl font-bold text-slate-800">Daftar pembimbing</h1>
    <a href="{{ route('admin.pembimbing.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Tambah</a>
</div>

<div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full text-left text-sm">
        <thead class="border-b border-slate-200 bg-slate-50">
            <tr>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">NIP</th>
                <th class="px-4 py-3">Jumlah peserta</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembimbing as $p)
                <tr class="border-b border-slate-100">
                    <td class="px-4 py-3">{{ $p->user->name }}</td>
                    <td class="px-4 py-3">{{ $p->user->email }}</td>
                    <td class="px-4 py-3">{{ $p->nip ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $p->peserta_bimbingan_count }}</td>
                    <td class="px-4 py-3 text-right">
                        <a class="text-indigo-600 hover:underline" href="{{ route('admin.pembimbing.edit', $p) }}">Edit</a>
                        <form action="{{ route('admin.pembimbing.destroy', $p) }}" method="post" class="inline" onsubmit="return confirm('Nonaktifkan pembimbing? Data peserta tetap aman.');">
                            @csrf @method('DELETE')
                            <button type="submit" class="ml-2 text-amber-700 hover:underline">Hapus (soft)</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $pembimbing->links() }}</div>
@endsection
