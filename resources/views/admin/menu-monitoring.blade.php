@extends('layouts.admin')

@section('title', 'Monitoring Menu - SIGMA')

@section('content')
<div class="mb-10">
    <h1 class="text-4xl font-black">Monitoring Menu</h1>
    <p class="text-gray-600 text-lg mt-2">
        Pantau seluruh menu dari semua mitra UMKM dan pilih menu utama untuk tampil di beranda.
    </p>
</div>

<div class="bg-[#f6eee8] rounded-[34px] overflow-hidden">
    <table class="w-full">
        <thead class="bg-[#eee4dc]">
            <tr class="text-left tracking-[2px] text-sm">
                <th class="p-6">MENU</th>
                <th class="p-6">UMKM</th>
                <th class="p-6">HARGA</th>
                <th class="p-6">STATUS</th>
                <th class="p-6">BERANDA</th>
                <th class="p-6">AKSI</th>
            </tr>
        </thead>

        <tbody>
            @forelse($menus as $menu)
                <tr class="border-b border-[#e3d8cf]">
                    <td class="p-6">
                        <div class="flex items-center gap-4">
                            <img src="{{ $menu->image_url }}"
                                 class="w-14 h-14 rounded-full object-cover bg-[#eee4dc]"
                                 alt="{{ $menu->nama }}">

                            <div>
                                <span class="font-black block">{{ $menu->nama }}</span>
                                <span class="text-xs text-gray-500">{{ $menu->tag ?? 'Menu SIGMA' }}</span>
                            </div>
                        </div>
                    </td>

                    <td class="p-6">
                        {{ $menu->umkm->nama_usaha ?? '-' }}
                    </td>

                    <td class="p-6 font-black">
                        Rp{{ number_format($menu->harga, 0, ',', '.') }}
                    </td>

                    <td class="p-6">
                        @if($menu->status === 'Aktif')
                            <span class="bg-green-100 text-green-700 px-5 py-2 rounded-full font-black text-sm">
                                Aktif
                            </span>
                        @else
                            <span class="bg-gray-200 text-gray-700 px-5 py-2 rounded-full font-black text-sm">
                                Nonaktif
                            </span>
                        @endif
                    </td>

                    <td class="p-6">
                        @if($menu->is_featured)
                            <span class="bg-[#be1622] text-white px-5 py-2 rounded-full font-black text-sm">
                                Tampil di Beranda
                            </span>
                        @else
                            <span class="bg-white text-gray-500 px-5 py-2 rounded-full font-black text-sm">
                                Tidak Tampil
                            </span>
                        @endif
                    </td>

                    <td class="p-6">
                        @if($menu->status === 'Aktif')
                            @if(!$menu->is_featured)
                                <form action="{{ route('admin.menu.featured', $menu->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="bg-[#be1622] text-white px-5 py-2 rounded-full font-black text-sm shadow-lg">
                                        Tampilkan
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.menu.unfeatured', $menu->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="bg-gray-800 text-white px-5 py-2 rounded-full font-black text-sm">
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        @else
                            <span class="text-gray-400 text-sm font-bold">
                                Menu nonaktif
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-10 text-center text-gray-500">
                        Belum ada menu.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection