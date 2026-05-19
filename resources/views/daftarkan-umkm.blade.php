@extends('layouts.app')

@section('content')

<div class="min-h-screen py-10">

{{-- ── HERO SECTION ──────────────────────────────────── --}}
<div class="relative -mx-6 lg:-mx-16 mb-12 overflow-hidden">
    <div class="bg-gradient-to-br from-[#2D3748] via-[#1a2333] to-[#008B92]/80 px-6 lg:px-16 py-14">
        <div class="absolute top-0 right-0 w-80 h-80 bg-[#008B92]/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-32 w-64 h-64 bg-[#cf1c26]/10 rounded-full blur-3xl translate-y-1/3"></div>

        <div class="relative max-w-[1400px] mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
            {{-- Text --}}
            <div>
                <a href="{{ route('daftar-umkm') }}" class="inline-flex items-center gap-2 text-white/60 hover:text-white text-sm font-semibold mb-6 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
                    Kembali ke Daftar UMKM
                </a>

                <div class="inline-flex items-center gap-2 bg-[#008B92]/20 text-[#008B92] border border-[#008B92]/30 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                    Daftarkan UMKM Anda
                </div>

                <h1 class="text-4xl lg:text-5xl font-black text-white leading-tight mb-4">
                    Daftarkan<br>
                    <span class="text-[#008B92]">UMKM</span> Anda
                </h1>
                <p class="text-white/60 text-sm lg:text-base leading-relaxed max-w-md">
                    Bergabunglah dengan ekosistem digital SIGMA. Bantu mahasiswa menemukan makanan bergizi dengan harga terjangkau sambil mengembangkan usaha kuliner Anda.
                </p>

                <div class="flex items-center gap-2 mt-6 bg-white/10 backdrop-blur rounded-2xl px-5 py-4 max-w-xs">
                    <div class="w-10 h-10 bg-[#008B92] rounded-full flex items-center justify-center text-white font-black text-sm shrink-0">1.2k</div>
                    <div>
                        <p class="text-white font-bold text-sm">1.200+ Mahasiswa</p>
                        <p class="text-white/50 text-xs">Sudah bergabung di seluruh area kampus</p>
                    </div>
                </div>
            </div>

            {{-- Illustration --}}
            <div class="hidden md:flex justify-center items-center">
                <div class="relative">
                    <div class="w-64 h-64 bg-white/10 rounded-full blur-2xl absolute inset-0 scale-110"></div>
                    <div class="relative bg-white/10 backdrop-blur rounded-3xl p-8 text-center border border-white/20">
                        <div class="w-24 h-24 bg-gradient-to-br from-[#008B92] to-[#2D3748] rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/><path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"/><path d="M12 3v6"/></svg>
                        </div>
                        <p class="text-white font-bold text-lg mb-1">Warung Anda</p>
                        <p class="text-white/60 text-xs">Tampil di platform SIGMA</p>
                        <div class="mt-4 flex gap-2 justify-center">
                            <span class="w-2 h-2 bg-[#008B92] rounded-full animate-pulse"></span>
                            <span class="w-2 h-2 bg-white/30 rounded-full"></span>
                            <span class="w-2 h-2 bg-white/30 rounded-full"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 40" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 40L1440 40L1440 10C1200 40 960 0 720 15C480 30 240 5 0 30L0 40Z" fill="#FDF8F3"/>
        </svg>
    </div>
</div>

{{-- ── VALIDATION ERRORS ──────────────────────────────── --}}
@if($errors->any())
<div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-5">
    <p class="font-bold text-red-700 text-sm mb-2">Mohon perbaiki kesalahan berikut:</p>
    <ul class="list-disc list-inside space-y-1">
        @foreach($errors->all() as $error)
        <li class="text-red-600 text-xs">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- ── FORM ──────────────────────────────────────────── --}}
