@extends('layouts.app')

@section('title', 'Dashboard Kelola Menu')

@section('content')

<div class="flex min-h-screen bg-[#F6F1EC]">

    <!-- SIDEBAR -->
    <div class="w-60 bg-white p-6 flex flex-col justify-between shadow-sm">

        <div>

            <div class="mb-10">

                <h1 class="text-3xl font-bold text-red-600">
                    SIGMA
                </h1>

                <p class="text-gray-400 text-xs tracking-widest">
                    ADMIN PORTAL
                </p>

            </div>

            <div class="space-y-3 text-sm">

                <div class="flex items-center gap-3 text-gray-700 p-3">
                    <span>📊</span>
                    <span>Dashboard</span>
                </div>

                <div class="flex items-center gap-3 text-gray-700 p-3">
                    <span>🏪</span>
                    <span>Daftar UMKM</span>
                </div>

                <div class="bg-red-500 text-white px-4 py-3 rounded-2xl flex items-center gap-3 shadow">

                    <span>🍴</span>
                    <span>Kelola Menu</span>

                </div>

                <div class="flex items-center gap-3 text-gray-700 p-3">
                    <span>📈</span>
                    <span>Analistik</span>
                </div>

            </div>

        </div>

        <!-- PROFILE -->
        <div class="bg-gray-100 rounded-3xl p-4 flex items-center gap-3">

            <img src="{{ asset('images/avatar.png') }}"
                class="w-12 h-12 rounded-full object-cover">

            <div>

                <h1 class="font-semibold text-sm">
                    Warung Sigma
                </h1>

                <p class="text-xs text-gray-500">
                    Admin UMKM
                </p>

            </div>

        </div>

    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-1 p-8">

        <!-- ALERT -->
        @if(session('success'))

            <div class="bg-green-100 text-green-700 px-5 py-4 rounded-2xl mb-6">
                {{ session('success') }}
            </div>

        @endif

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-8">

            <div>

                <h1 class="text-4xl font-bold">
                    Kelola Menu
                </h1>

                <p class="text-gray-500 mt-1 text-sm">
                    Perbarui daftar hidangan dan pantau performa menu Anda.
                </p>

            </div>

            <div class="flex gap-4">

                <button class="bg-gray-200 px-6 py-3 rounded-full text-sm font-medium">
                    ⬇ Laporan
                </button>

                <!-- BUTTON TAMBAH -->
                <a href="{{ route('menu.create') }}"
                    class="bg-red-600 text-white px-6 py-3 rounded-full text-sm font-medium shadow-lg">

                    + Tambah Menu

                </a>

            </div>

        </div>

        <!-- TOP CARD -->
        <div class="grid grid-cols-3 gap-5 mb-8">

            <!-- POPULER -->
            <div class="col-span-2 bg-white rounded-[30px] p-8 shadow-sm">

                <h1 class="font-bold text-2xl mb-6">
                    Menu Terpopuler
                </h1>

                <div class="flex items-center gap-5">

                    <img src="{{ asset('images/menu1.jpg') }}"
                        class="w-28 h-28 rounded-2xl object-cover">

                    <div>

                        <h1 class="text-2xl font-bold">
                            Nasi Ayam Geprek Protein+
                        </h1>

                        <p class="text-gray-500 text-sm mt-1">
                            Terjual 128 porsi minggu ini
                        </p>

                        <div class="flex gap-3 mt-4">

                            <span class="bg-blue-100 text-xs px-4 py-2 rounded-full">
                                TINGGI PROTEIN
                            </span>

                            <span class="bg-teal-600 text-white text-xs px-4 py-2 rounded-full">
                                BEST SELLER
                            </span>

                        </div>

                    </div>

                </div>

            </div>

            <!-- TERMURAH -->
            <div class="bg-red-600 text-white rounded-[30px] p-8 shadow-sm">

                <h1 class="text-2xl font-bold">
                    Menu Termurah
                </h1>

                <h1 class="text-5xl font-bold mt-4">
                    Rp12.000
                </h1>

                <p class="mt-2 text-lg">
                    Tempe Mendoan Platter
                </p>

            </div>

        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-[30px] p-8 shadow-sm">

            <div class="flex justify-between items-center mb-6">

                <h1 class="text-2xl font-bold">
                    Daftar Menu
                </h1>

                <input type="text"
                    placeholder="Cari nama menu..."
                    class="bg-gray-100 px-5 py-3 rounded-full w-72 text-sm outline-none">

            </div>

            <table class="w-full">

                <thead>

                    <tr class="border-b text-gray-500 text-sm text-left">

                        <th class="pb-4">MENU</th>
                        <th class="pb-4">HARGA</th>
                        <th class="pb-4">INFORMASI GIZI</th>
                        <th class="pb-4">STATUS</th>
                        <th class="pb-4">AKSI</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($menus as $menu)

                    <tr class="border-b hover:bg-gray-50 transition">

                        <!-- MENU -->
                        <td class="py-5 flex items-center gap-4">

                            <img src="{{ asset('images/' . $menu->gambar) }}"
                                class="w-14 h-14 rounded-full object-cover">

                            <div>

                                <div class="font-semibold">
                                    {{ $menu->nama_menu }}
                                </div>

                                <div class="text-xs text-gray-400 mt-1">
                                    Klik untuk lihat detail nutrisi
                                </div>

                            </div>

                        </td>

                        <!-- HARGA -->
                        <td class="font-medium">
                            Rp{{ number_format((int)$menu->harga, 0, ',', '.') }}
                        </td>

                        <!-- GIZI -->
                        <td>

                            <a href="#"
                                class="bg-blue-100 hover:bg-blue-200 transition text-xs px-3 py-2 rounded-full">

                                {{ $menu->gizi }}

                            </a>

                        </td>

                        <!-- STATUS -->
                        <td>

                            @if($menu->status == 'Tersedia')

                                <span class="bg-green-100 text-green-700 text-xs px-3 py-2 rounded-full">
                                    ● Tersedia
                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 text-xs px-3 py-2 rounded-full">
                                    ● Habis
                                </span>

                            @endif

                        </td>

                        <!-- AKSI -->
                        <td class="space-x-3">

                            <!-- EDIT -->
                            <a href="{{ route('menu.edit', $menu->id) }}"
                                class="text-blue-600 text-lg">

                                ✏

                            </a>

                            <!-- DELETE -->
                            <form id="delete-form-{{ $menu->id }}"
                                action="{{ route('menu.destroy', $menu->id) }}"
                                method="POST"
                                class="inline">

                                @csrf
                                @method('DELETE')

                                <button type="button"
                                    onclick="confirmDelete({{ $menu->id }})"
                                    class="text-red-600 text-lg">

                                    🗑

                                </button>

                            </form>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- SWEET ALERT -->
<script>

function confirmDelete(id)
{
    Swal.fire({
        title: 'Hapus Menu?',
        text: 'Data menu akan dihapus permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (result.isConfirmed)
        {
            document.getElementById('delete-form-' + id).submit();
        }

    });
}

</script>

@endsection