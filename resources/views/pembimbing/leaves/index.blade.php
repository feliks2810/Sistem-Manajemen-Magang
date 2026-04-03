@extends('layouts.panel')

@section('title', 'Izin & sakit — Pembimbing')
@section('page_title', 'Verifikasi izin & sakit')

@section('content')
<h1 class="mb-6 text-2xl font-bold text-slate-800">Verifikasi izin & sakit</h1>

<div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full text-left text-sm">
        <thead class="border-b border-slate-200 bg-slate-50">
            <tr>
                <th class="px-4 py-3">Peserta</th>
                <th class="px-4 py-3">Rentang</th>
                <th class="px-4 py-3">Jenis</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $lr)
                <tr class="border-b border-slate-100">
                    <td class="px-4 py-3">{{ $lr->pesertaProfile->user->name }}</td>
                    <td class="px-4 py-3">{{ $lr->tanggal_mulai->format('d/m/Y') }} – {{ $lr->tanggal_selesai->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">{{ $lr->jenis }}</td>
                    <td class="px-4 py-3">{{ $lr->status }}</td>
                    <td class="px-4 py-3"><a class="text-indigo-600 hover:underline" href="{{ route('pembimbing.leaves.show', $lr) }}">Detail</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada pengajuan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $rows->links() }}</div>
@endsection
