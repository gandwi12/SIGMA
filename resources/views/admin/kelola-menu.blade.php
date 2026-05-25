@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-5xl font-black">Kelola Menu</h1>
        <p class="text-gray-500 mt-3">Atur menu makanan yang tampil di aplikasi SIGMA.</p>
    </div>

    <a href="{{ route('menu.create') }}"
       class="bg-[#be1622] text-white px-8 py-4 rounded-full font-black shadow-xl">
        + Tambah Menu
    </a>
</div>

<div class="grid lg:grid-cols-3 gap-8 mb-12">
    <div class="bg-white rounded-[35px] p-8">
        <p class="text-gray-500">Total Menu</p>
        <h2 class="text-5xl font-black mt-3">{{ $menus->count() }}</h2>
    </div>

    <div class="bg-white rounded-[35px] p-8">
        <p class="text-gray-500">Menu Aktif</p>
        <h2 class="text-5xl font-black mt-3">
            {{ $menus->where('status', 'Aktif')->count() }}
        </h2>
    </div>

    <div class="bg-[#be1622] text-white rounded-[35px] p-8">
        <p class="text-white/80">Harga Termurah</p>
        <h2 class="text-4xl font-black mt-3">
            Rp{{ number_format($menus->min('harga') ?? 0, 0, ',', '.') }}
        </h2>
    </div>
</div>

<div class="bg-white rounded-[35px] overflow-hidden shadow-sm">
    <div class="p-8 flex justify-between items-center">
        <h2 class="text-3xl font-black">Daftar Menu</h2>

        <input type="text"
               placeholder="Cari nama menu..."
               class="bg-[#f6eee8] px-6 py-3 rounded-full outline-none">
    </div>

    <table class="w-full">
        <thead class="bg-[#f6eee8] text-left">
            <tr>
                <th class="p-6">Menu</th>
                <th>Harga</th>
                <th>Nutrisi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($menus as $menu)
            <tr class="border-b">
                <td class="p-6">
                    <div class="flex items-center gap-4">
                        <img src="{{ $menu->image_url }}"
                             class="w-16 h-16 rounded-2xl object-cover">

                        <div>
                            <h3 class="font-black">{{ $menu->nama }}</h3>
                            <p class="text-sm text-gray-500">{{ $menu->tag }}</p>
                        </div>
                    </div>
                </td>

                <td class="font-bold">
                    Rp{{ number_format($menu->harga, 0, ',', '.') }}
                </td>

                <td>
                    <div class="flex gap-2">
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                            {{ $menu->kalori }} kcal
                        </span>
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                            {{ $menu->protein }}g protein
                        </span>
                    </div>
                </td>

                <td>
                    <span class="px-4 py-2 rounded-full text-sm font-bold
                        {{ $menu->status == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                        {{ $menu->status }}
                    </span>
                </td>

                <td>
                    <div class="flex gap-3">
                        <a href="{{ route('menu.edit', $menu->id) }}"
                           class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-xl font-bold">
                            Edit
                        </a>

                        <form action="{{ route('menu.destroy', $menu->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin hapus menu ini?')">
                            @csrf
                            @method('DELETE')

                            <button class="bg-red-100 text-red-700 px-4 py-2 rounded-xl font-bold">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection