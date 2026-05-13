@extends('layouts.app')

@section('content')

<!-- ══════════════════════════════════════════════
     HERO SECTION
══════════════════════════════════════════════ -->
<section class="grid grid-cols-1 lg:grid-cols-2 gap-0 lg:gap-16 items-center min-h-[85vh] py-10 lg:py-16">

    <!-- Kiri: Teks & Kontrol -->
    <div class="order-2 lg:order-1">
        <div class="inline-flex items-center gap-2 bg-red-50 text-sigma px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest mb-6">
            <span class="w-1.5 h-1.5 bg-sigma rounded-full animate-pulse"></span>
            Kurasi Digital Mahasiswa
        </div>

        <h1 class="text-5xl xl:text-[4rem] font-black leading-[1.08] tracking-tight mb-6">
            SIGMA &ndash; <span class="text-sigma">Solusi Irit</span><br>
            dan Gizi Maksimal
        </h1>

        <p class="text-gray-500 text-base lg:text-lg leading-relaxed mb-10 max-w-md">
            Menemukan hidangan lezat dan bergizi di sekitar kampus tanpa menguras dompet.
        </p>

        <!-- Budget Slider (1 nilai = max price, track merah) -->
        <div class="bg-[#f0ebe1] rounded-2xl p-6 mb-8 max-w-md">
            <div class="flex justify-between items-center mb-5">
                <span class="font-bold text-sm text-gray-700">Atur Budget Kamu</span>
                <span id="budget-label" class="bg-red-100 text-sigma text-xs font-bold px-4 py-1.5 rounded-full">Maks. Rp20.000</span>
            </div>
            <input
                id="budget-slider"
                type="range"
                min="5000"
                max="50000"
                step="1000"
                value="20000"
                class="w-full h-[5px] rounded-full cursor-pointer outline-none"
                style="background: linear-gradient(to right, #cf1c26 0%, #cf1c26 30%, #e5e7eb 30%, #e5e7eb 100%)"
                oninput="onBudgetChange(this.value)"
            >
            <div class="flex justify-between text-[11px] text-gray-400 mt-2 font-medium">
                <span>Rp5.000</span>
                <span>Rp50.000</span>
            </div>
        </div>

        <!-- CTA Button → ke halaman Cari Makan -->
        <a href="{{ route('cari-makan') }}"
            class="inline-flex items-center gap-2.5 bg-sigma hover:bg-sigma-dark active:scale-95 text-white font-bold py-4 px-10 rounded-full transition-all shadow-xl shadow-red-300/40 text-sm select-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            Cari Makan Sekarang
        </a>
    </div>

    <!-- Kanan: Gambar Hero -->
    <div class="order-1 lg:order-2 relative">
        <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl shadow-gray-300/60 w-full aspect-[3/4] lg:aspect-[4/5] lg:h-[620px]">
            <img src="/images/hero-food.jpg" alt="Hidangan Sehat Bergizi" class="w-full h-full object-cover">
            <!-- Gradient overlay bawah -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent"></div>
        </div>
        <!-- Badge kecil -->
        <div class="absolute bottom-8 left-6 bg-white/95 backdrop-blur p-4 rounded-2xl shadow-2xl max-w-[190px]">
            <div class="flex items-center gap-1.5 text-teal-600 font-bold text-[10px] uppercase tracking-wider mb-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                Pilihan SIGMA
            </div>
            <p class="text-xs font-semibold text-gray-800 leading-snug">Gado-Gado Premium dari UMKM Terpilih</p>
        </div>
        <!-- Dekorasi bulat -->
        <div class="absolute -top-4 -right-4 w-24 h-24 bg-red-100 rounded-full -z-10 blur-md opacity-60"></div>
        <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-amber-100 rounded-full -z-10 blur-md opacity-60"></div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     FILTER PILLS + SEMUA MENU
