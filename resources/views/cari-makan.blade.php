@extends('layouts.app')

@section('content')

<!-- ── HEADER HALAMAN ──────────────────────────────────────── -->
<div class="pt-8 pb-6">
    <div class="flex items-center gap-1.5 text-sigma text-xs font-bold uppercase tracking-widest mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Z"/></svg>
        Lokasi Saat Ini
    </div>
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <h1 class="text-4xl font-black tracking-tight flex-1">Dekat Kampus A</h1>
        <!-- Search bar -->
        <div class="flex items-center gap-3">
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input
                    id="search-input"
                    type="text"
                    placeholder="Cari ayam geprek..."
                    oninput="applyAllFilters()"
                    class="pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-full text-sm w-56 focus:outline-none focus:ring-2 focus:ring-sigma/30 focus:border-sigma transition"
                >
            </div>
            <button onclick="toggleFilter()" class="flex items-center gap-2 bg-sigma text-white text-sm font-bold px-5 py-2.5 rounded-full hover:bg-sigma-dark transition-colors shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="6" y2="6"/><line x1="8" x2="16" y1="12" y2="12"/><line x1="11" x2="13" y1="18" y2="18"/></svg>
                Filter
            </button>
        </div>
    </div>
</div>

<!-- ── FILTER BAR ─────────────────────────────────────────── -->
<div id="filter-bar" class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 mb-8 grid grid-cols-1 sm:grid-cols-3 gap-6">

    <!-- Jarak Terdekat -->
    <div>
        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-3">Jarak Terdekat</p>
        <div class="flex gap-2 flex-wrap">
            <button onclick="setJarak(this,'1')" class="jarak-pill bg-sigma text-white text-xs font-bold px-4 py-2 rounded-full transition-all" data-val="1">&lt; 1.0 km <svg xmlns="http://www.w3.org/2000/svg" class="inline w-3 h-3 ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg></button>
            <button onclick="setJarak(this,'all')" class="jarak-pill bg-gray-100 text-gray-600 text-xs font-bold px-4 py-2 rounded-full transition-all" data-val="all">Semua</button>
        </div>
    </div>

    <!-- Rentang Harga -->
    <div>
        <div class="flex justify-between items-center mb-3">
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Rentang Harga (Rp)</p>
            <span id="price-label" class="text-[10px] font-bold text-sigma">Maks. 25rb</span>
        </div>
        <input
            id="price-slider"
            type="range"
            min="5000"
            max="50000"
            step="1000"
            value="25000"
            class="w-full"
            oninput="onPriceChange(this.value)"
        >
        <div class="flex justify-between text-[10px] text-gray-400 mt-1.5 font-medium">
            <span>Rp5rb</span>
            <span>Rp50rb</span>
        </div>
    </div>

    <!-- Target Nutrisi -->
    <div>
        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-3">Target Nutrisi</p>
        <div class="flex gap-2 flex-wrap">
            <button onclick="setNutrisi(this,'tinggi-protein')" class="nutrisi-pill bg-sigma text-white text-xs font-bold px-4 py-2 rounded-full transition-all" data-val="tinggi-protein">Tinggi Protein</button>
            <button onclick="setNutrisi(this,'sehat')" class="nutrisi-pill bg-gray-100 text-gray-600 text-xs font-bold px-4 py-2 rounded-full transition-all" data-val="sehat">Rendah Kalori</button>
            <button onclick="setNutrisi(this,'semua')" class="nutrisi-pill bg-gray-100 text-gray-600 text-xs font-bold px-4 py-2 rounded-full transition-all" data-val="semua">Semua</button>
        </div>
    </div>
</div>

<!-- ── GRID MENU ──────────────────────────────────────────── -->
<div id="menu-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
    @foreach($menus as $menu)
    <a href="{{ route('menu.detail', $menu->id) }}"
       class="menu-card group block bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
       data-price="{{ $menu->price }}"
       data-name="{{ strtolower($menu->name) }}"
       data-category="{{ $menu->category ?? 'sehat' }}">

        <!-- Gambar -->
        <div class="relative overflow-hidden aspect-[16/10]">
            <img src="{{ $menu->image_path }}" alt="{{ $menu->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <!-- Rating badge -->
            <div class="absolute top-3 left-3 flex items-center gap-1 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-full shadow text-xs font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="#f59e0b"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                {{ number_format(4.2 + ($menu->id % 8) * 0.1, 1) }}
            </div>
            <!-- Kategori badge -->
            @if($menu->category)
            @php
                $catLabel = match($menu->category) {
                    'tinggi-protein' => 'Tinggi Protein',
                    'sehat'          => 'Rendah Kalori',
                    'hemat'          => 'Paling Hemat',
                    default          => ucfirst($menu->category),
                };
                $catColor = match($menu->category) {
                    'tinggi-protein' => 'bg-blue-600',
                    'sehat'          => 'bg-teal-600',
                    'hemat'          => 'bg-amber-500',
                    default          => 'bg-gray-600',
                };
            @endphp
            <span class="absolute bottom-3 right-3 {{ $catColor }} text-white text-[9px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">{{ $catLabel }}</span>
            @endif
        </div>

        <!-- Info -->
        <div class="p-4">
            <div class="flex justify-between items-start mb-1">
                <div class="flex-1 pr-3">
                    <h3 class="font-bold text-sm leading-tight group-hover:text-sigma transition-colors">{{ $menu->name }}</h3>
                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $menu->umkm->name }}</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-[9px] text-gray-400 font-semibold uppercase">Mulai dari</p>
                    <p class="text-sigma font-extrabold text-sm">Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
                </div>
            </div>
            <!-- Jarak & waktu (mock) -->
            <div class="flex items-center gap-4 mt-3 pt-3 border-t border-gray-50 text-[11px] text-gray-400 font-medium">
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
                    {{ number_format(0.3 + ($menu->id % 5) * 0.3, 1) }} km
                </span>
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ 8 + ($menu->id % 7) * 2 }} mnt
                </span>
                @if($menu->calories)
                <span class="ml-auto flex items-center gap-1 text-teal-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" x2="6" y1="1" y2="4"/><line x1="10" x2="10" y1="1" y2="4"/><line x1="14" x2="14" y1="1" y2="4"/></svg>
                    {{ $menu->calories }} kal
                </span>
                @endif
            </div>
        </div>
    </a>
    @endforeach
