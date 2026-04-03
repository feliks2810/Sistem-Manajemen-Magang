@extends('layouts.panel')

@section('title', 'Sertifikat — Admin')
@section('page_title', 'Sertifikat')

@section('content')
<p class="mb-2 text-slate-600">Generate sertifikat PDF berdasarkan kehadiran dan nilai akhir (penilaian final pembimbing).</p>

<div class="mt-6 max-w-xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <form action="{{ route('admin.sertifikat.generate') }}" method="post" class="space-y-4">
        @csrf
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700" for="peserta_profile_id">Pilih peserta</label>
            <select name="peserta_profile_id" id="peserta_profile_id" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                @forelse($pesertaList as $p)
                    <option value="{{ $p->id }}">{{ $p->nim }} — {{ $p->user->name }}</option>
                @empty
                    <option value="" disabled>Belum ada peserta</option>
                @endforelse
            </select>
        </div>
        <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2.5 font-medium text-white hover:bg-indigo-700">Generate PDF</button>
    </form>
</div>
@endsection
