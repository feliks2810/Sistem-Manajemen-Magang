@extends('layouts.panel')

@section('title', 'Rubrik Penilaian — Pembimbing')
@section('page_title', 'Isi rubrik penilaian')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div class="flex items-center gap-4">
        @if($peserta->user->avatar_path)
            <img src="{{ route('storage.file', $peserta->user->avatar_path) }}" alt="Avatar" class="h-14 w-14 rounded-full object-cover border border-slate-200 shadow-sm ring-4 ring-slate-50">
        @else
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-100 text-lg font-bold tracking-wider text-blue-700 shadow-sm ring-4 ring-white">
                {{ strtoupper(substr($peserta->user->name, 0, 1)) }}
            </div>
        @endif
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $peserta->user->name }}</h1>
            <p class="mt-0.5 text-sm font-medium text-slate-500 font-mono">NIM {{ $peserta->nim ?? '-' }}</p>
        </div>
    </div>
    <a href="{{ route('pembimbing.evaluation.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">← Kembali ke daftar</a>
</div>

<div class="rounded-2xl border border-slate-200 bg-white shadow-sm md:max-w-3xl overflow-hidden">
    <div class="bg-slate-50/50 border-b border-slate-100 px-6 py-4 sm:px-8">
        <h2 class="text-lg font-bold text-slate-800">Formulir Rubrik Penilaian</h2>
        <p class="mt-1 text-sm text-slate-500">Isi nilai untuk setiap komponen sesuai dengan bobot maksimal yang ditentukan.</p>
    </div>

    <form action="{{ route('pembimbing.evaluation.update', $peserta) }}" method="post" class="p-6 sm:p-8 space-y-8">
        @csrf @method('PUT')
        
        <div class="space-y-6">
            @foreach($rubrics as $index => $r)
                @php $sc = $scoresByRubric->get($r->id); @endphp
                <div class="group flex flex-col sm:flex-row sm:items-center justify-between gap-4 rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 hover:border-slate-300">
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-slate-800 tracking-tight" for="nilai_{{ $r->id }}">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-100 text-xs font-semibold text-slate-500 mr-2">{{ $index + 1 }}</span>
                            {{ $r->nama }}
                        </label>
                        <p class="mt-1 ml-8 text-xs text-slate-500">Bobot maksimal: <span class="font-semibold text-slate-700 bg-slate-100 px-1.5 py-0.5 rounded">{{ $r->bobot_maks }}</span></p>
                    </div>
                    <div class="sm:w-40 flex-shrink-0">
                        <div class="relative">
                            <input type="number" step="0.01" min="0" max="{{ $r->bobot_maks }}" name="nilai_{{ $r->id }}" id="nilai_{{ $r->id }}"
                                value="{{ old('nilai_'.$r->id, $sc?->nilai ?? null) }}" required placeholder="0.00"
                                class="w-full rounded-xl border border-slate-300 py-2.5 pl-4 pr-10 text-right font-mono text-sm font-semibold text-slate-900 outline-none transition-all placeholder:font-normal placeholder:text-slate-300 focus:border-blue-500 focus:ring-0">
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <span class="text-sm font-medium text-slate-400">pt</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="border-t border-slate-100 pt-8">
            <label class="mb-2 block text-sm font-bold text-slate-800">Komentar Akhir <span class="text-xs font-normal text-slate-400 ml-1">(Catatan evaluasi untuk peserta)</span></label>
            <textarea name="komentar_final" rows="4" placeholder="Tuliskan umpan balik atau komentar evaluasi kinerja peserta di sini..." class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition-all placeholder:text-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-slate-50/50 focus:bg-white">{{ old('komentar_final', $evaluation->komentar_final) }}</textarea>
        </div>

        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 h-16 w-16 rounded-full bg-amber-100/50"></div>
            <label class="relative flex items-start gap-3 cursor-pointer">
                <div class="flex h-6 items-center">
                    <input type="checkbox" name="is_final" value="1" @checked(old('is_final', $evaluation->is_final)) class="h-5 w-5 rounded border-amber-300 text-amber-600 focus:ring-amber-600 focus:ring-2 focus:ring-offset-1 transition-all cursor-pointer">
                </div>
                <div>
                    <span class="block text-sm font-bold text-amber-900">Tandai sebagai Penilaian Final</span>
                    <span class="block text-xs font-medium text-amber-700/80 mt-0.5">Jika ditandai final, nilai akan dibekukan dan dapat dicetak ke dalam sertifikat peserta.</span>
                </div>
            </label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('pembimbing.evaluation.index') }}" class="rounded-xl px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100 transition-colors">Batal</a>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 hover:bg-blue-700 transition-all">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Penilaian
            </button>
        </div>
    </form>
</div>
@endsection
