@extends('layouts.admin')

@section('content')
<div class="mb-10">
    <h1 class="text-5xl font-black">Tambah Menu</h1>
    <p class="text-gray-500 mt-3">Masukkan data menu baru untuk ditampilkan di SIGMA.</p>
</div>

<div class="bg-white rounded-[35px] p-10 shadow-sm">
    <form action="{{ route('menu.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="grid lg:grid-cols-2 gap-8">

        @csrf

        <div>
            <label class="font-bold">Nama Menu</label>
            <input type="text" name="nama"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none"
                   placeholder="Nasi Ayam Sehat">
        </div>

        <div>
            <label class="font-bold">Harga</label>
            <input type="number" name="harga"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none"
                   placeholder="15000">
        </div>

        <div>
            <label class="font-bold">UMKM</label>
            <select name="umkm_id"
                    class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none">
                @foreach($umkms as $umkm)
                    <option value="{{ $umkm->id }}">{{ $umkm->nama_usaha }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="font-bold">Kategori</label>
            <select name="category_id"
                    class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="font-bold">Kalori</label>
            <input type="number" name="kalori"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none"
                   placeholder="450">
        </div>

        <div>
            <label class="font-bold">Protein</label>
            <input type="number" name="protein"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none"
                   placeholder="30">
        </div>

        <div>
            <label class="font-bold">Lemak</label>
            <input type="number" name="lemak"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none"
                   placeholder="12">
        </div>

        <div>
            <label class="font-bold">Karbo</label>
            <input type="number" name="karbo"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none"
                   placeholder="55">
        </div>

        <div>
            <label class="font-bold">Tag</label>
            <input type="text" name="tag"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none"
                   placeholder="Tinggi Protein">
        </div>

        <div>
            <label class="font-bold">Gambar Menu</label>
            <input type="file" name="gambar"
                   class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl">
        </div>

        <div class="lg:col-span-2">
            <label class="font-bold">Deskripsi</label>
            <textarea name="deskripsi" rows="5"
                      class="w-full mt-2 bg-[#f6eee8] px-6 py-4 rounded-2xl outline-none"
                      placeholder="Deskripsi menu..."></textarea>
        </div>

        <div class="lg:col-span-2 flex gap-4">
            <button class="bg-[#be1622] text-white px-10 py-5 rounded-full font-black shadow-xl">
                Simpan Menu
            </button>

            <a href="{{ route('menu.admin') }}"
               class="bg-[#e7dfd8] px-10 py-5 rounded-full font-black">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection