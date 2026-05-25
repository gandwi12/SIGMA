@extends('layouts.app')

@section('title', $menu->nama . ' - SIGMA')

@section('content')
<section class="w-full px-8 lg:px-12 xl:px-16 py-8">

    
    <div class="mb-8">
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center gap-3 bg-[#be1622] text-white px-7 py-4 rounded-full font-black shadow-lg hover:bg-[#a9131d] transition">
            ← Kembali
        </a>
    </div>

    {{-- HERO DETAIL --}}
    <div class="grid lg:grid-cols-[1.15fr_.85fr] gap-10 items-start">

        <div class="relative">
            <img src="{{ $menu->image_url }}"
                 class="w-full h-[430px] object-cover rounded-[34px] shadow-xl"
                 alt="{{ $menu->nama }}">

            <div class="absolute top-6 left-6 flex gap-3">
                <span class="bg-blue-100 text-blue-700 px-5 py-2 rounded-full text-xs font-black">
                    TERLARIS
                </span>

                <span class="bg-[#008b92] text-white px-5 py-2 rounded-full text-xs font-black">
                    NUTRISI TERJAGA
                </span>
            </div>
        </div>

        <div>
            <p class="font-black text-sm tracking-wide">
                ⭐ {{ $menu->umkm->nama_usaha ?? 'WARUNG SEHAT MAHASISWA' }}
            </p>

            <h1 class="text-5xl lg:text-6xl font-black mt-5 leading-tight">
                {{ $menu->nama }}
            </h1>

            <p class="text-[#be1622] text-4xl font-black mt-4">
                Rp{{ number_format($menu->harga, 0, ',', '.') }}
            </p>

            <div class="bg-[#f6eee8] rounded-[30px] p-8 mt-8">
                <h3 class="font-black mb-6">💧 Kandungan Nutrisi</h3>

                <div class="grid grid-cols-3 gap-5">
                    <div class="bg-white rounded-2xl p-5 text-center">
                        <h2 class="text-3xl font-black">{{ $menu->kalori ?? 0 }}</h2>
                        <p class="text-xs text-gray-500 font-bold mt-1">KCAL</p>
                    </div>

                    <div class="bg-white rounded-2xl p-5 text-center border-b-2 border-[#008b92]">
                        <h2 class="text-3xl font-black text-[#008b92]">{{ $menu->protein ?? 0 }}g</h2>
                        <p class="text-xs text-gray-500 font-bold mt-1">PROTEIN</p>
                    </div>

                    <div class="bg-white rounded-2xl p-5 text-center">
                        <h2 class="text-3xl font-black">{{ $menu->lemak ?? 0 }}g</h2>
                        <p class="text-xs text-gray-500 font-bold mt-1">LEMAK</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 mt-8 items-start">
                <div class="text-[#be1622] text-xl">📍</div>
                <div>
                    <h4 class="font-black">
                        {{ $menu->umkm->nama_usaha ?? 'UMKM SIGMA' }}
                    </h4>
                    <p class="text-gray-500 text-sm mt-1">
                        {{ $menu->umkm->alamat ?? 'Alamat belum tersedia' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-5 mt-10">
                <a href="https://wa.me/{{ $menu->umkm->whatsapp ?? '6281234567890' }}"
                   target="_blank"
                   class="bg-[#be1622] text-white px-10 py-5 rounded-full font-black shadow-xl">
                    💬 Pesan via WhatsApp
                </a>

                <a href="#lokasi"
                   class="bg-[#e8e1dc] px-10 py-5 rounded-full font-black">
                    🗺 Lihat Lokasi
                </a>
            </div>
        </div>
    </div>

    {{-- TENTANG MENU --}}
    <section class="mt-24">
        <h2 class="text-3xl lg:text-4xl font-black">Tentang Menu Ini</h2>

        <p class="max-w-4xl text-gray-700 leading-8 mt-6 text-lg">
            {{ $menu->deskripsi }}
        </p>

        <div class="flex flex-wrap gap-4 mt-8">
            <span class="bg-blue-100 text-blue-700 px-6 py-3 rounded-full font-black">
                {{ $menu->badge_1 ?: 'Tanpa MSG' }}
            </span>

            <span class="bg-blue-100 text-blue-700 px-6 py-3 rounded-full font-black">
                {{ $menu->badge_2 ?: 'Fresh Made Every Day' }}
            </span>

            <span class="bg-blue-100 text-blue-700 px-6 py-3 rounded-full font-black">
                {{ $menu->badge_3 ?: 'Halal Certified' }}
            </span>
        </div>
    </section>

    {{-- PASANGAN SEMPURNA --}}
    <section class="mt-24">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-3xl lg:text-4xl font-black">Pasangan Sempurna</h2>
                <p class="text-gray-600 mt-2">
                    Lengkapi asupan nutrisimu dengan menu pendamping pilihan.
                </p>
            </div>

            <a href="{{ route('menu.index') }}"
               class="text-[#be1622] font-bold underline text-sm">
                Lihat Semua
            </a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($relatedMenus as $related)
                <a href="{{ route('menu.show', $related->id) }}"
                   class="bg-[#f6eee8] rounded-[28px] overflow-hidden hover:scale-[1.02] transition">

                    <img src="{{ $related->image_url }}"
                         class="w-full h-[250px] object-cover"
                         alt="{{ $related->nama }}">

                    <div class="p-5">
                        <h3 class="font-black">{{ $related->nama }}</h3>

                        <p class="text-[#be1622] text-sm font-black mt-2">
                            Rp{{ number_format($related->harga, 0, ',', '.') }}
                        </p>
                    </div>
                </a>
            @empty
                <p class="text-gray-500">Belum ada menu pendamping.</p>
            @endforelse
        </div>
    </section>

    {{-- REVIEW + LOKASI --}}
    <section class="mt-24 grid lg:grid-cols-[.85fr_1.15fr] gap-10 items-start">

        <div class="bg-[#f6eee8] rounded-[32px] p-8">
            <h2 class="text-3xl font-black mb-6">Review Mahasiswa</h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-5 py-4 rounded-2xl font-bold mb-5">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($menu->reviews as $review)
                <div class="bg-white rounded-2xl p-5 mb-4">
                    <div class="flex justify-between">
                        <b>{{ $review->nama_user }}</b>
                        <span>⭐ {{ $review->rating }}</span>
                    </div>

                    <p class="text-gray-600 mt-3 leading-7">
                        {{ $review->komentar }}
                    </p>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-5 mb-4">
                    <div class="flex justify-between">
                        <b>Belum ada review</b>
                        <span>⭐ -</span>
                    </div>

                    <p class="text-gray-600 mt-3 leading-7">
                        Jadilah yang pertama memberi review untuk menu ini.
                    </p>
                </div>
            @endforelse

            <form action="{{ route('menu.review', $menu->id) }}"
                  method="POST"
                  class="bg-white rounded-2xl p-5 mt-6">
                @csrf

                <h3 class="text-xl font-black mb-5">Tulis Review</h3>

                <div class="mb-4">
                    <label class="font-bold text-sm">Nama Kamu</label>
                    <input type="text"
                           name="nama_user"
                           value="{{ old('nama_user') }}"
                           placeholder="Contoh: Ganda"
                           class="w-full mt-2 bg-[#f6eee8] rounded-xl px-4 py-3 outline-none">
                    @error('nama_user')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="font-bold text-sm">Rating</label>
                    <select name="rating"
                            class="w-full mt-2 bg-[#f6eee8] rounded-xl px-4 py-3 outline-none">
                        <option value="5">5 - Sangat Bagus</option>
                        <option value="4">4 - Bagus</option>
                        <option value="3">3 - Cukup</option>
                        <option value="2">2 - Kurang</option>
                        <option value="1">1 - Buruk</option>
                    </select>
                    @error('rating')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="font-bold text-sm">Komentar</label>
                    <textarea name="komentar"
                              rows="4"
                              placeholder="Tulis pengalaman kamu..."
                              class="w-full mt-2 bg-[#f6eee8] rounded-xl px-4 py-3 outline-none">{{ old('komentar') }}</textarea>
                    @error('komentar')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="mt-5 bg-[#be1622] text-white px-7 py-4 rounded-full font-black shadow-lg">
                    Kirim Review
                </button>
            </form>
        </div>

        <div id="lokasi" class="relative h-[520px] rounded-[34px] overflow-hidden shadow-xl bg-[#f6eee8]">
            <iframe
                src="https://maps.google.com/maps?q={{ urlencode($menu->umkm->alamat ?? 'Telkom University Bandung') }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                class="w-full h-full border-0"
                loading="lazy">
            </iframe>

            <div class="absolute left-8 bottom-8 bg-white/90 backdrop-blur rounded-[26px] p-6 max-w-[360px] shadow-xl">
                <h3 class="font-black text-lg">Lokasi Strategis</h3>
                <p class="text-gray-600 text-sm leading-6 mt-2">
                    {{ $menu->umkm->alamat ?? 'Alamat belum tersedia.' }}
                </p>

                <a target="_blank"
                   href="https://www.google.com/maps/search/{{ urlencode($menu->umkm->alamat ?? 'Telkom University Bandung') }}"
                   class="inline-block text-[#be1622] font-black mt-4">
                    Ambil Rute
                </a>
            </div>
        </div>
    </section>
</section>
@endsection