@extends('layouts.app')

@section('title', 'Beranda - SIGMA')

@section('content')
@php
    $currentPrice = request('price') ? (int) request('price') : 15000;
@endphp

<section class="w-full px-8 lg:px-12 xl:px-16 py-12">

    {{-- HERO --}}
    <div class="grid lg:grid-cols-[1.08fr_0.92fr] gap-5 items-center">

        <div>
            <h1 class="text-[50px] lg:text-[72px] leading-[1.02] font-black tracking-[-4px]">
                SIGMA – <span class="text-[#be1622]">Solusi Irit</span><br>
                dan Gizi Maksimal
            </h1>

            <p class="text-gray-600 mt-7 leading-9 max-w-[650px] text-[18px]">
                Kurasi digital makanan mahasiswa. Temukan makanan lezat, hemat,
                dekat kampus, dan tetap bergizi.
            </p>

            <form method="GET" action="{{ route('home') }}" id="homeFilterForm"
                  class="bg-[#f6eee8] rounded-[30px] p-7 mt-8 max-w-[520px]">

                <div class="flex justify-between items-center gap-4">
                    <p class="font-black text-sm">Atur Budget Kamu</p>

                    <span id="homePriceLabel"
                          class="bg-red-100 text-[#be1622] px-4 py-2 rounded-full text-sm font-black whitespace-nowrap">
                        Rp{{ number_format($currentPrice, 0, ',', '.') }}
                    </span>
                </div>

                <input
                    type="range"
                    name="price"
                    id="homePriceRange"
                    min="5000"
                    max="50000"
                    step="1000"
                    value="{{ $currentPrice }}"
                    class="w-full mt-5 accent-[#be1622]"
                >

                <div class="flex justify-between text-xs text-gray-400 mt-1">
                    <span>Rp5rb</span>
                    <span>Rp50rb</span>
                </div>

                <p class="text-xs text-gray-500 mt-4">
                    Geser budget lalu sistem akan menampilkan menu dengan harga persis sesuai pilihan kamu.
                </p>
            </form>

            <a id="homeBudgetButton"
               href="{{ route('menu.index', ['price' => $currentPrice]) }}"
               class="inline-block bg-[#be1622] text-white text-lg px-9 py-4 rounded-full font-black mt-8 shadow-xl hover:bg-[#a9131d] transition">
                Cari Makan Sekarang
            </a>
        </div>

        <div class="relative">
            <img src="{{ $menuRekomendasi?->image_url ?? asset('images/default-food.jpg') }}"
                 class="w-full h-[500px] object-cover rounded-[42px] shadow-2xl"
                 alt="SIGMA Food">

            <div class="absolute bottom-8 -left-10 bg-white rounded-[24px] p-5 shadow-2xl">
                <p class="text-[#008b92] text-xs font-black">🥗 PILIHAN SEHAT</p>
                <h3 class="font-black mt-2">
                    {{ $menuRekomendasi->nama ?? 'Menu Pilihan SIGMA' }}
                </h3>
                <p class="text-xs text-gray-500">
                    {{ $menuRekomendasi->umkm->nama_usaha ?? 'UMKM Terpilih' }}
                </p>
            </div>
        </div>
    </div>

    {{-- FILTER CHIP --}}
    <div class="flex flex-wrap gap-4 mt-16">
        <a href="{{ route('home', ['price' => request('price')]) }}"
           class="{{ request('category', 'semua') == 'semua' ? 'bg-[#be1622] text-white' : 'bg-[#e8e1dc]' }} px-6 py-3 rounded-full text-sm font-bold">
            Semua
        </a>

        @foreach($categories->where('slug', '!=', 'semua') as $category)
            <a href="{{ route('home', ['category' => $category->slug, 'price' => request('price')]) }}"
               class="{{ request('category') == $category->slug ? 'bg-[#be1622] text-white' : 'bg-[#e8e1dc]' }} px-6 py-3 rounded-full text-sm font-bold">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    {{-- REKOMENDASI --}}
    <section class="mt-12">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl lg:text-4xl font-black">Rekomendasi Terbaik</h2>
                <p class="text-gray-500 mt-2">
                    @if(request()->has('price'))
                        Menampilkan menu aktif dengan harga Rp{{ number_format($currentPrice, 0, ',', '.') }}.
                    @else
                        Menampilkan semua menu aktif.
                    @endif
                </p>
            </div>

            <a href="{{ route('menu.index') }}"
               class="text-[#be1622] font-bold underline text-sm">
                Lihat Semua
            </a>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($menus as $menu)
                <a href="{{ route('menu.show', $menu->id) }}"
                   class="bg-[#f6eee8] rounded-[30px] overflow-hidden hover:scale-[1.02] transition">

                    <img src="{{ $menu->image_url }}"
                         class="w-full h-[255px] object-cover"
                         alt="{{ $menu->nama }}">

                    <div class="p-7">
                        <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-xs font-bold">
                            {{ $menu->tag ?? 'Menu SIGMA' }}
                        </span>

                        <h3 class="text-2xl font-black mt-4">
                            {{ $menu->nama }}
                        </h3>

                        <p class="text-gray-600 text-sm leading-6 mt-2">
                            {{ Str::limit($menu->deskripsi, 90) }}
                        </p>

                        <p class="text-[#be1622] text-xl font-black mt-8">
                            Rp{{ number_format($menu->harga, 0, ',', '.') }}
                        </p>

                        <div class="flex gap-8 text-xs text-gray-500 mt-4">
                            <span>{{ $menu->kalori ?? 0 }} KCAL</span>
                            <span>{{ $menu->protein ?? 0 }}G PROT</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="md:col-span-2 lg:col-span-3 bg-[#f6eee8] rounded-[30px] p-16 text-center">
                    <h3 class="text-2xl font-black">Menu tidak ditemukan</h3>
                    <p class="text-gray-500 mt-2">
                        Belum ada menu aktif dengan harga Rp{{ number_format($currentPrice, 0, ',', '.') }}.
                    </p>

                    <a href="{{ route('home') }}"
                       class="inline-block mt-5 text-[#be1622] font-black">
                        Reset Filter
                    </a>
                </div>
            @endforelse
        </div>
    </section>

    {{-- POPULER --}}
    <section class="mt-16">
        <h2 class="text-3xl lg:text-4xl font-black mb-8">Pilihan Terpopuler</h2>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-7">
            @forelse($popularMenus as $menu)
                <a href="{{ route('menu.show', $menu->id) }}">
                    <img src="{{ $menu->image_url }}"
                         class="w-full h-[260px] object-cover rounded-[26px]"
                         alt="{{ $menu->nama }}">

                    <h3 class="font-black mt-4">{{ $menu->nama }}</h3>

                    <p class="text-[#be1622] font-black mt-1">
                        Rp{{ number_format($menu->harga, 0, ',', '.') }}
                    </p>

                    <div class="flex gap-4 text-[11px] text-gray-500 mt-2">
                        <span>{{ $menu->kalori ?? 0 }} KAL</span>
                        <span>{{ $menu->protein ?? 0 }}G PROT</span>
                    </div>
                </a>
            @empty
                <p class="text-gray-500">Belum ada menu populer.</p>
            @endforelse
        </div>
    </section>

    {{-- UMKM --}}
    <section class="mt-20 bg-[#f6eee8] rounded-[38px] px-10 py-16">
        <div class="text-center">
            <h2 class="text-3xl lg:text-4xl font-black">Pilihan UMKM Terkurasi</h2>

            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
                Dukung ekonomi lokal kampus dengan memilih makanan dari mitra UMKM kami
                yang sudah terjamin kualitas dan kebersihannya.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mt-14">
            @forelse($umkms as $umkm)
                <a href="{{ route('umkm.show', $umkm->id) }}"
                   class="bg-white rounded-[30px] overflow-hidden shadow-sm hover:scale-[1.02] transition">

                    <img src="{{ $umkm->image_url }}"
                         alt="{{ $umkm->nama_usaha }}"
                         class="w-full h-[230px] object-cover bg-[#eee4dc]">

                    <div class="p-7">
                        <span class="inline-block bg-red-100 text-[#be1622] px-4 py-1 rounded-full text-xs font-black">
                            {{ $umkm->kategori ?? 'UMKM SIGMA' }}
                        </span>

                        <h3 class="text-2xl font-black mt-4">
                            {{ $umkm->nama_usaha }}
                        </h3>

                        <p class="text-gray-600 text-sm leading-6 mt-3">
                            {{ Str::limit($umkm->deskripsi, 90) }}
                        </p>

                        <div class="flex justify-between items-center mt-6">
                            <p class="text-xs text-gray-500">
                                📍 {{ $umkm->lokasi ?? 'Sekitar Kampus' }}
                            </p>

                            <span class="text-[#be1622] font-black text-sm">
                                Lihat Profil →
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="lg:col-span-3 bg-white rounded-[30px] p-12 text-center">
                    <h3 class="text-2xl font-black">Belum Ada UMKM Aktif</h3>
                    <p class="text-gray-500 mt-2">
                        UMKM akan tampil setelah disetujui oleh Admin SIGMA.
                    </p>
                </div>
            @endforelse
        </div>
    </section>

</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const range = document.getElementById('homePriceRange');
    const label = document.getElementById('homePriceLabel');
    const form = document.getElementById('homeFilterForm');
    const button = document.getElementById('homeBudgetButton');

    function formatRupiah(value) {
        return 'Rp' + Number(value).toLocaleString('id-ID');
    }

    if (range && label && form && button) {
        range.addEventListener('input', function () {
            label.textContent = formatRupiah(this.value);
            button.href = "{{ route('menu.index') }}" + "?price=" + this.value;
        });

        range.addEventListener('change', function () {
            form.submit();
        });
    }
});
</script>
@endsection