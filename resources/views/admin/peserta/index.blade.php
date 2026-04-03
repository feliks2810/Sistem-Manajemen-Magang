@extends('layouts.panel')

@section('title', 'Peserta magang — Admin')
@section('page_title', 'Manajemen peserta magang')

@section('content')
<div class="mb-4 flex flex-wrap items-center justify-between gap-3">
    <h1 class="text-xl font-bold text-slate-800">Daftar peserta</h1>
    <a href="{{ route('admin.peserta.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Tambah</a>
</div>

<div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full text-left text-sm">
        <thead class="border-b border-slate-200 bg-slate-50">
            <tr>
                <th class="px-4 py-3">NIM</th>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Pembimbing</th>
                <th class="px-4 py-3">Periode</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($peserta as $p)
                <tr class="border-b border-slate-100">
                    <td class="px-4 py-3 font-mono">{{ $p->nim }}</td>
                    <td class="px-4 py-3">{{ $p->user->name }}</td>
                    <td class="px-4 py-3">{{ $p->pembimbing?->user?->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $p->periode_mulai->format('d/m/Y') }} – {{ $p->periode_selesai->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-right">
                        <a class="text-indigo-600 hover:underline" href="{{ route('admin.peserta.edit', $p) }}">Edit</a>
                        <form action="{{ route('admin.peserta.destroy', $p) }}" method="post" class="inline" onsubmit="return confirm('Hapus peserta ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="ml-2 text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $peserta->links() }}</div>
@endsection
