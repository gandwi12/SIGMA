@extends('layouts.admin')

@section('content')
<div class="mb-10">
    <h1 class="text-5xl font-black">Edit Menu</h1>
    <p class="text-gray-500 mt-3">Perbarui data menu yang sudah ada.</p>
</div>

<div class="bg-white rounded-[35px] p-10 shadow-sm">
    <form action="{{ route('menu.update', $menu->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="grid lg:grid-cols-2 gap-8">

        @csrf
        @method('PUT')

        <div>
            <label class="font-bold">Nama Menu</label>
            <input type="text" name="nama" value="{{ $menu->nama }}"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none">
        </div>

        <div>
            <label class="font-bold">Harga</label>
            <input type="number" name="harga" value="{{ $menu->harga }}"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none">
        </div>

        <div>
            <label class="font-bold">UMKM</label>
            <select name="umkm_id"
                    class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none">
                @foreach($umkms as $umkm)
                    <option value="{{ $umkm->id }}" {{ $menu->umkm_id == $umkm->id ? 'selected' : '' }}>
                        {{ $umkm->nama_usaha }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="font-bold">Kategori</label>
            <select name="category_id"
                    class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $menu->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="font-bold">Kalori</label>
            <input type="number" name="kalori" value="{{ $menu->kalori }}"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none">
        </div>

        <div>
            <label class="font-bold">Protein</label>
            <input type="number" name="protein" value="{{ $menu->protein }}"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none">
        </div>

        <div>
            <label class="font-bold">Lemak</label>
            <input type="number" name="lemak" value="{{ $menu->lemak }}"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none">
        </div>

        <div>
            <label class="font-bold">Karbo</label>
            <input type="number" name="karbo" value="{{ $menu->karbo }}"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none">
        </div>

        <div>
            <label class="font-bold">Tag</label>
            <input type="text" name="tag" value="{{ $menu->tag }}"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none">
        </div>

        <div>
            <label class="font-bold">Status</label>
            <select name="status"
                    class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none">
                <option value="Aktif" {{ $menu->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Nonaktif" {{ $menu->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div>
            <label class="font-bold">Gambar Baru</label>
            <input type="file" name="gambar"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl">
        </div>

        <div>
            <label class="font-bold">Gambar Saat Ini</label>
            <img src="{{ $menu->image_url }}"
                 class="w-full h-40 object-cover rounded-2xl mt-2">
        </div>

        <div class="lg:col-span-2">
            <label class="font-bold">Deskripsi</label>
            <textarea name="deskripsi" rows="5"
                      class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none">{{ $menu->deskripsi }}</textarea>
        </div>

        <div class="lg:col-span-2 flex gap-4">
            <button class="bg-[#be1622] text-white px-10 py-5 rounded-full font-black shadow-xl">
                Update Menu
            </button>

            <a href="{{ route('menu.admin') }}"
               class="bg-[#e7dfd8] px-10 py-5 rounded-full font-black">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection