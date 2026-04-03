@extends('layouts.panel')

@section('title', 'Sertifikat — Peserta')
@section('page_title', 'Hasil & sertifikat')

@section('content')
<h1 class="mb-6 text-2xl font-bold text-slate-800">Hasil & sertifikat</h1>

@if($message)
    <p class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-amber-900">{{ $message }}</p>
@elseif($certificate)
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="mb-2"><strong>Nomor:</strong> {{ $certificate->nomor_sertifikat }}</p>
        <p class="mb-2"><strong>Kehadiran:</strong> {{ $certificate->kehadiran_persen }}%</p>
        <p class="mb-4"><strong>Nilai akhir:</strong> {{ $certificate->nilai_akhir }}</p>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('peserta.certificate.download') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">Download PDF</a>
            <form action="{{ route('peserta.certificate.refresh') }}" method="post">
                @csrf
                <button type="submit" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-slate-800 hover:bg-slate-50">Perbarui sertifikat</button>
            </form>
        </div>
    </div>
@endif
@endsection
