@extends('layouts.app')

@section('content')

{{-- ── HERO ──────────────────────────────────────────── --}}
<section class="relative -mx-6 lg:-mx-16 mb-10 overflow-hidden">
    <div class="bg-gradient-to-br from-[#2D3748] via-[#1a2333] to-[#008B92] px-6 lg:px-16 pt-14 pb-20">
        {{-- Decorative blobs --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#008B92]/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-20 w-64 h-64 bg-[#cf1c26]/15 rounded-full blur-3xl translate-y-1/2"></div>

        <div class="relative max-w-[1400px] mx-auto">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur text-white/80 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-5">
                <span class="w-1.5 h-1.5 bg-[#008B92] rounded-full animate-pulse"></span>
                Mitra Resmi SIGMA
            </div>
            <div class="flex flex-col md:flex-row md:items-end gap-6 justify-between">
                <div>
                    <h1 class="text-4xl lg:text-5xl font-black text-white leading-tight mb-3">
                        Daftar UMKM<br>
                        <span class="text-[#008B92]">Terafiliasi</span> SIGMA
                    </h1>
                    <p class="text-white/60 text-sm lg:text-base max-w-lg">
                        Temukan warung dan kedai terpercaya di sekitar kampus — sudah dikurasi kualitas & kebersihannya untuk mahasiswa.
                    </p>
                </div>
                {{-- Stats --}}
                <div class="flex gap-6 shrink-0">
                    <div class="text-center">
                        <p class="text-3xl font-black text-white">{{ $umkms->count() }}</p>
                        <p class="text-white/50 text-xs font-semibold mt-0.5">UMKM Aktif</p>
                    </div>
                    <div class="w-px bg-white/10"></div>
                    <div class="text-center">
                        <p class="text-3xl font-black text-white">1.2k+</p>
                        <p class="text-white/50 text-xs font-semibold mt-0.5">Pelanggan</p>
                    </div>
                    <div class="w-px bg-white/10"></div>
                    <div class="text-center">
                        <p class="text-3xl font-black text-white">5</p>
                        <p class="text-white/50 text-xs font-semibold mt-0.5">Kategori</p>
                    </div>
                </div>
            </div>

            {{-- Search bar --}}
            <div class="mt-8 relative max-w-xl">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 shrink-0" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input id="umkm-search" type="text" placeholder="Cari nama UMKM atau kategori..."
                       class="w-full bg-white/95 backdrop-blur pl-11 pr-4 py-3.5 rounded-2xl text-sm font-medium text-gray-700 placeholder-gray-400 outline-none border-2 border-transparent focus:border-[#008B92] transition-colors shadow-xl"
                       oninput="filterUmkm()">
            </div>
        </div>
    </div>

    {{-- Wave bottom --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 40" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 40L1440 40L1440 10C1200 40 960 0 720 15C480 30 240 5 0 30L0 40Z" fill="#FDF8F3"/>
        </svg>
    </div>
</section>

{{-- ── FILTER PILLS ──────────────────────────────────── --}}
<div class="flex flex-wrap gap-2.5 mb-8" id="filter-pills">
    <button onclick="setCatFilter('semua', this)"
        class="umkm-filter-pill bg-sigma text-white px-5 py-2 rounded-full text-xs font-bold shadow-md shadow-red-200/50 transition-all">
        Semua
    </button>
    @foreach(['Makanan','Minuman','Snack','Vegetarian','Seafood'] as $kat)
    <button onclick="setCatFilter('{{ strtolower($kat) }}', this)"
        class="umkm-filter-pill bg-white border border-gray-200 hover:border-sigma text-gray-500 hover:text-sigma px-5 py-2 rounded-full text-xs font-bold transition-all">
        {{ $kat }}
    </button>
    @endforeach
</div>

{{-- ── UMKM GRID ─────────────────────────────────────── --}}
<div id="umkm-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pb-28">
    @forelse($umkms as $umkm)
    <a href="{{ route('umkm.profil', $umkm->id) }}"
       class="umkm-card group block bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300"
       data-name="{{ strtolower($umkm->name) }}"
       data-kategori="{{ strtolower($umkm->kategori ?? 'makanan') }}">

        {{-- Image --}}
        <div class="relative h-48 bg-gradient-to-br from-[#008B92]/10 via-[#2D3748]/5 to-[#cf1c26]/10 overflow-hidden">
            @if($umkm->foto)
                <img src="{{ Storage::url($umkm->foto) }}" alt="{{ $umkm->name }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <div class="w-20 h-20 bg-white rounded-2xl shadow-lg flex items-center justify-center text-[#cf1c26]">
                        @if($umkm->icon === 'storefront')
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/><path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"/><path d="M12 3v6"/></svg>
                        @elseif($umkm->icon === 'verified')
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                        @endif
                    </div>
                </div>
            @endif
            {{-- Category badge --}}
            <span class="absolute top-4 left-4 bg-[#008B92] text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full">
                {{ $umkm->kategori ?? 'Kuliner' }}
            </span>
            {{-- Verified badge --}}
            <span class="absolute top-4 right-4 bg-white/90 backdrop-blur text-[#008B92] text-[9px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                Terverifikasi
            </span>
        </div>

        {{-- Card Body --}}
        <div class="p-5">
            <h3 class="font-bold text-base text-[#2D3748] mb-3 group-hover:text-sigma transition-colors leading-snug line-clamp-2">
                {{ $umkm->name }}
            </h3>

            @if($umkm->lokasi)
            <div class="flex items-start gap-2 text-gray-400 text-xs mb-2">
                <svg class="shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                <span class="line-clamp-2">{{ $umkm->lokasi }}</span>
            </div>
            @endif

            @if($umkm->jam_operasional)
            <div class="flex items-center gap-2 text-gray-400 text-xs mb-4">
                <svg class="shrink-0" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span>{{ $umkm->jam_operasional }}</span>
            </div>
            @endif

            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                <span class="text-xs text-gray-400 font-medium">
                    <span class="text-[#2D3748] font-bold">{{ $umkm->menus_count }}</span> Menu Tersedia
                </span>
                <span class="text-xs font-bold text-sigma flex items-center gap-1 group-hover:gap-2 transition-all">
                    Lihat Profil
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </span>
            </div>
        </div>
    </a>
    @empty
    <div class="col-span-3 py-24 text-center">
        <div class="text-6xl mb-4">🏪</div>
        <p class="font-bold text-gray-600 mb-1">Belum ada UMKM terdaftar</p>
        <p class="text-sm text-gray-400">Jadilah yang pertama mendaftarkan UMKM Anda!</p>
    </div>
    @endforelse
</div>

{{-- Empty state filter --}}
<div id="umkm-empty" class="hidden py-24 text-center">
    <div class="text-6xl mb-4">🔍</div>
    <p class="font-bold text-gray-600 mb-1">UMKM tidak ditemukan</p>
    <p class="text-sm text-gray-400">Coba kata kunci atau kategori lain.</p>
</div>

{{-- ── FAB: Daftarkan UMKM ───────────────────────────── --}}
<a href="{{ route('daftarkan-umkm') }}"
   id="fab-daftar"
   class="fixed bottom-8 right-8 z-50 flex items-center gap-0 hover:gap-3 bg-sigma hover:bg-sigma-dark text-white rounded-full shadow-2xl shadow-red-400/40 h-14 pl-4 pr-4 hover:pr-6 transition-all duration-300 group overflow-hidden"
   title="Daftarkan UMKM Anda">
    <span class="relative shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/><path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"/><path d="M12 3v6"/><line x1="12" y1="14" x2="12" y2="18"/><line x1="10" y1="16" x2="14" y2="16"/></svg>
    </span>
    <span class="text-sm font-bold whitespace-nowrap max-w-0 group-hover:max-w-[160px] overflow-hidden transition-all duration-300">
        Daftarkan UMKM
    </span>
</a>

{{-- ── PENDING APPROVAL MODAL ───────────────────────── --}}
@if(session('pending_umkm_id'))
<div id="pending-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    {{-- Card --}}
    <div class="relative bg-white rounded-3xl shadow-2xl max-w-sm w-full p-8 text-center fade-up">
        {{-- Icon --}}
        <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <h2 class="text-xl font-black text-[#2D3748] mb-2">Menunggu Persetujuan Admin</h2>
        <p class="text-gray-500 text-sm leading-relaxed mb-1">
            UMKM <strong class="text-[#2D3748]">{{ session('pending_umkm_name') }}</strong> sedang dalam proses verifikasi oleh tim SIGMA.
        </p>
        <p class="text-gray-400 text-xs mb-7">Biasanya disetujui dalam beberapa menit.</p>
        <button id="modal-ok-btn"
                onclick="handleModalOk()"
                class="w-full bg-sigma hover:bg-sigma-dark text-white font-bold py-3.5 rounded-2xl transition-colors text-sm">
            OK, Mengerti
        </button>
    </div>
</div>

<script>
const PENDING_ID   = {{ session('pending_umkm_id') }};
const APPROVE_URL  = '{{ route("umkm.approve", session("pending_umkm_id")) }}';
const CSRF_TOKEN   = '{{ csrf_token() }}';

function handleModalOk() {
    // Tutup modal
    document.getElementById('pending-modal').style.display = 'none';

    // Tampilkan toast processing
    showToast('⏳ Sedang diproses oleh admin...', '#2D3748');

    // Setelah 5 detik → approve & reload
    setTimeout(() => {
        fetch(APPROVE_URL, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('✅ UMKM berhasil disetujui admin!', '#008B92');
                setTimeout(() => location.reload(), 1200);
            }
        });
    }, 5000);
}

function showToast(msg, color) {
    const existing = document.getElementById('sigma-toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.id = 'sigma-toast';
    toast.style.cssText = `
        position: fixed; bottom: 100px; right: 32px; z-index: 999;
        background: ${color}; color: white;
        padding: 14px 22px; border-radius: 14px;
        font-weight: 700; font-size: 13px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        animation: fadeUp .4s ease forwards;
    `;
    toast.textContent = msg;
    document.body.appendChild(toast);
}
</script>
@endif

{{-- ── CLIENT-SIDE FILTER JS ───────────────────────── --}}
<script>
let currentCat = 'semua';

function setCatFilter(cat, btn) {
    currentCat = cat;
    document.querySelectorAll('.umkm-filter-pill').forEach(p => {
        p.classList.remove('bg-sigma','text-white','shadow-md','shadow-red-200/50');
        p.classList.add('bg-white','border','border-gray-200','text-gray-500');
    });
    btn.classList.remove('bg-white','border','border-gray-200','text-gray-500');
    btn.classList.add('bg-sigma','text-white','shadow-md','shadow-red-200/50');
    filterUmkm();
}

function filterUmkm() {
    const q   = document.getElementById('umkm-search').value.toLowerCase().trim();
    const cards = document.querySelectorAll('.umkm-card');
    let visible = 0;

    cards.forEach(card => {
        const name = card.dataset.name || '';
        const kat  = card.dataset.kategori || '';
        const matchQ   = !q || name.includes(q) || kat.includes(q);
        const matchCat = currentCat === 'semua' || kat === currentCat;
        if (matchQ && matchCat) {
            card.style.display = 'block';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    document.getElementById('umkm-empty').style.display = visible === 0 && cards.length > 0 ? 'block' : 'none';
}
</script>

@endsection
