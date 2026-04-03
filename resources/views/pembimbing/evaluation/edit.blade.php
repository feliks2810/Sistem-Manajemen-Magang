@extends('layouts.panel')

@section('title', 'Rubrik penilaian — Pembimbing')
@section('page_title', 'Isi rubrik penilaian')

@section('content')
<h1 class="mb-2 text-2xl font-bold text-slate-800">Penilaian: {{ $peserta->user->name }}</h1>
<p class="mb-6 text-slate-600">NIM {{ $peserta->nim }}</p>

<form action="{{ route('pembimbing.evaluation.update', $peserta) }}" method="post" class="max-w-xl space-y-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    @csrf @method('PUT')
    @foreach($rubrics as $r)
        @php $sc = $scoresByRubric->get($r->id); @endphp
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700" for="nilai_{{ $r->id }}">{{ $r->nama }} (maks {{ $r->bobot_maks }})</label>
            <input type="number" step="0.01" min="0" max="{{ $r->bobot_maks }}" name="nilai_{{ $r->id }}" id="nilai_{{ $r->id }}"
                value="{{ old('nilai_'.$r->id, $sc?->nilai ?? null) }}" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2">
        </div>
    @endforeach
    <div>
        <label class="mb-1 block text-sm font-medium">Komentar akhir</label>
        <textarea name="komentar_final" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('komentar_final', $evaluation->komentar_final) }}</textarea>
    </div>
    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_final" value="1" @checked(old('is_final', $evaluation->is_final))>
        Tandai sebagai penilaian final
    </label>
    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">Simpan</button>
</form>
@endsection