</div>

<!-- Empty state -->
<div id="empty-state" class="hidden py-24 text-center">
    <div class="text-6xl mb-5">🍽️</div>
    <p class="font-bold text-xl text-gray-700 mb-2">Tidak ada menu yang cocok</p>
    <p class="text-gray-400 text-sm">Coba ubah filter harga atau kategori nutrisi.</p>
</div>

<!-- Muat lebih banyak (kosong intentional, bisa diisi nanti) -->
<div class="text-center py-6 mb-12">
    <a href="#" class="text-sigma font-bold text-sm hover:underline inline-flex items-center gap-1.5">
        Ingin melihat lebih banyak pilihan sehat? Muat Lebih Banyak UMKM
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
    </a>
</div>

<!-- ── PETA ────────────────────────────────────────────────── -->
<div class="relative h-72 rounded-3xl overflow-hidden mb-4 bg-gray-200">
    <!-- Pseudo-map (grayscale background image style) -->
    <div class="absolute inset-0 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
        <div class="text-center opacity-40 select-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
        </div>
    </div>
    <!-- Overlay gradient -->
    <div class="absolute inset-0 bg-gradient-to-l from-[#faf9f6]/80 via-transparent to-[#faf9f6]/80"></div>
    <!-- Card info -->
    <div class="absolute bottom-6 left-6 bg-white p-5 rounded-2xl shadow-xl max-w-[240px]">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#cf1c26"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Z"/></svg>
            </div>
            <div>
                <p class="font-bold text-sm">Lihat dalam Peta</p>
                <p class="text-[11px] text-gray-400 leading-relaxed mt-0.5">Temukan {{ $menus->count() }} UMKM di sekitar Kampus A secara visual.</p>
            </div>
        </div>
    </div>
</div>

<!-- ── JS: FILTER LOGIC ───────────────────────────────────── -->
<script>
let maxPrice    = 25000;
let nutrisiCat  = 'tinggi-protein';
let searchText  = '';

function formatRb(val) {
    return 'Maks. ' + (val / 1000).toFixed(0) + 'rb';
}

// Slider merah
function updateSliderTrack(slider) {
    const min = slider.min, max = slider.max, val = slider.value;
    const pct = ((val - min) / (max - min)) * 100;
    slider.style.background = `linear-gradient(to right, #cf1c26 0%, #cf1c26 ${pct}%, #e5e7eb ${pct}%, #e5e7eb 100%)`;
}

function onPriceChange(val) {
    maxPrice = parseInt(val);
    document.getElementById('price-label').textContent = formatRb(maxPrice);
    updateSliderTrack(document.getElementById('price-slider'));
    applyAllFilters();
}

function setJarak(btn, val) {
    document.querySelectorAll('.jarak-pill').forEach(p => {
        p.classList.remove('bg-sigma','text-white');
        p.classList.add('bg-gray-100','text-gray-600');
    });
    btn.classList.remove('bg-gray-100','text-gray-600');
    btn.classList.add('bg-sigma','text-white');
    applyAllFilters();
}

function setNutrisi(btn, val) {
    nutrisiCat = val;
    document.querySelectorAll('.nutrisi-pill').forEach(p => {
        p.classList.remove('bg-sigma','text-white');
        p.classList.add('bg-gray-100','text-gray-600');
    });
    btn.classList.remove('bg-gray-100','text-gray-600');
    btn.classList.add('bg-sigma','text-white');
    applyAllFilters();
}

function toggleFilter() {
    const bar = document.getElementById('filter-bar');
    bar.style.display = bar.style.display === 'none' ? 'grid' : 'none';
}

function applyAllFilters() {
    searchText = document.getElementById('search-input').value.toLowerCase();
    const cards = document.querySelectorAll('.menu-card');
    let visible = 0;

    cards.forEach(card => {
        const price = parseInt(card.dataset.price);
        const cat   = card.dataset.category.toLowerCase();
        const name  = card.dataset.name;

        const passPrice   = price <= maxPrice;
        const passNutrisi = nutrisiCat === 'semua' || cat === nutrisiCat;
        const passSearch  = name.includes(searchText);

        if (passPrice && passNutrisi && passSearch) {
            card.style.display = 'block';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    document.getElementById('empty-state').style.display = visible === 0 ? 'block' : 'none';
}

// Init on load
document.addEventListener('DOMContentLoaded', () => {
    const slider = document.getElementById('price-slider');
    updateSliderTrack(slider);
    applyAllFilters();
});
</script>

@endsection
