@extends('layouts.app')

@section('title', $umkm->nama_usaha . ' - SIGMA')

@section('content')

{{-- BACK BUTTON --}}
<div class="px-8 lg:px-12 xl:px-16 pt-6">
    <a href="{{ url()->previous() }}"
       class="inline-flex items-center gap-3 bg-[#be1622] text-white px-7 py-4 rounded-full font-black shadow-lg hover:bg-[#a9131d] transition">
        ← Kembali
    </a>
</div>

<section class="mt-8">
    <div class="relative h-[540px] w-full overflow-hidden">
        <img src="{{ $umkm->image_url }}"
             class="w-full h-full object-cover"
             alt="{{ $umkm->nama_usaha }}">

        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/25 to-transparent"></div>

        <div class="absolute bottom-14 left-8 lg:left-16 text-white max-w-4xl">
            <p class="text-sm font-black tracking-[3px] mb-4">
                WARUNG TERKURASI SIGMA
            </p>

            <h1 class="text-5xl lg:text-7xl font-black leading-tight">
                {{ $umkm->nama_usaha }}
            </h1>

            <p class="mt-4 text-lg lg:text-xl font-semibold max-w-3xl">
                {{ $umkm->deskripsi ?? 'Tradisi rasa yang tak tergerus zaman.' }}
            </p>
        </div>
    </div>
</section>

