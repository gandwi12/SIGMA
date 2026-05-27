@extends('layouts.app')

@section('title', 'Daftar UMKM - SIGMA')

@section('content')
<section class="w-full px-8 lg:px-12 xl:px-16 pb-24">

    {{-- HERO --}}
    <div class="max-w-[1100px] mx-auto grid lg:grid-cols-[0.9fr_1.1fr] gap-12 items-center mt-2 mb-12">
        <div>
            <h1 class="text-[44px] lg:text-[56px] leading-[0.98] font-black tracking-[-3px] text-[#be1622]">
                Daftarkan UMKM<br>
                Anda
            </h1>

            <p class="text-gray-600 mt-6 leading-8 text-[17px] max-w-[460px]">
                Bergabunglah dengan ekosistem digital SIGMA. Bantu
                mahasiswa menemukan makanan bergizi dengan harga
                terjangkau sambil mengembangkan usaha kuliner Anda.
            </p>
        </div>

        <div class="relative flex justify-end">
            <img src="{{ asset('images/hero/pexels-nachoestevo-36920183.jpg') }}"
                 alt="Owner UMKM"
                 class="w-[410px] h-[360px] object-cover rounded-[40px] shadow-xl">

            <div class="absolute left-[20px] bottom-[-18px] bg-[#008b92] text-white rounded-[24px] px-7 py-5 shadow-2xl">
                <h3 class="text-2xl font-black">1.2k+</h3>
                <p class="text-xs font-bold leading-5 mt-1">
                    UMKM telah bergabung di<br>
                    seluruh area kampus
                </p>
            </div>
        </div>
    </div>

    {{-- FORM CARD --}}
    <div class="max-w-[980px] mx-auto bg-[#f6eee8] rounded-[42px] px-12 lg:px-14 py-14">

        <form action="{{ route('umkm.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if(session('success'))
                <div class="mb-8 rounded-[24px] bg-green-100 border border-green-200 p-5 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-8 rounded-[24px] bg-red-100 border border-red-200 p-5 text-red-800">
                    <strong class="font-bold">Terjadi kesalahan:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- INFORMASI USAHA --}}
            <div class="mb-10">
                <div class="flex items-center gap-4 mb-7">
                    <div class="w-11 h-11 rounded-full bg-red-100 text-[#be1622] grid place-items-center text-xl">
                        🏪
                    </div>
                    <h2 class="text-3xl font-black">Informasi Usaha</h2>
                </div>

                <div class="grid lg:grid-cols-2 gap-6">
                    <div>
                        <label class="font-bold text-sm">Nama usaha</label>
                        <input type="text"
                               name="nama_usaha"
                               value="{{ old('nama_usaha') }}"
                               placeholder="Contoh: Warung Nasi Ibu Sri"
                               class="w-full mt-3 bg-[#e8e1dc] rounded-full px-7 py-5 outline-none">
                    </div>

                    {{-- INI BAGIAN KATEGORI USAHA --}}
                    <div>
                        <label class="font-bold text-sm">Kategori usaha</label>

                        <div class="relative mt-3">
                            <select name="kategori"
                                    class="appearance-none w-full bg-[#e8e1dc] rounded-full px-7 py-5 pr-16 outline-none text-gray-700">
                                <option value="">Pilih Kategori</option>
                                <option value="Makanan Tradisional">Makanan Tradisional</option>
                                <option value="Makanan Sehat">Makanan Sehat</option>
                                <option value="Minuman">Minuman</option>
                                <option value="Camilan">Camilan</option>
                            </select>

                            <span class="absolute right-7 top-1/2 -translate-y-1/2 text-2xl font-black text-gray-500 pointer-events-none">
                                ˅
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KONTAK & LOKASI --}}
            <div class="mb-10">
                <div class="flex items-center gap-4 mb-7">
                    <div class="w-11 h-11 rounded-full bg-blue-100 text-blue-600 grid place-items-center text-xl">
                        📍
                    </div>
                    <h2 class="text-3xl font-black">Kontak & Lokasi</h2>
                </div>

                <div class="grid lg:grid-cols-2 gap-6">
                    <div>
                        <label class="font-bold text-sm">Lokasi usaha</label>
                        <input type="text"
                               name="lokasi"
                               value="{{ old('lokasi') }}"
                               placeholder="Alamat lengkap atau koordinat"
                               class="w-full mt-3 bg-[#e8e1dc] rounded-full px-7 py-5 outline-none">
                    </div>

                    <div>
                        <label class="font-bold text-sm">Nomor WhatsApp</label>
                        <input type="text"
                               name="whatsapp"
                               value="{{ old('whatsapp') }}"
                               placeholder="+62 8123456789"
                               class="w-full mt-3 bg-[#e8e1dc] rounded-full px-7 py-5 outline-none">
                    </div>

                    <div class="lg:col-span-2">
                        <label class="font-bold text-sm">Alamat lengkap</label>
                        <textarea name="alamat"
                                  rows="3"
                                  placeholder="Contoh: Jl. Lingkar Kampus, Blok B-12"
                                  class="w-full mt-3 bg-[#e8e1dc] rounded-[28px] px-7 py-5 outline-none">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- DETAIL OPERASIONAL --}}
            <div class="mb-10">
                <div class="flex items-center gap-4 mb-7">
                    <div class="w-11 h-11 rounded-full bg-cyan-100 text-cyan-700 grid place-items-center text-xl">
                        🕘
                    </div>
                    <h2 class="text-3xl font-black">Detail Operasional</h2>
                </div>

                <div class="grid lg:grid-cols-2 gap-6">
                    <div>
                        <label class="font-bold text-sm">Jam operasional</label>
                        <input type="text"
                               name="jam_operasional"
                               value="{{ old('jam_operasional') }}"
                               placeholder="Contoh: 08:00 - 20:00"
                               class="w-full mt-3 bg-[#e8e1dc] rounded-full px-7 py-5 outline-none">
                    </div>

                    <div class="hidden lg:block"></div>

                    <div class="lg:col-span-2">
                        <label class="font-bold text-sm">Deskripsi usaha</label>
                        <textarea name="deskripsi"
                                  rows="5"
                                  placeholder="Ceritakan keunikan menu Anda..."
                                  class="w-full mt-3 bg-[#e8e1dc] rounded-[30px] px-7 py-5 outline-none">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- FOTO PRODUK --}}
            <div class="mb-12">
                <div class="flex items-center gap-4 mb-7">
                    <div class="w-11 h-11 rounded-full bg-[#e8e1dc] text-[#be1622] grid place-items-center text-xl">
                        📷
                    </div>
                    <h2 class="text-3xl font-black">Foto Produk & Menu</h2>
                </div>

                <label for="fotoProduk"
                       class="block border-2 border-dashed border-[#ead0c6] bg-white rounded-[30px] min-h-[250px] cursor-pointer">
                    <div class="h-[250px] flex flex-col items-center justify-center text-center">
                        <div class="text-[#be1622] text-5xl mb-4">☁</div>
                        <h3 class="font-black">Klik untuk upload foto produk</h3>
                        <p class="text-gray-500 text-sm mt-2">
                            Bisa upload 1–10 foto. PNG, JPG, WEBP. Maks 5MB/foto.
                        </p>
                    </div>

                    <input id="fotoProduk"
                           type="file"
                           name="fotos[]"
                           accept="image/*"
                           multiple
                           class="hidden">
                </label>

                <div id="previewGrid" class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6"></div>

                <p id="fotoWarning" class="hidden text-[#be1622] font-bold text-sm mt-3">
                    Maksimal 10 foto saja.
                </p>
            </div>

            <div class="text-center">
                <button type="submit"
                        class="bg-[#be1622] text-white px-14 py-5 rounded-full text-lg font-black shadow-xl hover:bg-[#a9131d] transition">
                    Daftarkan Sekarang <span class="ml-3">➤</span>
                </button>

                <p class="text-gray-500 text-xs mt-6">
                    Dengan menekan tombol di atas, Anda menyetujui
                    <a href="#" class="underline font-bold">Syarat & Ketentuan</a>
                    kemitraan SIGMA.
                </p>
            </div>

        </form>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('fotoProduk');
    const previewGrid = document.getElementById('previewGrid');
    const warning = document.getElementById('fotoWarning');

    let selectedFiles = [];

    input.addEventListener('change', function () {
        const newFiles = Array.from(this.files);
        const combined = selectedFiles.concat(newFiles);

        if (combined.length > 10) {
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }

        selectedFiles = combined.slice(0, 10);

        syncInputFiles();
        renderPreviews();
    });

    function renderPreviews() {
        previewGrid.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const url = URL.createObjectURL(file);

            const item = document.createElement('div');
            item.className = 'relative bg-white rounded-[22px] overflow-hidden shadow-md';

            item.innerHTML = `
                <img src="${url}" class="w-full h-[180px] object-cover">
                <button type="button"
                        data-index="${index}"
                        class="delete-photo absolute top-3 right-3 bg-[#be1622] text-white w-9 h-9 rounded-full font-black shadow-lg">
                    ×
                </button>
                <div class="p-3">
                    <p class="text-xs font-bold truncate">${file.name}</p>
                </div>
            `;

            previewGrid.appendChild(item);
        });

        document.querySelectorAll('.delete-photo').forEach(button => {
            button.addEventListener('click', function () {
                const index = Number(this.dataset.index);
                selectedFiles.splice(index, 1);
                syncInputFiles();
                renderPreviews();
            });
        });
    }

    function syncInputFiles() {
        const dataTransfer = new DataTransfer();

        selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });

        input.files = dataTransfer.files;
    }
});
</script>
@endsection