@extends('layouts.panel')

@section('title', 'Penilaian — Admin')
@section('page_title', 'Penilaian')

@section('content')
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Monitoring Penilaian</h1>
        <p class="mt-1 text-sm text-slate-500">Tinjau seluruh hasil evaluasi & penilaian kinerja peserta magang.</p>
    </div>
</div>

<div class="mb-6 rounded-[14px] bg-white p-5 shadow-sm border border-slate-200/80">
    <form method="get" class="m-0 flex flex-col sm:flex-row gap-4">
        {{-- Pembimbing Dropdown --}}
        <div class="flex-1">
            <label class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-500" for="pembimbing_id">Filter Pembimbing</label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <select name="pembimbing_id" id="pembimbing_id" onchange="document.getElementById('peserta_id').value=''; this.form.submit()" 
                    class="block w-full appearance-none rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-10 text-sm text-slate-900 transition-colors focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 cursor-pointer">
                    <option value="">-- Semua Pembimbing --</option>
                    @foreach($pembimbingList as $pb)
                        <option value="{{ $pb->id }}" @selected($pembimbingId == $pb->id)>{{ $pb->user->name }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
        </div>

        {{-- Peserta Dropdown --}}
        <div class="flex-1">
            <label class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-500" for="peserta_id">Filter Peserta</label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                </div>
                <select name="peserta_id" id="peserta_id" onchange="this.form.submit()" {{ empty($pembimbingId) ? 'disabled' : '' }}
                    class="block w-full appearance-none rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-10 text-sm text-slate-900 transition-colors focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 cursor-pointer disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400 disabled:opacity-70 disabled:hover:border-slate-200">
                    <option value="">{{ empty($pembimbingId) ? '-- Pilih Pembimbing Terlebih Dahulu --' : '-- Semua Peserta --' }}</option>
                    @foreach($pesertaList as $p)
                        <option value="{{ $p->id }}" @selected($pesertaId == $p->id)>{{ $p->nim }} — {{ $p->user->name }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="overflow-hidden rounded-[14px] border border-slate-200/80 bg-white shadow-sm transition-all">
    <div class="overflow-x-auto" x-data>
        <table class="min-w-full text-left text-sm whitespace-nowrap">
            <thead class="border-b border-slate-200 bg-slate-50/70">
                <tr>
                    <th class="px-5 py-4 font-semibold text-slate-800">Peserta</th>
                    <th class="px-5 py-4 font-semibold text-slate-800">Pembimbing</th>
                    <th class="px-5 py-4 text-right font-semibold text-slate-800">Total Nilai</th>
                    <th class="px-5 py-4 font-semibold text-slate-800 whitespace-nowrap">Status Final</th>
                    <th class="px-5 py-4 font-semibold text-slate-800">Diperbarui</th>
                    <th class="px-5 py-4 font-semibold text-slate-800 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($rows as $ev)
                    <tr class="transition-colors hover:bg-slate-50/70 group">
                        <td class="px-5 py-4 font-medium text-slate-900 group-hover:text-blue-700">{{ $ev->pesertaProfile->user->name }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $ev->pembimbingProfile?->user?->name ?? '—' }}</td>
                        <td class="px-5 py-4 text-right">
                            <span class="inline-block rounded-lg {{ $ev->total_nilai ? 'bg-slate-50 border border-slate-200/60' : '' }} px-2.5 py-1.5 font-mono text-sm font-semibold text-slate-800">
                                {{ $ev->total_nilai ?? '—' }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            @if($ev->is_final)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Ya
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-500/10">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                    Tidak
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-slate-500 tabular-nums">{{ $ev->updated_at->format('d/m/Y H:i') }}</td>
                        <td class="px-5 py-4 text-center">
                            <button type="button" onclick="toggleDetail('detail-row-{{ $ev->id }}')" class="inline-flex items-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 transition hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span id="btn-text-{{ $ev->id }}">Info Detail</span>
                            </button>
                        </td>
                    </tr>
                    <tr id="detail-row-{{ $ev->id }}" style="display: none;" class="bg-indigo-50/30 border-t-0">
                        <td colspan="6" class="p-0">
                            <div class="px-6 py-5">
                                <h4 class="mb-3 text-sm font-bold text-slate-800">Rincian Penilaian :</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                    @forelse($ev->rubricScores as $score)
                                        <div class="rounded-xl border border-slate-200 bg-white p-3.5 shadow-sm transition-shadow hover:shadow-md">
                                            <div class="text-xs font-medium text-slate-500 uppercase tracking-wide">{{ $score->rubric->name ?? 'Kriteria' }}</div>
                                            <div class="mt-1 text-2xl font-bold text-slate-900">{{ $score->nilai }}</div>
                                        </div>
                                    @empty
                                        <div class="text-sm text-slate-500 italic py-2">Belum ada rincian nilai.</div>
                                    @endforelse
                                </div>
                                @if($ev->komentar_final)
                                    <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4">
                                        <h5 class="text-xs font-bold uppercase tracking-wide text-amber-800 mb-1">Komentar Pembimbing</h5>
                                        <p class="text-sm text-amber-900">{{ $ev->komentar_final }}</p>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="h-10 w-10 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Belum ada data penilaian.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $rows->links() }}</div>
@endsection

@push('scripts')
<script>
    function toggleDetail(rowId) {
        const row = document.getElementById(rowId);
        const btnId = rowId.replace('detail-row-', '');
        const btnText = document.getElementById('btn-text-' + btnId);
        
        if (row.style.display === 'none') {
            row.style.display = 'table-row';
            if (btnText) btnText.textContent = 'Tutup';
        } else {
            row.style.display = 'none';
            if (btnText) btnText.textContent = 'Info Detail';
        }
    }
</script>
@endpush