<section class="px-8 lg:px-12 xl:px-16 py-20">
    <div class="grid lg:grid-cols-[1.15fr_.85fr] gap-14 items-center">
        <div>
            <p class="text-[#be1622] text-xs font-black tracking-[5px] mb-5">
                SEJARAH & WARISAN
            </p>

            <h2 class="text-4xl lg:text-5xl font-black leading-tight max-w-2xl">
                {{ $umkm->sejarah_judul ?: 'Menjaga Nyala Pawon Sejak 1974' }}
            </h2>

            @if($umkm->sejarah_deskripsi)
                <p class="text-gray-600 leading-8 mt-8 max-w-4xl">
                    {{ $umkm->sejarah_deskripsi }}
                </p>
            @else
                <p class="text-gray-600 leading-8 mt-8 max-w-4xl">
                    Berawal dari sebuah kedai kecil di sudut pasar, {{ $umkm->nama_usaha }}
                    menghadirkan cita rasa rumahan yang hangat, sederhana, dan dekat dengan kehidupan mahasiswa.
                    Setiap menu disiapkan dengan bahan pilihan dan harga yang tetap ramah kantong.
                </p>

                <p class="text-gray-600 leading-8 mt-5 max-w-4xl">
                    Kami percaya makanan bukan hanya soal kenyang, tapi juga tentang rasa, kenyamanan,
                    dan kepercayaan. Karena itu, setiap hidangan dibuat dengan standar kebersihan dan cita rasa yang konsisten.
                </p>
            @endif

            <div class="grid grid-cols-3 gap-10 mt-12 max-w-2xl">
                <div>
                    <h3 class="text-[#be1622] text-4xl font-black">
                        {{ $umkm->stat_1_value ?: '50th' }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $umkm->stat_1_label ?: 'Tahun Tradisi' }}
                    </p>
                </div>

                <div>
                    <h3 class="text-[#be1622] text-4xl font-black">
                        {{ $umkm->stat_2_value ?: '100%' }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $umkm->stat_2_label ?: 'Resep Autentik' }}
                    </p>
                </div>

                <div>
                    <h3 class="text-[#be1622] text-4xl font-black">
                        {{ $umkm->stat_3_value ?: 'Zero' }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $umkm->stat_3_label ?: 'MSG Tambahan' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-[#f6eee8] rounded-[34px] p-10 shadow-sm">
            <h3 class="text-[#be1622] text-2xl font-black mb-8">
                Filosofi Kami
            </h3>

            <div class="space-y-8">
                <div class="flex gap-5">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-[#be1622] grid place-items-center shrink-0">✦</div>
                    <div>
                        <h4 class="font-black text-lg">
                            {{ $umkm->filosofi_1_judul ?: 'Bahan Lokal Segar' }}
                        </h4>
                        <p class="text-sm text-gray-600 mt-2">
                            {{ $umkm->filosofi_1_deskripsi ?: 'Mengutamakan bahan dari pasar sekitar untuk menjaga kesegaran.' }}
                        </p>
                    </div>
                </div>

                <div class="flex gap-5">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-[#be1622] grid place-items-center shrink-0">✦</div>
                    <div>
                        <h4 class="font-black text-lg">
                            {{ $umkm->filosofi_2_judul ?: 'Slow-Cooked Mastery' }}
                        </h4>
                        <p class="text-sm text-gray-600 mt-2">
                            {{ $umkm->filosofi_2_deskripsi ?: 'Bumbu dimasak perlahan agar rasa lebih meresap.' }}
                        </p>
                    </div>
                </div>

                <div class="flex gap-5">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-[#be1622] grid place-items-center shrink-0">✦</div>
                    <div>
                        <h4 class="font-black text-lg">
                            {{ $umkm->filosofi_3_judul ?: 'Tanpa Pengawet' }}
                        </h4>
                        <p class="text-sm text-gray-600 mt-2">
                            {{ $umkm->filosofi_3_deskripsi ?: 'Menu disajikan fresh setiap hari untuk mahasiswa.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@php
    $featured = $umkm->menus->where('status', 'Aktif')->first() ?? $umkm->menus->first();
@endphp

@if($featured)
<section class="px-8 lg:px-12 xl:px-16 py-20 bg-[#f6eee8]/55">
    <div class="grid lg:grid-cols-2 gap-14 items-center">
        <div>
            <img src="{{ $featured->image_url }}"
                 class="w-full h-[460px] object-cover rounded-[38px] shadow-2xl"
                 alt="{{ $featured->nama }}">
        </div>

        <div>
            <p class="text-[#be1622] text-xs font-black tracking-[5px] mb-5">
                MENU ANDALAN
            </p>

            <h2 class="text-5xl lg:text-6xl font-black leading-tight">
                {{ $featured->nama }}
            </h2>

            <p class="text-gray-600 leading-8 mt-6 max-w-2xl">
                {{ $featured->deskripsi }}
            </p>

            <div class="flex gap-3 mt-6">
                <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-xs font-bold">
                    {{ $featured->tag }}
                </span>

                <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-xs font-bold">
                    Menu Andalan
                </span>
            </div>

            <div class="flex flex-wrap gap-4 mt-9">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->whatsapp) }}"
                   target="_blank"
                   class="bg-[#be1622] text-white px-8 py-4 rounded-full font-black shadow-lg">
                    Pesan Sekarang — Rp{{ number_format($featured->harga, 0, ',', '.') }}
                </a>

                <a href="{{ route('menu.show', $featured->id) }}"
                   class="bg-[#e8e1dc] px-8 py-4 rounded-full font-black">
                    Detail Menu
                </a>
            </div>
        </div>
    </div>
</section>
@endif

<section id="menu-umkm" class="px-8 lg:px-12 xl:px-16 py-20">
    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-end gap-8 mb-12">
        <div>
            <h2 class="text-4xl lg:text-5xl font-black">Daftar Menu Kami</h2>
            <p class="text-gray-500 mt-2">
                Kualitas premium dengan harga mahasiswa.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <button type="button"
                    class="menu-filter bg-[#be1622] text-white px-5 py-2 rounded-full text-xs font-black"
                    data-filter="semua">
                Semua
            </button>

            <button type="button"
                    class="menu-filter bg-[#f6eee8] px-5 py-2 rounded-full text-xs font-black"
                    data-filter="ayam">
                Ayam
            </button>

            <button type="button"
                    class="menu-filter bg-[#f6eee8] px-5 py-2 rounded-full text-xs font-black"
                    data-filter="sayur">
                Sayur
            </button>

            <button type="button"
                    class="menu-filter bg-[#f6eee8] px-5 py-2 rounded-full text-xs font-black"
                    data-filter="protein">
                Protein
            </button>

            <button type="button"
                    class="menu-filter bg-[#f6eee8] px-5 py-2 rounded-full text-xs font-black"
                    data-filter="hemat">
                Hemat
            </button>

            <button type="button"
                    class="menu-filter bg-[#f6eee8] px-5 py-2 rounded-full text-xs font-black"
                    data-filter="best seller">
                Best Seller
            </button>
        </div>
    </div>

    <div id="menuGrid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-9">
        @forelse($umkm->menus->where('status', 'Aktif') as $menu)
            @php
                $menuKeyword = strtolower(
                    $menu->nama . ' ' .
                    $menu->tag . ' ' .
                    $menu->deskripsi . ' ' .
                    $menu->badge_1 . ' ' .
                    $menu->badge_2 . ' ' .
                    $menu->badge_3
                );
            @endphp

            <a href="{{ route('menu.show', $menu->id) }}"
               class="menu-card bg-[#f6eee8] rounded-[30px] overflow-hidden hover:scale-[1.02] transition"
               data-keyword="{{ $menuKeyword }}">

                <img src="{{ $menu->image_url }}"
                     class="w-full h-[270px] object-cover"
                     alt="{{ $menu->nama }}">

                <div class="p-7">
                    <div class="flex justify-between gap-4">
                        <h3 class="text-2xl font-black">{{ $menu->nama }}</h3>

                        <p class="text-[#be1622] font-black whitespace-nowrap">
                            Rp{{ number_format($menu->harga, 0, ',', '.') }}
                        </p>
                    </div>

                    <p class="text-sm text-gray-600 leading-6 mt-3">
                        {{ Str::limit($menu->deskripsi, 90) }}
                    </p>

                    <div class="flex flex-wrap gap-2 mt-5">
                        <span class="inline-block bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-xs font-bold">
                            {{ $menu->tag }}
                        </span>

                        @if($menu->protein)
                            <span class="inline-block bg-white text-gray-600 px-4 py-1 rounded-full text-xs font-bold">
                                {{ $menu->protein }}g Protein
                            </span>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="md:col-span-2 lg:col-span-3 bg-[#f6eee8] rounded-[30px] p-12 text-center">
                <h3 class="text-2xl font-black">Belum ada menu aktif</h3>
            </div>
        @endforelse
    </div>

    <div id="emptyFilter"
         class="hidden bg-[#f6eee8] rounded-[30px] p-12 text-center mt-8">
        <h3 class="text-2xl font-black">Menu kategori ini belum tersedia</h3>
        <p class="text-gray-500 mt-2">
            Coba pilih kategori lain.
        </p>
    </div>
</section>

<section class="px-8 lg:px-12 xl:px-16 py-20">
    <div class="grid lg:grid-cols-[.9fr_1.1fr] gap-14 items-center">
        <div>
            <h2 class="text-5xl lg:text-6xl font-black mb-14">
                Informasi & Lokasi
            </h2>

            <div class="space-y-10">
                <div class="flex gap-5">
                    <div class="w-14 h-14 rounded-full bg-red-100 text-[#be1622] grid place-items-center text-xl">⏰</div>
                    <div>
                        <h4 class="font-black text-xl">Jam Operasional</h4>
                        <p class="text-gray-600 text-lg leading-8">{{ $umkm->jam_operasional }}</p>
                    </div>
                </div>

                <div class="flex gap-5">
                    <div class="w-14 h-14 rounded-full bg-red-100 text-[#be1622] grid place-items-center text-xl">📍</div>
                    <div>
                        <h4 class="font-black text-xl">Alamat Presisi</h4>
                        <p class="text-gray-600 text-lg leading-8">{{ $umkm->alamat }}</p>
                    </div>
                </div>

                <div class="flex gap-5">
                    <div class="w-14 h-14 rounded-full bg-red-100 text-[#be1622] grid place-items-center text-xl">✦</div>
                    <div>
                        <h4 class="font-black text-xl">Fasilitas & Sertifikasi</h4>
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span class="bg-[#e8e1dc] px-4 py-2 rounded-full text-sm font-semibold">
                                {{ $umkm->fasilitas_1 ?: 'Free Wi-Fi' }}
                            </span>

                            <span class="bg-[#e8e1dc] px-4 py-2 rounded-full text-sm font-semibold">
                                {{ $umkm->fasilitas_2 ?: 'Halal Certified' }}
                            </span>

                            <span class="bg-[#e8e1dc] px-4 py-2 rounded-full text-sm font-semibold">
                                {{ $umkm->fasilitas_3 ?: 'Mushola' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 mt-12">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->whatsapp) }}"
                   target="_blank"
                   class="bg-[#be1622] text-white px-9 py-5 rounded-full text-lg font-black shadow-xl hover:scale-105 transition">
                    💬 Pesan via WhatsApp
                </a>

                <a target="_blank"
                   href="https://www.google.com/maps/search/{{ urlencode($umkm->alamat) }}"
                   class="bg-[#171717] text-white px-9 py-5 rounded-full text-lg font-black hover:scale-105 transition">
                    ⟐ Ambil Rute
                </a>
            </div>
        </div>

        <div class="bg-[#f6eee8] rounded-[38px] p-8 shadow-2xl">
            <iframe
                src="https://maps.google.com/maps?q={{ urlencode($umkm->alamat ?? 'Kantin kampus') }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                class="w-full h-[560px] rounded-[32px]"
                loading="lazy">
            </iframe>
        </div>
    </div>
</section>

@if($umkm->photos->count() > 0)
<section class="px-8 lg:px-12 xl:px-16 pb-24">
    <div class="mb-12 text-center lg:text-left">
        <h2 class="text-4xl lg:text-5xl font-black">Galeri Usaha</h2>
        <p class="text-gray-500 mt-3 text-lg">
            Momen, suasana, dan sekilas tentang produk kami.
        </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach($umkm->photos as $photo)
            <div class="relative group rounded-[30px] overflow-hidden shadow-sm aspect-square">
                <img src="{{ $photo->image_url }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                     alt="Galeri {{ $umkm->nama_usaha }}">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition duration-500 pointer-events-none"></div>
            </div>
        @endforeach
    </div>
</section>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.menu-filter');
    const cards = document.querySelectorAll('.menu-card');
    const emptyBox = document.getElementById('emptyFilter');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const filter = this.dataset.filter.toLowerCase();
            let visibleCount = 0;

            buttons.forEach(btn => {
                btn.classList.remove('bg-[#be1622]', 'text-white');
                btn.classList.add('bg-[#f6eee8]');
            });

            this.classList.remove('bg-[#f6eee8]');
            this.classList.add('bg-[#be1622]', 'text-white');

            cards.forEach(card => {
                const keyword = card.dataset.keyword.toLowerCase();

                if (filter === 'semua' || keyword.includes(filter)) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            if (visibleCount === 0) {
                emptyBox.classList.remove('hidden');
            } else {
                emptyBox.classList.add('hidden');
            }
        });
    });
});
</script>

@endsection