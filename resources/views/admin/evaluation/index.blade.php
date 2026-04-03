@extends('layouts.panel')

@section('title', 'Penilaian — Admin')
@section('page_title', 'Penilaian')

@section('content')
<div class="mb-4 flex flex-wrap items-center justify-between gap-3">
    <h1 class="text-xl font-bold text-slate-800">Monitoring penilaian</h1>
    <a href="{{ route('admin.penilaian.export', request()->query()) }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-800 hover:bg-slate-50">Export CSV</a>
</div>

<form method="get" class="mb-6">
    <label class="mb-1 block text-sm text-slate-600" for="peserta_id">Filter peserta</label>
    <select name="peserta_id" id="peserta_id" class="rounded-lg border border-slate-300 px-3 py-2" onchange="this.form.submit()">
        <option value="">Semua</option>
        @foreach($pesertaList as $p)
            <option value="{{ $p->id }}" @selected($pesertaId == $p->id)>{{ $p->nim }} — {{ $p->user->name }}</option>
        @endforeach
    </select>
</form>

<div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full text-left text-sm">
        <thead class="border-b border-slate-200 bg-slate-50">
            <tr>
                <th class="px-4 py-3">Peserta</th>
                <th class="px-4 py-3">Pembimbing</th>
                <th class="px-4 py-3">Total nilai</th>
                <th class="px-4 py-3">Final</th>
                <th class="px-4 py-3">Diperbarui</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $ev)
                <tr class="border-b border-slate-100">
                    <td class="px-4 py-3">{{ $ev->pesertaProfile->user->name }}</td>
                    <td class="px-4 py-3">{{ $ev->pembimbingProfile?->user?->name ?? '—' }}</td>
                    <td class="px-4 py-3 font-mono">{{ $ev->total_nilai ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $ev->is_final ? 'Ya' : 'Tidak' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $ev->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $rows->links() }}</div>
@endsection
