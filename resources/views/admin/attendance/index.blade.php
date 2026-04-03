@extends('layouts.panel')

@section('title', 'Absensi — Admin')
@section('page_title', 'Absensi')

@section('content')
<h1 class="mb-6 text-xl font-bold text-slate-800">Monitoring absensi</h1>

<form method="get" class="mb-6 flex flex-wrap items-end gap-3">
    <div>
        <label class="mb-1 block text-sm text-slate-600" for="peserta_id">Filter peserta</label>
        <select name="peserta_id" id="peserta_id" class="rounded-lg border border-slate-300 px-3 py-2" onchange="this.form.submit()">
            <option value="">Semua</option>
            @foreach($pesertaList as $p)
                <option value="{{ $p->id }}" @selected($pesertaId == $p->id)>{{ $p->nim }} — {{ $p->user->name }}</option>
            @endforeach
        </select>
    </div>
</form>

<div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full text-left text-sm">
        <thead class="border-b border-slate-200 bg-slate-50">
            <tr>
                <th class="px-4 py-3">Tanggal</th>
                <th class="px-4 py-3">Peserta</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Check-in</th>
                <th class="px-4 py-3">Check-out</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $r)
                <tr class="border-b border-slate-100">
                    <td class="px-4 py-3 font-mono">{{ $r->tanggal->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">{{ $r->pesertaProfile->user->name }}</td>
                    <td class="px-4 py-3">
                        <span class="rounded px-2 py-0.5 text-xs font-medium
                            @if($r->status==='hadir') bg-emerald-100 text-emerald-800
                            @elseif($r->status==='izin') bg-amber-100 text-amber-800
                            @elseif($r->status==='sakit') bg-blue-100 text-blue-800
                            @else bg-slate-100 text-slate-700 @endif">{{ $r->status }}</span>
                    </td>
                    <td class="px-4 py-3 text-slate-600">{{ $r->check_in_at?->format('H:i') ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $r->check_out_at?->format('H:i') ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $rows->links() }}</div>
@endsection
