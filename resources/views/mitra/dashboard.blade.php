@extends('layouts.mitra')

@section('title', 'Dashboard Mitra - SIGMA')

@section('content')
<div class="mb-10">
    <h1 class="text-4xl font-black">Dashboard Mitra</h1>
    <p class="text-gray-600 text-lg mt-2">
        Kelola usaha dan menu UMKM Anda.
    </p>
</div>

@if($umkm)
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-[28px] p-7 shadow-sm">
            <p class="text-gray-500 font-bold">Nama UMKM</p>
            <h2 class="text-2xl font-black mt-3">{{ $umkm->nama_usaha }}</h2>
        </div>

        <div class="bg-green-100 rounded-[28px] p-7 shadow-sm">
            <p class="text-green-700 font-bold">Status</p>
            <h2 class="text-2xl font-black mt-3">{{ $umkm->status }}</h2>
        </div>

        <div class="bg-[#be1622] text-white rounded-[28px] p-7 shadow-sm">
            <p class="font-bold">Total Menu</p>
            <h2 class="text-4xl font-black mt-3">{{ $menus->count() }}</h2>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-8 mt-10">
        <div class="bg-[#f6eee8] rounded-[34px] p-8">
            <h2 class="text-2xl font-black">Aksi Cepat</h2>

            <div class="space-y-4 mt-6">
                <a href="{{ route('mitra.menu.create') }}"
                   class="block bg-[#be1622] text-white rounded-2xl p-5 font-black">
                    Tambah Menu Baru →
                </a>

                <a href="{{ route('mitra.menu.index') }}"
                   class="block bg-white rounded-2xl p-5 font-black text-[#be1622]">
                    Kelola Menu →
                </a>

                <a href="{{ route('mitra.profile') }}"
                   class="block bg-white rounded-2xl p-5 font-black text-[#be1622]">
                    Lihat Profil UMKM →
                </a>
            </div>
        </div>

        <div class="bg-[#f6eee8] rounded-[34px] p-8">
            <h2 class="text-2xl font-black">Info</h2>
            <p class="text-gray-600 leading-7 mt-4">
                Menu yang Anda tambahkan akan tampil ke halaman publik jika status menu aktif.
                Scanner AI digunakan saat menambahkan menu untuk membantu estimasi gizi.
            </p>
        </div>
    </div>
@else
    <div class="bg-[#f6eee8] rounded-[34px] p-10 text-center">
        <h2 class="text-3xl font-black">Belum Ada UMKM Aktif</h2>
        <p class="text-gray-500 mt-3">
            Daftar UMKM Anda masih perlu disetujui oleh Admin SIGMA.
        </p>
    </div>
@endif
@endsection