══════════════════════════════════════════════ -->
<section id="menu-section" class="pt-4 pb-2">

    <!-- Label info filter aktif -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-3">
        <p id="filter-info" class="text-sm text-gray-500">
            Menampilkan <span id="filter-count" class="font-bold text-gray-900">semua</span> menu
            · budget maks <span id="filter-budget-text" class="font-bold text-sigma">Rp20.000</span>
        </p>
        <div class="flex flex-wrap gap-2.5" id="filter-pills">
            <button onclick="setFilter('semua', this)"
                class="filter-pill active-pill bg-sigma text-white px-4 py-1.5 rounded-full text-xs font-bold transition-all shadow-md shadow-red-200/50">
                Semua
            </button>
            <button onclick="setFilter('hemat', this)"
                class="filter-pill bg-white border border-gray-200 hover:border-sigma text-gray-600 hover:text-sigma px-4 py-1.5 rounded-full text-xs font-bold transition-all">
                &lt; Rp10.000
            </button>
            <button onclick="setFilter('10-20k', this)"
                class="filter-pill bg-white border border-gray-200 hover:border-sigma text-gray-600 hover:text-sigma px-4 py-1.5 rounded-full text-xs font-bold transition-all">
                Rp10k – Rp20k
            </button>
            <button onclick="setFilter('sehat', this)"
                class="filter-pill bg-white border border-gray-200 hover:border-sigma text-gray-600 hover:text-sigma px-4 py-1.5 rounded-full text-xs font-bold transition-all">
                Sehat
            </button>
            <button onclick="setFilter('tinggi-protein', this)"
                class="filter-pill bg-white border border-gray-200 hover:border-sigma text-gray-600 hover:text-sigma px-4 py-1.5 rounded-full text-xs font-bold transition-all">
                Tinggi Protein
            </button>
        </div>
    </div>

    <!-- Grid Semua Menu (difilter JS) -->
    <div id="menu-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
        @php
            $allMenus = $popularMenus->merge($recommendedMenus->filter(fn($m) => !$popularMenus->contains('id', $m->id)));
        @endphp
        @foreach($allMenus as $menu)
        <a href="{{ route('menu.detail', $menu->id) }}"
           class="menu-card group block bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300"
           data-price="{{ $menu->price }}"
           data-category="{{ $menu->category ?? 'sehat' }}">
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

    <!-- Empty state -->
    <div id="empty-state" class="hidden py-16 text-center">
        <div class="text-5xl mb-4">🍽️</div>
        <p class="font-bold text-gray-700 mb-1">Tidak ada menu yang cocok</p>
        <p class="text-sm text-gray-400">Coba naikkan budget atau pilih kategori lain.</p>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     REKOMENDASI TERBAIK
══════════════════════════════════════════════ -->
<section class="py-14">
    <div class="flex items-end justify-between mb-8">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-widest text-sigma mb-2">Pilihan Editor</p>
            <h2 class="text-2xl font-extrabold tracking-tight">Rekomendasi Terbaik</h2>
        </div>
        <a href="#menu-section" class="text-sigma text-xs font-bold border-b border-sigma pb-0.5 hover:opacity-70 transition-opacity">Lihat Semua</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse($recommendedMenus as $menu)
        <a href="{{ route('menu.detail', $menu->id) }}"
           class="group flex bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="w-[180px] shrink-0 overflow-hidden">
                <img src="{{ $menu->image_path }}" alt="{{ $menu->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
            <div class="flex-1 p-5 flex flex-col justify-between">
                <div>
                    @if($menu->category)
                    <span class="inline-block bg-blue-50 text-blue-600 px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider mb-2.5">{{ $menu->category }}</span>
                    @endif
                    <h3 class="text-base font-bold mb-1.5 group-hover:text-sigma transition-colors leading-snug">{{ $menu->name }}</h3>
                    <p class="text-gray-400 text-xs leading-relaxed line-clamp-2">{{ $menu->description }}</p>
                </div>
                <div>
                    <p class="text-sigma font-extrabold text-lg mt-3 mb-2">Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
                    <div class="flex items-center gap-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                        @if($menu->calories)<span>{{ $menu->calories }} kcal</span>@endif
                        @if($menu->protein)<span>{{ $menu->protein }}g protein</span>@endif
                        @if($menu->available_time)
                        <span class="ml-auto flex items-center gap-1 normal-case tracking-normal font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $menu->available_time }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
        @empty
        <p class="col-span-2 text-center py-10 text-gray-400">Belum ada rekomendasi.</p>
        @endforelse
    </div>
</section>

<!-- ══════════════════════════════════════════════
     UMKM TERKURASI
