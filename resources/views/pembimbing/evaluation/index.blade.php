@extends('layouts.panel')

@section('title', 'Penilaian — Pembimbing')
@section('page_title', 'Penilaian magang')

@section('content')
<h1 class="mb-6 text-2xl font-bold text-slate-800">Penilaian magang</h1>

<div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full text-left text-sm">
        <thead class="border-b border-slate-200 bg-slate-50">
            <tr>
                <th class="px-4 py-3">NIM</th>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Total nilai</th>
                <th class="px-4 py-3">Final</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($peserta as $p)
                @php $ev = $p->evaluations->sortByDesc('id')->first(); @endphp
                <tr class="border-b border-slate-100">
                    <td class="px-4 py-3 font-mono">{{ $p->nim }}</td>
                    <td class="px-4 py-3">{{ $p->user->name }}</td>
                    <td class="px-4 py-3">{{ $ev?->total_nilai ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $ev?->is_final ? 'Ya' : 'Tidak' }}</td>
                    <td class="px-4 py-3"><a class="text-indigo-600 hover:underline" href="{{ route('pembimbing.evaluation.edit', $p) }}">Isi rubrik</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada peserta.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
