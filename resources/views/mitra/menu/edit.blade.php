@extends('layouts.mitra')

@section('title', 'Edit Menu - SIGMA')

@section('content')
<div class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-4xl font-black">Edit Menu</h1>
        <p class="text-gray-600 text-lg mt-2">Perbarui data menu UMKM Anda.</p>
    </div>

    <a href="{{ route('mitra.menu.index') }}"
       class="bg-[#e8e1dc] px-7 py-4 rounded-full font-black">
        ← Kembali
    </a>
</div>

<form action="{{ route('mitra.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data"
      class="grid lg:grid-cols-[1fr_.85fr] gap-8">
    @csrf
    @method('PUT')

    <div class="bg-[#f6eee8] rounded-[34px] p-10">
        <h2 class="text-3xl font-black mb-8">Informasi Menu</h2>

        <div class="space-y-6">
            <div>
                <label class="font-bold text-sm">Nama Menu</label>
                <input type="text" name="nama" value="{{ old('nama', $menu->nama) }}"
                       class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
            </div>

            <div>
                <label class="font-bold text-sm">Harga</label>
                <input type="number" name="harga" value="{{ old('harga', $menu->harga) }}"
                       class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
            </div>

            <div>
                <label class="font-bold text-sm">Tag Menu</label>
                <select name="tag" class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
                    @foreach(['Tinggi Protein', 'Rendah Kalori', 'Paling Hemat', 'Best Seller'] as $tag)
                        <option value="{{ $tag }}" {{ old('tag', $menu->tag) === $tag ? 'selected' : '' }}>
                            {{ $tag }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-bold text-sm">Status</label>
                <select name="status" class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
                    <option value="Aktif" {{ old('status', $menu->status) === 'Aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="Nonaktif" {{ old('status', $menu->status) === 'Nonaktif' ? 'selected' : '' }}>
                        Nonaktif
                    </option>
                </select>
            </div>

            <div>
                <label class="font-bold text-sm">Deskripsi</label>
                <textarea name="deskripsi" rows="5"
                          class="w-full mt-3 bg-white rounded-[28px] px-7 py-5 outline-none">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
            </div>

            <div class="pt-6 border-t border-[#e3d8cf]">
                <p class="text-[#be1622] font-black tracking-[3px] text-xs mb-5">
                    BADGE DETAIL MENU
                </p>

                <div class="space-y-5">
                    <div>
                        <label class="font-bold text-sm">Badge Menu 1</label>
                        <input type="text" name="badge_1"
                               value="{{ old('badge_1', $menu->badge_1) }}"
                               placeholder="Contoh: Tanpa MSG"
                               class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
                    </div>

                    <div>
                        <label class="font-bold text-sm">Badge Menu 2</label>
                        <input type="text" name="badge_2"
                               value="{{ old('badge_2', $menu->badge_2) }}"
                               placeholder="Contoh: Fresh Made Every Day"
                               class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
                    </div>

                    <div>
                        <label class="font-bold text-sm">Badge Menu 3</label>
                        <input type="text" name="badge_3"
                               value="{{ old('badge_3', $menu->badge_3) }}"
                               placeholder="Contoh: Halal Certified"
                               class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-8">
        <div class="bg-[#f6eee8] rounded-[34px] p-8">
            <h2 class="text-2xl font-black mb-6">Foto Menu</h2>

            @if($menu->image_url)
                <img src="{{ $menu->image_url }}"
                     class="w-full h-[280px] object-cover rounded-[28px] mb-5"
                     alt="{{ $menu->nama }}">
            @endif

            <input type="file" name="foto" accept="image/*"
                   class="w-full bg-white rounded-full px-6 py-4">
            <p class="text-xs text-gray-500 mt-3">Kosongkan kalau tidak ingin ganti foto.</p>
        </div>

        <div class="bg-white rounded-[34px] p-8 shadow-xl">
            <h2 class="text-2xl font-black mb-6">Informasi Gizi</h2>

            <div class="grid grid-cols-3 gap-4">
                <input type="number" name="kalori" value="{{ old('kalori', $menu->kalori) }}"
                       placeholder="Kalori"
                       class="bg-[#f6eee8] rounded-2xl px-4 py-4 outline-none text-center font-black">

                <input type="number" name="protein" value="{{ old('protein', $menu->protein) }}"
                       placeholder="Protein"
                       class="bg-[#f6eee8] rounded-2xl px-4 py-4 outline-none text-center font-black">

                <input type="number" name="lemak" value="{{ old('lemak', $menu->lemak) }}"
                       placeholder="Lemak"
                       class="bg-[#f6eee8] rounded-2xl px-4 py-4 outline-none text-center font-black">
            </div>
        </div>

        <button type="submit"
                class="w-full bg-[#be1622] text-white rounded-full py-5 font-black text-lg shadow-xl">
            Simpan Perubahan →
        </button>
    </div>
</form>
@endsection