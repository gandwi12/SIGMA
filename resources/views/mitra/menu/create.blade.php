@extends('layouts.mitra')

@section('title', 'Tambah Menu - SIGMA')

@section('content')
<div class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-4xl font-black">Tambah Menu</h1>
        <p class="text-gray-600 text-lg mt-2">
            Upload foto makanan, scan nutrisi dengan AI, lalu simpan menu Anda.
        </p>
    </div>

    <a href="{{ route('mitra.menu.index') }}"
       class="bg-[#e8e1dc] px-7 py-4 rounded-full font-black">
        ← Kembali
    </a>
</div>

<form action="{{ route('mitra.menu.store') }}" method="POST" enctype="multipart/form-data"
      class="grid lg:grid-cols-[1fr_.85fr] gap-8">
    @csrf

    <div class="bg-[#f6eee8] rounded-[34px] p-10">
        <h2 class="text-3xl font-black mb-8">Informasi Menu</h2>

        <div class="space-y-6">
            <div>
                <label class="font-bold text-sm">Nama Menu</label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                       placeholder="Contoh: Nasi Ayam Geprek Protein+"
                       class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
            </div>

            <div>
                <label class="font-bold text-sm">Harga</label>
                <input type="number" name="harga" value="{{ old('harga') }}"
                       placeholder="15000"
                       class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
            </div>

            <div>
                <label class="font-bold text-sm">Tag Menu</label>
                <select name="tag" class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
                    <option value="Tinggi Protein">Tinggi Protein</option>
                    <option value="Rendah Kalori">Rendah Kalori</option>
                    <option value="Paling Hemat">Paling Hemat</option>
                    <option value="Best Seller">Best Seller</option>
                </select>
            </div>

            <div>
                <label class="font-bold text-sm">Status</label>
                <select name="status" class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>

            <div>
                <label class="font-bold text-sm">Deskripsi</label>
                <textarea name="deskripsi" rows="5"
                          placeholder="Ceritakan menu ini..."
                          class="w-full mt-3 bg-white rounded-[28px] px-7 py-5 outline-none">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="pt-6 border-t border-[#e3d8cf]">
                <p class="text-[#be1622] font-black tracking-[3px] text-xs mb-5">
                    BADGE DETAIL MENU
                </p>

                <div class="space-y-5">
                    <div>
                        <label class="font-bold text-sm">Badge Menu 1</label>
                        <input type="text" name="badge_1" value="{{ old('badge_1') }}"
                               placeholder="Contoh: Tanpa MSG"
                               class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
                    </div>

                    <div>
                        <label class="font-bold text-sm">Badge Menu 2</label>
                        <input type="text" name="badge_2" value="{{ old('badge_2') }}"
                               placeholder="Contoh: Fresh Made Every Day"
                               class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
                    </div>

                    <div>
                        <label class="font-bold text-sm">Badge Menu 3</label>
                        <input type="text" name="badge_3" value="{{ old('badge_3') }}"
                               placeholder="Contoh: Halal Certified"
                               class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-8">

        <div class="bg-[#f6eee8] rounded-[34px] p-8">
            <h2 class="text-2xl font-black mb-2">Scanner AI Nutrisi</h2>
            <p class="text-gray-500 text-sm mb-6">
                Upload foto makanan untuk mendeteksi estimasi kalori dan kandungan nutrisi.
            </p>

            <label for="fotoMenu"
                   class="block bg-white rounded-[28px] border-2 border-dashed border-[#ead0c6] min-h-[260px] cursor-pointer overflow-hidden">
                <div id="fotoPlaceholder" class="h-[260px] flex flex-col items-center justify-center text-center">
                    <div class="text-[#be1622] text-5xl mb-4">☁</div>
                    <h3 class="font-black">Pilih Foto Makanan</h3>
                    <p class="text-gray-500 text-sm mt-2">PNG, JPG, WEBP maks. 5MB</p>
                </div>

                <img id="fotoPreview" class="hidden w-full h-[300px] object-cover" alt="Preview Menu">

                <input id="fotoMenu" type="file" name="foto" accept="image/*" class="hidden">
            </label>

            <button type="button" id="scanKaloriBtn"
                    class="w-full mt-5 bg-[#be1622] text-white rounded-full py-4 font-black shadow-lg">
                Jalankan Scanner AI
            </button>

            <p id="scanInfo" class="hidden text-sm text-gray-500 mt-4">
                AI sedang menganalisis foto makanan...
            </p>
        </div>

        <div id="hasilScannerBox" class="hidden bg-white rounded-[34px] p-8 shadow-xl">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[#be1622] text-xs font-black tracking-[3px]">
                        HASIL ANALISIS AI
                    </p>
                    <h2 id="hasilNamaMenu" class="text-3xl font-black mt-2">
                        Estimasi Nutrisi
                    </h2>
                </div>

                <div class="bg-[#be1622] text-white rounded-full px-7 py-4 text-center">
                    <h3 class="text-2xl font-black">
                        <span id="hasilKaloriText">0</span>
                    </h3>
                    <p class="text-xs font-bold">KCAL</p>
                </div>
            </div>

            <p id="hasilDeskripsiAI" class="text-gray-600 leading-7 mt-5">
                Sistem memberikan estimasi berdasarkan foto makanan. Hasil ini bisa diedit manual sebelum menu disimpan.
            </p>

            <div class="grid grid-cols-3 gap-4 mt-7">
                <div class="bg-[#f6eee8] rounded-2xl p-4 text-center">
                    <h3 class="text-2xl font-black">
                        <span id="kaloriShow">0</span>
                    </h3>
                    <p class="text-xs text-gray-500 font-bold">KALORI</p>
                </div>

                <div class="bg-[#f6eee8] rounded-2xl p-4 text-center">
                    <h3 class="text-2xl font-black text-[#008b92]">
                        <span id="proteinShow">0</span>g
                    </h3>
                    <p class="text-xs text-gray-500 font-bold">PROTEIN</p>
                </div>

                <div class="bg-[#f6eee8] rounded-2xl p-4 text-center">
                    <h3 class="text-2xl font-black">
                        <span id="lemakShow">0</span>g
                    </h3>
                    <p class="text-xs text-gray-500 font-bold">LEMAK</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 mt-6">
                <input id="kaloriInput" type="number" name="kalori" value="{{ old('kalori') }}"
                       placeholder="Kalori"
                       class="bg-[#f6eee8] rounded-2xl px-4 py-4 outline-none text-center font-black">

                <input id="proteinInput" type="number" name="protein" value="{{ old('protein') }}"
                       placeholder="Protein"
                       class="bg-[#f6eee8] rounded-2xl px-4 py-4 outline-none text-center font-black">

                <input id="lemakInput" type="number" name="lemak" value="{{ old('lemak') }}"
                       placeholder="Lemak"
                       class="bg-[#f6eee8] rounded-2xl px-4 py-4 outline-none text-center font-black">
            </div>
        </div>

        <button type="submit"
                class="w-full bg-[#be1622] text-white rounded-full py-5 font-black text-lg shadow-xl">
            Simpan Menu →
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fotoInput = document.getElementById('fotoMenu');
    const preview = document.getElementById('fotoPreview');
    const placeholder = document.getElementById('fotoPlaceholder');

    const scanBtn = document.getElementById('scanKaloriBtn');
    const scanInfo = document.getElementById('scanInfo');

    const hasilBox = document.getElementById('hasilScannerBox');
    const hasilNamaMenu = document.getElementById('hasilNamaMenu');
    const hasilKaloriText = document.getElementById('hasilKaloriText');
    const hasilDeskripsiAI = document.getElementById('hasilDeskripsiAI');

    const kaloriShow = document.getElementById('kaloriShow');
    const proteinShow = document.getElementById('proteinShow');
    const lemakShow = document.getElementById('lemakShow');

    const kaloriInput = document.getElementById('kaloriInput');
    const proteinInput = document.getElementById('proteinInput');
    const lemakInput = document.getElementById('lemakInput');

    const namaInput = document.querySelector('input[name="nama"]');

    fotoInput.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) return;

        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');

        hasilBox.classList.add('hidden');
        scanInfo.classList.add('hidden');

        kaloriInput.value = '';
        proteinInput.value = '';
        lemakInput.value = '';
    });

    scanBtn.addEventListener('click', async function () {
        if (!fotoInput.files.length) {
            alert('Upload foto makanan dulu.');
            return;
        }

        scanBtn.disabled = true;
        scanBtn.textContent = 'Menganalisis...';

        scanInfo.classList.remove('hidden');
        scanInfo.textContent = 'AI sedang menganalisis foto makanan...';

        const formData = new FormData();
        formData.append('foto', fotoInput.files[0]);

        try {
            formData.append('_token', '{{ csrf_token() }}');

            const response = await fetch("{{ route('scanner.analyze-food') }}", {
                method: "POST",
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },
                body: formData
            });

            const rawText = await response.text();

            let data;

            try {
                data = JSON.parse(rawText);
            } catch (e) {
                throw new Error('Response bukan JSON: ' + rawText.substring(0, 300));
            }

            if (!response.ok) {
                throw new Error(data.description || data.message || 'Scanner AI gagal.');
            }

            const foodName = data.food_name || 'Menu Terdeteksi';
            const calories = data.calories || 0;
            const protein = data.protein || 0;
            const fat = data.fat || 0;
            const confidence = data.confidence || 0;
            const description = data.description || 'Hasil estimasi berhasil dibuat oleh AI. Silakan koreksi jika diperlukan.';

            hasilBox.classList.remove('hidden');

            hasilNamaMenu.textContent = foodName;
            hasilKaloriText.textContent = calories;

            kaloriShow.textContent = calories;
            proteinShow.textContent = protein;
            lemakShow.textContent = fat;

            kaloriInput.value = calories;
            proteinInput.value = protein;
            lemakInput.value = fat;

            hasilDeskripsiAI.textContent = description;

            if (!namaInput.value) {
                namaInput.value = foodName;
            }

            scanInfo.textContent = 'AI confidence ' + confidence + '%';
            scanBtn.textContent = 'Scan Ulang dengan AI';

        } catch (error) {
            console.error(error);

            scanInfo.classList.remove('hidden');
            scanInfo.textContent = error.message;

            alert(error.message || 'Scanner AI gagal.');
            scanBtn.textContent = 'Jalankan Scanner AI';

        } finally {
            scanBtn.disabled = false;
        }
    });
});
</script>
@endsection