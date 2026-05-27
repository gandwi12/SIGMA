@extends('layouts.app')

@section('title', 'Cari Makan - SIGMA')

@section('content')
<section class="w-full px-8 lg:px-12 xl:px-16 py-10">

    <form method="GET" action="{{ route('menu.index') }}" id="filterForm">
        <input type="hidden" name="category" id="categoryInput" value="{{ request('category', 'semua') }}">

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8">
            <div>
                <p class="text-[#be1622] font-black text-sm tracking-wide mb-3">📍 LOKASI SAAT INI</p>
                <h1 class="text-[46px] lg:text-[52px] leading-none font-black tracking-[-2px]">
                    Dekat Kampus A
                </h1>
            </div>

            <div class="flex items-center gap-4">
                <div class="w-[300px] h-[58px] bg-[#e8e1dc] rounded-full flex items-center gap-3 px-6">
                    <span>⌕</span>
                    <input name="search" value="{{ request('search') }}" placeholder="Cari ayam geprek..."
                           class="w-full bg-transparent outline-none text-sm">
                </div>

                <button type="button" id="openFilter"
                        class="h-[58px] px-9 rounded-full bg-[#be1622] text-white font-black">
                    ☷ Filter
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[260px_1fr_360px] gap-5 mt-9">
            <div class="h-[96px] bg-[#f6eee8] rounded-[26px] px-6 py-5 max-w-[760px]">
                <p class="text-[#8a6f68] text-[11px] font-black tracking-[5px] mb-3">JARAK TERDEKAT</p>
                <select name="distance" id="distanceSelect" class="w-full bg-transparent outline-none font-black text-lg">
                    <option value="">Semua Jarak</option>
                    <option value="0.5" {{ request('distance') == '0.5' ? 'selected' : '' }}>&lt; 0.5 km</option>
                    <option value="1" {{ request('distance') == '1' ? 'selected' : '' }}>&lt; 1.0 km</option>
                    <option value="2" {{ request('distance') == '2' ? 'selected' : '' }}>&lt; 2.0 km</option>
                </select>
            </div>

            <div class="h-[96px] bg-[#f6eee8] rounded-[26px] px-6 py-5">
                <div class="flex justify-between">
                    <p class="text-[#8a6f68] text-[11px] font-black tracking-[5px]">HARGA MENU (RP)</p>
                    <b class="text-[#be1622] text-sm"><span id="priceText">{{ request('price', 15000) / 1000 }}rb</span></b>
                </div>

                <input type="range" name="price" id="priceRange"
                       min="5000" max="50000" step="100"
                       value="{{ request('price', 15000) }}"
                       class="w-full mt-4 accent-[#be1622]">
            </div>

            <div class="h-[96px] bg-[#f6eee8] rounded-[26px] px-6 py-5">
                <p class="text-[#8a6f68] text-[11px] font-black tracking-[5px] mb-3">TARGET NUTRISI</p>

                <div class="flex items-center gap-2 flex-nowrap overflow-hidden">
                    <button type="button"
                            class="nutrisi-chip px-4 py-2 rounded-full text-xs font-bold {{ request('category', 'semua') == 'semua' ? 'bg-blue-100 text-blue-700' : 'bg-[#e8e1dc]' }}"
                            data-category="semua">
                        Semua
                    </button>

                    @foreach($categories->where('slug', '!=', 'semua')->take(3) as $categoryItem)
                        <button type="button"
                                class="nutrisi-chip px-4 py-2 rounded-full text-[11px] font-bold whitespace-nowrap {{ request('category') == $categoryItem->slug ? 'bg-blue-100 text-blue-700' : 'bg-[#e8e1dc]' }}"
                                data-category="{{ $categoryItem->slug }}">
                            {{ $categoryItem->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </form>

    <div class="mt-8 text-sm text-gray-500">
        <span class="font-bold text-[#be1622]">Filter aktif:</span>
        @if(request()->has('price')) Harga Rp{{ number_format(request('price'), 0, ',', '.') }}, @endif
        Jarak {{ request('distance') ? '< ' . request('distance') . ' km' : 'Semua' }},
        Nutrisi {{ request('category', 'semua') == 'semua' ? 'Semua' : request('category') }}.
    </div>

    @if($search && $umkmsMatching->count() > 0)
        <div class="mt-12">
            <h2 class="text-3xl font-black mb-8">Profil UMKM</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($umkmsMatching as $umkm)
                    <a href="{{ route('umkm.show', $umkm->id) }}"
                       class="bg-white rounded-[30px] overflow-hidden shadow-sm hover:scale-[1.02] transition border border-[#e3d8cf]">

                        <img src="{{ $umkm->image_url }}"
                             alt="{{ $umkm->nama_usaha }}"
                             class="w-full h-[230px] object-cover bg-[#eee4dc]">

                        <div class="p-7">
                            <span class="inline-block bg-red-100 text-[#be1622] px-4 py-1 rounded-full text-xs font-black">
                                {{ $umkm->kategori ?? 'UMKM' }}
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
                @endforeach
            </div>
        </div>
    @endif

    <div class="mt-12">
        @if($search)
            <h2 class="text-3xl font-black mb-8">Menu Relevan</h2>
        @else
            <h2 class="text-3xl font-black mb-8">Semua Menu</h2>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
            @forelse($menus as $menu)
                <div class="bg-[#f6eee8] rounded-[28px] overflow-hidden">
                    <a href="{{ route('menu.show', $menu->id) }}" class="block relative h-[215px] bg-[#eee4dc]">
                        <img src="{{ $menu->image_url }}" class="w-full h-full object-cover" alt="{{ $menu->nama }}">
                        <span class="absolute top-4 left-4 bg-white px-4 py-2 rounded-full text-xs font-black">★ {{ $menu->rating }}</span>
                        <span class="absolute bottom-4 right-4 bg-[#008b92] text-white px-4 py-2 rounded-full text-xs font-black">{{ $menu->tag }}</span>
                    </a>

                    <div class="p-7">
                        <div class="flex justify-between gap-5">
                            <div>
                                <h3 class="text-[22px] leading-tight font-black">{{ $menu->nama }}</h3>
                                <p class="text-sm text-[#5f514c] leading-6 mt-2">{{ $menu->deskripsi }}</p>
                            </div>

                            <div class="text-right whitespace-nowrap">
                                <b class="text-[#be1622] text-base font-black">Rp {{ number_format($menu->harga, 0, ',', '.') }}</b>
                                <span class="block text-[9px] text-[#8a6f68] font-black mt-1">MULAI DARI</span>
                            </div>
                        </div>

                        <div class="flex gap-6 text-sm font-bold mt-6">
                            <span>➤ {{ $menu->jarak }}</span>
                            <span>⏱ {{ $menu->waktu }}</span>
                        </div>

                        @if($menu->umkm_id)
                            <a href="{{ route('umkm.show', $menu->umkm_id) }}" class="inline-block text-[#be1622] font-black text-sm mt-4">
                                Lihat Profil UMKM →
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="lg:col-span-3 flex justify-center">
                    <div class="w-full max-w-[760px] bg-[#f6eee8] rounded-[28px] min-h-[300px] grid place-content-center text-center">
                        <h3 class="text-2xl font-black">Menu tidak ditemukan</h3>
                        <p class="text-gray-500 mt-2">Coba ubah filter pencarian.</p>
                        <a href="{{ route('menu.index') }}" class="text-[#be1622] font-black mt-5">Reset Filter</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

        <p class="text-[#5f514c] text-base">Ingin melihat profil warung dan menu lengkap?</p>

        @if($menus->first()?->umkm_id)
            <a href="{{ route('umkm.show', $menus->first()->umkm_id) }}" class="text-[#be1622] font-black mt-4">
                Lihat Profil UMKM Terdekat →
            </a>
        @else
            <a href="{{ route('home') }}" class="text-[#be1622] font-black mt-4">
                Kembali ke Beranda →
            </a>
        @endif
    </div>

    <div class="max-w-[1080px] mx-auto mt-14 h-[350px] rounded-[38px] overflow-hidden relative border border-[#e7d9cf] bg-[#e8e1dc] shadow-[0_25px_60px_rgba(82,43,32,0.13)]">
        <iframe src="https://maps.google.com/maps?q=kantin%20kampus&t=&z=15&ie=UTF8&iwloc=&output=embed"
                loading="lazy" class="w-full h-full border-0"></iframe>

        <a href="https://www.google.com/maps/search/kantin+dekat+kampus" target="_blank"
           class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-[24px] px-7 py-5 flex gap-4 items-center shadow-xl min-w-[340px]">
            <div class="w-11 h-11 bg-[#f8dede] text-[#be1622] rounded-full grid place-items-center">📍</div>
            <div>
                <h4 class="font-black text-base">Lihat dalam Peta</h4>
                <p class="text-xs text-gray-500 mt-1">Buka lokasi UMKM sekitar kampus di Google Maps</p>
            </div>
        </a>
    </div>

</section>

<div id="filterPanel" class="fixed inset-0 bg-black/30 z-[999] hidden justify-end">
    <div class="w-[420px] h-full bg-[#fbf5ef] p-8 shadow-2xl">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-3xl font-black">Filter Pencarian</h3>
            <button type="button" id="closeFilter" class="text-4xl">×</button>
        </div>

        <form method="GET" action="{{ route('menu.index') }}" class="space-y-5">
            <input type="hidden" name="category" value="{{ request('category', 'semua') }}">

            <div>
                <label class="font-black">Kata Kunci</label>
                <input name="search" value="{{ request('search') }}"
                       class="w-full mt-2 bg-[#f6eee8] rounded-2xl px-5 py-4 outline-none">
            </div>

            <div>
                <label class="font-black">Harga Menu</label>
                <input name="price" type="number" step="100" value="{{ request('price') }}"
                       class="w-full mt-2 bg-[#f6eee8] rounded-2xl px-5 py-4 outline-none">
            </div>

            <div>
                <label class="font-black">Jarak</label>
                <select name="distance" class="w-full mt-2 bg-[#f6eee8] rounded-2xl px-5 py-4 outline-none">
                    <option value="">Semua Jarak</option>
                    <option value="0.5" {{ request('distance') == '0.5' ? 'selected' : '' }}>&lt; 0.5 km</option>
                    <option value="1" {{ request('distance') == '1' ? 'selected' : '' }}>&lt; 1.0 km</option>
                    <option value="2" {{ request('distance') == '2' ? 'selected' : '' }}>&lt; 2.0 km</option>
                </select>
            </div>

            <button class="w-full bg-[#be1622] text-white py-4 rounded-full font-black">
                Terapkan Filter
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filterForm');
    const priceRange = document.getElementById('priceRange');
    const priceText = document.getElementById('priceText');
    const categoryInput = document.getElementById('categoryInput');
    const chips = document.querySelectorAll('.nutrisi-chip');
    const distanceSelect = document.getElementById('distanceSelect');
    const openFilter = document.getElementById('openFilter');
    const closeFilter = document.getElementById('closeFilter');
    const filterPanel = document.getElementById('filterPanel');

    priceRange?.addEventListener('input', function () {
        priceText.textContent = Math.round(this.value / 1000) + 'rb';
    });

    priceRange?.addEventListener('change', function () {
        form.submit();
    });

    distanceSelect?.addEventListener('change', function () {
        form.submit();
    });

    chips.forEach(chip => {
        chip.addEventListener('click', function () {
            categoryInput.value = this.dataset.category;
            form.submit();
        });
    });

    openFilter?.addEventListener('click', function () {
        filterPanel.classList.remove('hidden');
        filterPanel.classList.add('flex');
    });

    closeFilter?.addEventListener('click', function () {
        filterPanel.classList.add('hidden');
        filterPanel.classList.remove('flex');
    });
});
</script>
@endsection