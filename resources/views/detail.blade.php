@extends('layouts.app')

@section('content')

<!-- Breadcrumb -->
<div class="text-xs text-gray-400 font-medium py-5">
    <a href="{{ route('home') }}" class="hover:text-sigma transition-colors">Beranda</a>
    <span class="mx-2 text-gray-300">/</span>
    <a href="{{ route('home') }}#section-popular" class="hover:text-sigma transition-colors">Cari Makan</a>
    <span class="mx-2 text-gray-300">/</span>
    <span class="text-sigma font-semibold">{{ $menu->name }}</span>
</div>

<!-- ─── DETAIL PRODUK ─────────────────────────────────────── -->
<div class="flex flex-col lg:flex-row gap-10 lg:gap-14 mb-16">

    <!-- Gambar -->
    <div class="w-full lg:w-[55%] relative flex-shrink-0">
        <div class="rounded-[2rem] overflow-hidden bg-yellow-300 aspect-[4/3] lg:h-[480px]">
            <img src="{{ $menu->image_path }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
        </div>
        <!-- Badges -->
        <div class="absolute top-5 left-5 flex gap-2 flex-wrap">
            @if($menu->is_popular)
            <span class="bg-white text-gray-800 text-[10px] font-bold px-3 py-1.5 rounded-full shadow-md uppercase tracking-wider">Terlaris</span>
            @endif
            @if($menu->is_recommendation)
            <span class="bg-teal-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-full shadow-md uppercase tracking-wider">Nutrisi Terjaga</span>
            @endif
        </div>
    </div>

    <!-- Info -->
    <div class="flex-1 flex flex-col justify-center">
        <!-- UMKM label -->
        <div class="flex items-center gap-2 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#cf1c26"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">{{ $menu->umkm->name }}</span>
        </div>

        <h1 class="text-4xl lg:text-5xl font-black tracking-tight mb-3 leading-tight">{{ $menu->name }}</h1>
        <p class="text-3xl font-extrabold text-sigma mb-8">Rp{{ number_format($menu->price, 0, ',', '.') }}</p>

        <!-- Kartu Nutrisi -->
        <div class="bg-[#f9f8f5] border border-gray-100 rounded-2xl p-5 mb-7 shadow-sm">
            <div class="flex items-center gap-2 text-[11px] font-bold text-gray-500 mb-5 uppercase tracking-wider">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#008080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                Kandungan Nutrisi
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-white rounded-xl p-3 text-center border border-gray-50 shadow-sm">
                    <p class="text-2xl font-black text-gray-800">{{ $menu->calories ?? '–' }}</p>
                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Kcal</p>
                </div>
                <div class="bg-white rounded-xl p-3 text-center border border-teal-100 shadow-sm">
                    <p class="text-2xl font-black text-teal-600">{{ $menu->protein ?? '–' }}<span class="text-base font-bold">g</span></p>
                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Protein</p>
                </div>
                <div class="bg-white rounded-xl p-3 text-center border border-gray-50 shadow-sm">
                    <p class="text-2xl font-black text-gray-800">12<span class="text-base font-bold">g</span></p>
                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Lemak</p>
                </div>
            </div>
        </div>

        <!-- Alamat -->
        <div class="flex items-start gap-3 mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#cf1c26" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 shrink-0"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            <div>
                <p class="text-sm font-bold text-gray-800">Kantin Pusat Kampus</p>
                <p class="text-xs text-gray-400 mt-0.5">JL. Lingkar Kampus, Depok, Jawa Barat 16424</p>
            </div>
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="https://wa.me/6281234567890?text=Halo, saya mau pesan {{ urlencode($menu->name) }}"
               target="_blank"
               class="flex-1 bg-sigma hover:bg-sigma-dark text-white font-bold py-3.5 px-6 rounded-full transition-colors flex items-center justify-center gap-2 text-sm shadow-lg shadow-red-200/50">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.13 11.87a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                Pesan via WhatsApp
            </a>
            <button onclick="document.getElementById('map-section').scrollIntoView({behavior:'smooth'})"
                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3.5 px-6 rounded-full transition-colors flex items-center justify-center gap-2 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
                Lihat Lokasi
            </button>
        </div>
    </div>
