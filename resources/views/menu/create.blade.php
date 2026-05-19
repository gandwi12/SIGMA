@extends('layouts.app')

@section('title', 'Tambah Menu')

@section('content')

<div class="p-10">

    <h1 class="text-3xl font-bold mb-8">
        Tambah Menu
    </h1>

    <form action="{{ route('menu.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white p-8 rounded-3xl">

        @csrf

        <div class="mb-5">

            <label>Nama Menu</label>

            <input type="text"
                name="nama_menu"
                class="w-full border p-3 rounded-xl mt-2">

        </div>

        <div class="mb-5">

            <label>Harga</label>

            <input type="text"
                name="harga"
                class="w-full border p-3 rounded-xl mt-2">

        </div>

        <div class="mb-5">

            <label>Informasi Gizi</label>

            <input type="text"
                name="gizi"
                class="w-full border p-3 rounded-xl mt-2">

        </div>

        <div class="mb-5">

            <label>Status</label>

            <select name="status"
                class="w-full border p-3 rounded-xl mt-2">

               <option value="Tersedia">
    Tersedia
</option>

<option value="Habis">
    Habis
</option>

            </select>

        </div>

        <div class="mb-5">

            <label>Gambar</label>

            <input type="file"
                name="gambar"
                class="w-full border p-3 rounded-xl mt-2">

        </div>

        <button class="bg-red-600 text-white px-6 py-3 rounded-xl">
            Simpan
        </button>

    </form>

</div>

@endsection