══════════════════════════════════════════════ -->
<section class="bg-[#f0ebe1] rounded-3xl px-6 py-14 md:p-16 mb-4" id="section-umkm">
    <div class="text-center mb-12">
        <p class="text-[11px] font-bold uppercase tracking-widest text-sigma mb-3">Mitra Terpercaya</p>
        <h2 class="text-2xl font-extrabold tracking-tight mb-4">Pilihan UMKM Terkurasi</h2>
        <p class="text-gray-500 text-sm max-w-lg mx-auto leading-relaxed">
            Dukung ekonomi lokal kampus dengan memilih makanan dari mitra UMKM kami yang sudah terjamin kualitas dan kebersihannya.
        </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($umkms as $umkm)
        <div class="flex flex-col items-center text-center">
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-sigma shadow-md mb-5">
                @if($umkm->icon === 'storefront')
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/><path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"/><path d="M12 3v6"/></svg>
                @elseif($umkm->icon === 'verified')
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                @else
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                @endif
            </div>
            <h3 class="font-bold text-base mb-2">{{ $umkm->name }}</h3>
            <p class="text-xs text-gray-500 leading-relaxed">{{ $umkm->description }}</p>
        </div>
        @endforeach
    </div>
</section>

<!-- ══════════════════════════════════════════════
     JS: FILTER LOGIC (Slider + Pills)
══════════════════════════════════════════════ -->
<script>
let currentBudget = 20000;
let currentCategory = 'semua';

function formatRp(val) {
    return 'Rp' + new Intl.NumberFormat('id-ID').format(val);
}

// Update track merah slider
function updateSliderTrack(slider) {
    const pct = ((slider.value - slider.min) / (slider.max - slider.min)) * 100;
    slider.style.background = `linear-gradient(to right, #cf1c26 0%, #cf1c26 ${pct}%, #e5e7eb ${pct}%, #e5e7eb 100%)`;
}

function onBudgetChange(val) {
    currentBudget = parseInt(val);
    // Format: Maks. Rp20.000
    const formatted = 'Maks. Rp' + new Intl.NumberFormat('id-ID').format(currentBudget);
    document.getElementById('budget-label').textContent = formatted;
    const budgetText = document.getElementById('filter-budget-text');
    if (budgetText) budgetText.textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(currentBudget);
    updateSliderTrack(document.getElementById('budget-slider'));
    applyFilter();
}

// ── Dipanggil saat pill diklik
function setFilter(cat, btn) {
    currentCategory = cat;

    // Reset semua pill style
    document.querySelectorAll('.filter-pill').forEach(p => {
        p.classList.remove('bg-sigma', 'text-white', 'shadow-md', 'shadow-red-200/50', 'active-pill');
        p.classList.add('bg-white', 'border', 'border-gray-200', 'text-gray-600');
    });
    // Aktifkan pill yang diklik
    btn.classList.remove('bg-white', 'border', 'border-gray-200', 'text-gray-600');
    btn.classList.add('bg-sigma', 'text-white', 'shadow-md', 'shadow-red-200/50', 'active-pill');

    applyFilter();
}

// ── Logika filter utama
function applyFilter() {
    const cards = document.querySelectorAll('.menu-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const price = parseInt(card.dataset.price);
        const cat   = (card.dataset.category || '').toLowerCase().trim();

        // Cek budget
        const passBudget = price <= currentBudget;

        // Cek kategori
        let passCat = false;
        if (currentCategory === 'semua') {
            passCat = true;
        } else if (currentCategory === 'hemat') {
            passCat = price < 10000;
        } else if (currentCategory === '10-20k') {
            passCat = price >= 10000 && price <= 20000;
        } else {
            // 'sehat' atau 'tinggi-protein' cocokkan dengan data-category
            passCat = cat === currentCategory;
        }

        if (passBudget && passCat) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Update counter
    const countEl = document.getElementById('filter-count');
    if (visibleCount === cards.length) {
        countEl.textContent = 'semua';
    } else {
        countEl.textContent = visibleCount;
    }

    // Empty state
    document.getElementById('empty-state').style.display = visibleCount === 0 ? 'block' : 'none';
}

// Inisiasi saat halaman load
document.addEventListener('DOMContentLoaded', () => {
    const slider = document.getElementById('budget-slider');
    if (slider) updateSliderTrack(slider);
    applyFilter();
});
</script>

@endsection