<form action="{{ route('daftarkan-umkm.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-3xl mx-auto">
    @csrf

    {{-- Bagian 1: Info Usaha --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-7">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center text-sigma">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/><path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"/><path d="M12 3v6"/></svg>
            </div>
            <h2 class="text-base font-bold text-[#2D3748]">Informasi Usaha</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2">Nama Usaha <span class="text-sigma">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="Contoh: Warung Nasi Ibu Sri"
                       class="w-full bg-[#FDF8F3] border border-gray-200 focus:border-[#008B92] focus:bg-white rounded-xl px-4 py-3 text-sm font-medium text-gray-700 outline-none transition-colors @error('name') border-red-400 @enderror">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2">Kategori Usaha <span class="text-sigma">*</span></label>
                <select name="kategori"
                        class="w-full bg-[#FDF8F3] border border-gray-200 focus:border-[#008B92] focus:bg-white rounded-xl px-4 py-3 text-sm font-medium text-gray-700 outline-none transition-colors @error('kategori') border-red-400 @enderror">
                    <option value="">Pilih Kategori</option>
                    @foreach(['Makanan','Minuman','Snack','Vegetarian','Seafood'] as $kat)
                    <option value="{{ strtolower($kat) }}" {{ old('kategori') === strtolower($kat) ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
                @error('kategori')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    {{-- Bagian 2: Kontak & Lokasi --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-7">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-9 h-9 bg-teal-50 rounded-xl flex items-center justify-center text-[#008B92]">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <h2 class="text-base font-bold text-[#2D3748]">Kontak &amp; Lokasi</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2">Lokasi Usaha <span class="text-sigma">*</span></label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                       placeholder="Alamat lengkap atau koordinat"
                       class="w-full bg-[#FDF8F3] border border-gray-200 focus:border-[#008B92] focus:bg-white rounded-xl px-4 py-3 text-sm font-medium text-gray-700 outline-none transition-colors @error('lokasi') border-red-400 @enderror">
                @error('lokasi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2">Nomor WhatsApp <span class="text-sigma">*</span></label>
                <div class="flex">
                    <span class="bg-gray-100 border border-r-0 border-gray-200 rounded-l-xl px-3 flex items-center text-sm text-gray-500 font-semibold">+62</span>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                           placeholder="8123456789"
                           class="flex-1 bg-[#FDF8F3] border border-gray-200 focus:border-[#008B92] focus:bg-white rounded-r-xl px-4 py-3 text-sm font-medium text-gray-700 outline-none transition-colors @error('whatsapp') border-red-400 @enderror">
                </div>
                @error('whatsapp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    {{-- Bagian 3: Detail Operasional --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-7">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <h2 class="text-base font-bold text-[#2D3748]">Detail Operasional</h2>
        </div>

        <div class="space-y-5">
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2">Jam Operasional <span class="text-sigma">*</span></label>
                <input type="text" name="jam_operasional" value="{{ old('jam_operasional') }}"
                       placeholder="Contoh: 08:00 – 20:00"
                       class="w-full bg-[#FDF8F3] border border-gray-200 focus:border-[#008B92] focus:bg-white rounded-xl px-4 py-3 text-sm font-medium text-gray-700 outline-none transition-colors @error('jam_operasional') border-red-400 @enderror">
                @error('jam_operasional')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-2">Deskripsi Usaha</label>
                <textarea name="description" rows="4"
                          placeholder="Ceritakan keunikan menu Anda, spesialisasi, dll..."
                          class="w-full bg-[#FDF8F3] border border-gray-200 focus:border-[#008B92] focus:bg-white rounded-xl px-4 py-3 text-sm font-medium text-gray-700 outline-none transition-colors resize-none">{{ old('description') }}</textarea>
            </div>
        </div>
    </div>

    {{-- Bagian 4: Foto Produk --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-7">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center text-purple-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
            </div>
            <h2 class="text-base font-bold text-[#2D3748]">Foto Produk &amp; Menu</h2>
        </div>

        {{-- Upload Area --}}
        <div class="relative border-2 border-dashed border-gray-200 hover:border-[#008B92] rounded-2xl p-8 text-center transition-colors cursor-pointer"
             id="upload-area"
             onclick="document.getElementById('foto-input').click()">
            <input type="file" name="foto" id="foto-input" accept="image/jpg,image/jpeg,image/png,image/webp"
                   class="hidden" onchange="previewFoto(this)">

            <div id="upload-placeholder">
                <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-4 text-sigma">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                </div>
                <p class="font-bold text-gray-700 text-sm mb-1">Tarik &amp; lepaskan foto di sini</p>
                <p class="text-gray-400 text-xs">PNG, JPG atau WebP (Maks. 5MB per file)</p>
            </div>

            <div id="foto-preview" class="hidden">
                <img id="preview-img" src="" alt="Preview" class="max-h-48 mx-auto rounded-xl object-contain">
                <p class="text-xs text-gray-400 mt-3">Klik untuk ganti foto</p>
            </div>
        </div>
        @error('foto')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
    </div>

    {{-- Submit --}}
    <div class="text-center pb-4">
        <button type="submit"
                class="inline-flex items-center gap-3 bg-sigma hover:bg-sigma-dark active:scale-95 text-white font-bold py-4 px-12 rounded-full text-base transition-all shadow-2xl shadow-red-300/40">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/><path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"/><line x1="12" y1="14" x2="12" y2="18"/><line x1="10" y1="16" x2="14" y2="16"/></svg>
            Daftarkan Sekarang
        </button>
        <p class="text-xs text-gray-400 mt-4">
            Dengan mendaftar, Anda menyetujui <a href="#" class="text-sigma underline">Syarat &amp; Ketentuan</a> kemitraan SIGMA.
        </p>
    </div>
</form>

</div>

<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('upload-placeholder').classList.add('hidden');
            document.getElementById('foto-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Drag & drop
const uploadArea = document.getElementById('upload-area');
uploadArea.addEventListener('dragover', e => { e.preventDefault(); uploadArea.classList.add('border-[#008B92]', 'bg-teal-50/30'); });
uploadArea.addEventListener('dragleave', () => { uploadArea.classList.remove('border-[#008B92]', 'bg-teal-50/30'); });
uploadArea.addEventListener('drop', e => {
    e.preventDefault();
    uploadArea.classList.remove('border-[#008B92]', 'bg-teal-50/30');
    const files = e.dataTransfer.files;
    if (files.length) {
        const input = document.getElementById('foto-input');
        input.files = files;
        previewFoto(input);
    }
});
</script>

@endsection
