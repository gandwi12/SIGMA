@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')

<div class="p-10">

    <h1 class="text-3xl font-bold mb-8">
        Edit Menu
    </h1>

    <form action="{{ route('menu.update', $menu->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white p-8 rounded-3xl">

        @csrf
        @method('PUT')

        <div class="mb-5">

            <label>Nama Menu</label>

            <input type="text"
                name="nama_menu"
                value="{{ $menu->nama_menu }}"
                class="w-full border p-3 rounded-xl mt-2">

        </div>

        <div class="mb-5">

            <label>Harga</label>

            <input type="text"
                name="harga"
                value="{{ $menu->harga }}"
                class="w-full border p-3 rounded-xl mt-2">

        </div>

        <div class="mb-5">

            <label>Informasi Gizi</label>

            <input type="text"
                name="gizi"
                value="{{ $menu->gizi }}"
                class="w-full border p-3 rounded-xl mt-2">

        </div>

        <div class="mb-5">

            <label>Status</label>

            <select name="status"
                class="w-full border p-3 rounded-xl mt-2">

                <option value="Tersedia"
                    {{ $menu->status == 'Tersedia' ? 'selected' : '' }}>
                    Tersedia
                </option>

                <option value="Habis"
                    {{ $menu->status == 'Habis' ? 'selected' : '' }}>
                    Habis
                </option>

            </select>

        </div>

        <div class="mb-5">

            <label>Gambar Baru</label>

            <input type="file"
                name="gambar"
                class="w-full border p-3 rounded-xl mt-2">

        </div>

        <button class="bg-blue-600 text-white px-6 py-3 rounded-xl">
            Update
        </button>

    </form>

</div>

@endsection