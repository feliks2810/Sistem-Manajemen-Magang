@extends('layouts.panel')

@section('title', 'Riwayat absensi — Peserta')
@section('page_title', 'Riwayat absensi')

@section('content')
<h1 class="mb-6 text-2xl font-bold text-slate-800">Riwayat absensi</h1>

<div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full text-left text-sm">
        <thead class="border-b border-slate-200 bg-slate-50">
            <tr>
                <th class="px-4 py-3">Tanggal</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Check-in</th>
                <th class="px-4 py-3">Check-out</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $r)
                <tr class="border-b border-slate-100">
                    <td class="px-4 py-3 font-mono">{{ $r->tanggal->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">{{ $r->status }}</td>
                    <td class="px-4 py-3">{{ $r->check_in_at?->format('H:i') ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $r->check_out_at?->format('H:i') ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $rows->links() }}</div>
@endsection
