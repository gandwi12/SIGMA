@extends('layouts.app')

@section('content')

{{-- ── HERO ──────────────────────────────────────────── --}}
<section class="relative -mx-6 lg:-mx-16 mb-10 overflow-hidden">

    {{-- Background --}}
    <div class="relative bg-gradient-to-br from-[#2D3748] to-[#1a2333] min-h-[300px] px-6 lg:px-16 pt-12 pb-32 flex items-center">
        <div class="absolute inset-0">
            @if($umkm->foto)
            <img src="{{ Storage::url($umkm->foto) }}" alt="{{ $umkm->name }}"
                 class="w-full h-full object-cover opacity-25">
            @endif
            <div class="absolute inset-0 bg-gradient-to-r from-[#2D3748]/90 via-[#2D3748]/70 to-transparent"></div>
        </div>

        <div class="relative max-w-[1400px] mx-auto w-full">
            {{-- Back --}}
            <a href="{{ route('daftar-umkm') }}" class="inline-flex items-center gap-2 text-white/60 hover:text-white text-sm font-semibold mb-6 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
                Daftar UMKM
            </a>

            <div class="flex items-start gap-6">
                {{-- Logo/Icon --}}
                <div class="w-20 h-20 bg-white rounded-2xl shadow-xl flex items-center justify-center text-sigma shrink-0">
                    @if($umkm->foto)
                    <img src="{{ Storage::url($umkm->foto) }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover rounded-2xl">
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/><path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"/><path d="M12 3v6"/></svg>
                    @endif
                </div>
                <div>
                    <span class="inline-block bg-[#008B92] text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full mb-2">
                        {{ $umkm->kategori ?? 'Kuliner' }}
                    </span>
                    <h1 class="text-3xl lg:text-4xl font-black text-white leading-tight mb-2">{{ $umkm->name }}</h1>
                    @if($umkm->description)
                    <p class="text-white/60 text-sm max-w-xl line-clamp-2">{{ $umkm->description }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Wave --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 60L1440 60L1440 20C1200 55 960 5 720 25C480 45 240 10 0 40L0 60Z" fill="#FDF8F3"/>
        </svg>
    </div>
</section>

{{-- ── INFO CARDS ────────────────────────────────────── --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">

    @if($umkm->lokasi)
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-sigma mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">Lokasi</p>
        <p class="text-sm font-semibold text-[#2D3748] leading-snug">{{ $umkm->lokasi }}</p>
    </div>
    @endif

    @if($umkm->jam_operasional)
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="w-10 h-10 bg-teal-50 rounded-xl flex items-center justify-center text-[#008B92] mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">Jam Buka</p>
        <p class="text-sm font-semibold text-[#2D3748]">{{ $umkm->jam_operasional }}</p>
    </div>
    @endif

    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/><path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"/><path d="M12 3v6"/></svg>
        </div>
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">Total Menu</p>
        <p class="text-sm font-semibold text-[#2D3748]">{{ $umkm->menus->count() }} Menu</p>
    </div>

    @if($umkm->whatsapp)
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center text-green-500 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 1.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.69a16 16 0 0 0 6 6l1.27-.73a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        </div>
        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">WhatsApp</p>
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->whatsapp) }}" target="_blank"
           class="text-sm font-semibold text-green-500 hover:underline">{{ $umkm->whatsapp }}</a>
    </div>
    @endif
</div>

{{-- ── CTA WA ────────────────────────────────────────── --}}
@if($umkm->whatsapp)
<div class="flex gap-3 mb-10">
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->whatsapp) }}" target="_blank"
       class="inline-flex items-center gap-2.5 bg-[#25D366] hover:bg-[#1da851] text-white font-bold py-3 px-7 rounded-full text-sm transition-all shadow-lg shadow-green-300/40">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
        Hubungi via WhatsApp
    </a>
    <a href="{{ route('daftar-umkm') }}"
       class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:border-sigma text-gray-600 hover:text-sigma font-bold py-3 px-7 rounded-full text-sm transition-all">
        ← Kembali ke Daftar
    </a>
</div>
@endif

{{-- ── MENU LIST ─────────────────────────────────────── --}}
@if($umkm->menus->count() > 0)
<div class="mb-6">
    <div class="flex items-end justify-between mb-6">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-widest text-sigma mb-1">Katalog</p>
            <h2 class="text-2xl font-extrabold text-[#2D3748]">Menu dari {{ $umkm->name }}</h2>
        </div>
        <span class="text-sm text-gray-400">{{ $umkm->menus->count() }} item</span>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-5">
        @foreach($umkm->menus as $menu)
        <a href="{{ route('menu.detail', $menu->id) }}"
           class="group block bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="aspect-square overflow-hidden bg-gray-100">
                <img src="{{ $menu->image_path }}" alt="{{ $menu->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
            <div class="p-4">
                @if($menu->category)
                <span class="inline-block bg-red-50 text-sigma text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full mb-2">{{ $menu->category }}</span>
                @endif
                <h3 class="font-bold text-sm leading-tight mb-1 group-hover:text-sigma transition-colors line-clamp-2">{{ $menu->name }}</h3>
                <p class="text-sigma font-extrabold text-sm mb-2">Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
                <div class="flex gap-3 text-[10px] text-gray-400 font-semibold">
                    @if($menu->calories)<span>{{ $menu->calories }} kal</span>@endif
                    @if($menu->protein)<span>{{ $menu->protein }}g protein</span>@endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@else
<div class="py-20 text-center">
    <div class="text-5xl mb-4">🍽️</div>
    <p class="font-bold text-gray-500">Belum ada menu yang tersedia</p>
</div>
@endif

@endsection
