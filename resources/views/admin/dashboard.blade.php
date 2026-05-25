@extends('layouts.admin')

@section('title', 'Dashboard Admin - SIGMA')

@section('content')
<div class="mb-10">
    <h1 class="text-4xl font-black">Dashboard Admin SIGMA</h1>
    <p class="text-gray-600 text-lg mt-2">
        Pantau aktivitas platform, UMKM, dan menu yang terdaftar.
    </p>
</div>

<div class="grid md:grid-cols-4 gap-6">
    <div class="bg-white rounded-[28px] p-7 shadow-sm">
        <p class="text-gray-500 font-bold">Total UMKM</p>
        <h2 class="text-4xl font-black mt-3">{{ $totalUmkm }}</h2>
    </div>

    <div class="bg-yellow-100 rounded-[28px] p-7 shadow-sm">
        <p class="text-yellow-700 font-bold">Menunggu Approval</p>
        <h2 class="text-4xl font-black mt-3">{{ $pendingUmkm }}</h2>
    </div>

    <div class="bg-green-100 rounded-[28px] p-7 shadow-sm">
        <p class="text-green-700 font-bold">UMKM Aktif</p>
        <h2 class="text-4xl font-black mt-3">{{ $activeUmkm }}</h2>
    </div>

    <div class="bg-[#be1622] text-white rounded-[28px] p-7 shadow-sm">
        <p class="font-bold">Total Menu</p>
        <h2 class="text-4xl font-black mt-3">{{ $totalMenu }}</h2>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-8 mt-10">
    <div class="bg-[#f6eee8] rounded-[34px] p-8">
        <h2 class="text-2xl font-black">Tugas Admin</h2>

        <div class="space-y-4 mt-6">
            <a href="{{ route('admin.umkm.index') }}"
               class="block bg-white rounded-2xl p-5 font-black text-[#be1622]">
                Review UMKM Baru →
            </a>

            <a href="{{ route('admin.menu.monitoring') }}"
               class="block bg-white rounded-2xl p-5 font-black text-[#be1622]">
                Monitoring Menu →
            </a>
        </div>
    </div>

    <div class="bg-[#f6eee8] rounded-[34px] p-8">
        <h2 class="text-2xl font-black">Catatan Alur</h2>

        <p class="text-gray-600 leading-7 mt-4">
            UMKM yang daftar akan masuk status pending. Admin SIGMA wajib melakukan review.
            Setelah disetujui, UMKM menjadi aktif dan bisa mengelola menu melalui dashboard mitra.
        </p>
    </div>
</div>
@endsection