</div>

<!-- ─── TENTANG MENU ──────────────────────────────────────── -->
<section class="mb-14">
    <h2 class="text-xl font-extrabold mb-4">Tentang Menu Ini</h2>
    <p class="text-gray-500 text-sm leading-relaxed max-w-2xl mb-6">
        {{ $menu->description }}
        Pilihan tepat untuk mahasiswa yang ingin tetap fit di tengah padatnya jadwal kuliah. Kami memastikan setiap porsi memiliki keseimbangan gizi maksimal dengan harga yang ramah di kantong.
    </p>
    <div class="flex flex-wrap gap-3">
        <span class="bg-blue-50 text-blue-600 text-[11px] font-bold px-4 py-2 rounded-full">Tanpa MSG</span>
        <span class="bg-blue-50 text-blue-600 text-[11px] font-bold px-4 py-2 rounded-full">Fresh Made Every Day</span>
        <span class="bg-blue-50 text-blue-600 text-[11px] font-bold px-4 py-2 rounded-full">Halal Certified</span>
    </div>
</section>

<!-- ─── PASANGAN SEMPURNA ─────────────────────────────────── -->
@php
    $pairings = \App\Models\Menu::with('umkm')
        ->where('id', '!=', $menu->id)
        ->inRandomOrder()
        ->limit(4)
        ->get();
@endphp
<section class="mb-16">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-xl font-extrabold">Pasangan Sempurna</h2>
            <p class="text-xs text-gray-400 mt-1">Lengkapi asupan nutrisimu dengan menu pendamping pilihan.</p>
        </div>
        <a href="{{ route('home') }}" class="text-sigma text-xs font-bold border-b border-sigma pb-0.5 hover:opacity-70 transition-opacity">Lihat Semua</a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        @foreach($pairings as $pair)
        <a href="{{ route('menu.detail', $pair->id) }}" class="group card-hover block">
            <div class="rounded-2xl overflow-hidden aspect-square mb-3 bg-gray-100 shadow-sm">
                <img src="{{ $pair->image_path }}" alt="{{ $pair->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
            <div class="flex justify-between items-start">
                <div class="flex-1 pr-2">
                    <h3 class="font-bold text-xs leading-tight mb-1 group-hover:text-sigma transition-colors">{{ $pair->name }}</h3>
                    <p class="text-sigma font-extrabold text-xs">Rp{{ number_format($pair->price, 0, ',', '.') }}</p>
                </div>
                <div class="bg-red-50 text-sigma w-6 h-6 rounded-full flex items-center justify-center shrink-0 hover:bg-sigma hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>

<!-- ─── PETA LOKASI ───────────────────────────────────────── -->
<section id="map-section" class="mb-4">
    <div class="relative h-64 md:h-80 rounded-3xl overflow-hidden bg-gradient-to-br from-teal-400 to-teal-600 flex items-end p-6 md:p-8">
        <!-- Grid pattern -->
        <div class="absolute inset-0 opacity-10"
             style="background-image: linear-gradient(rgba(255,255,255,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.5) 1px, transparent 1px); background-size: 40px 40px;">
        </div>
        <!-- Pin -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-[60%] pointer-events-none">
            <svg viewBox="0 0 24 24" width="80" height="80" fill="#cf1c26" class="drop-shadow-2xl">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Z"/>
                <circle cx="12" cy="9" r="2.8" fill="white"/>
            </svg>
        </div>

        <div class="relative z-10 bg-white/95 backdrop-blur-sm rounded-2xl p-5 max-w-xs shadow-xl">
            <h3 class="font-bold text-sm mb-1">Lokasi Strategis</h3>
            <p class="text-xs text-gray-500 leading-relaxed mb-4">Hanya 5 menit jalan kaki dari Perpustakaan Pusat.</p>
            <a href="https://maps.google.com" target="_blank"
               class="flex items-center gap-2 text-sigma text-xs font-bold hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 5H19V11"/><path d="M19 5L5 19"/></svg>
                Ambil Rute
            </a>
        </div>
    </div>
</section>

@endsection
