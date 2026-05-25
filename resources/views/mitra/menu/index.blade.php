@extends('layouts.mitra')

@section('title', 'Kelola Menu - SIGMA')

@section('content')
<div class="flex justify-between items-start mb-10">
    <div>
        <h1 class="text-4xl font-black">Kelola Menu</h1>
        <p class="text-gray-600 text-lg mt-2">
            Perbarui daftar hidangan dan pantau performa menu Anda.
        </p>
    </div>

    <div class="flex gap-4">
        <button class="bg-[#e8e1dc] px-8 py-4 rounded-full font-black flex items-center gap-3">
            ⬇ Laporan
        </button>

        <a href="{{ route('mitra.menu.create') }}"
           class="bg-[#be1622] text-white px-8 py-4 rounded-full font-black shadow-xl flex items-center gap-3">
            ⊕ Tambah Menu
        </a>
    </div>
</div>

<div class="grid lg:grid-cols-[1.8fr_.9fr] gap-8 mb-10">
    <div class="bg-white rounded-[34px] p-8">
        <h2 class="text-2xl font-black mb-6">Menu Terpopuler</h2>

        @if($menuTerpopuler)
            <div class="flex items-center gap-7">
                <img src="{{ $menuTerpopuler->image_url }}"
                     class="w-28 h-28 rounded-2xl object-cover bg-[#eee4dc]"
                     alt="{{ $menuTerpopuler->nama }}">

                <div>
                    <h3 class="text-2xl font-black">{{ $menuTerpopuler->nama }}</h3>
                    <p class="text-gray-600 mt-1">Terjual 128 porsi minggu ini</p>

                    <div class="flex gap-2 mt-3">
                        <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-xs font-black">
                            {{ $menuTerpopuler->tag ?? 'TINGGI PROTEIN' }}
                        </span>

                        <span class="bg-[#008b92] text-white px-4 py-1 rounded-full text-xs font-black">
                            BEST SELLER
                        </span>
                    </div>
                </div>
            </div>

            <div class="border-t mt-7 pt-6 flex justify-between">
                <p class="text-gray-600">Tren performa menu meningkat 12%</p>
                <a href="{{ route('menu.show', $menuTerpopuler->id) }}"
                   class="text-[#be1622] font-black">
                    Lihat Detail →
                </a>
            </div>
        @else
            <p class="text-gray-500">Belum ada menu.</p>
        @endif
    </div>

    <div class="bg-[#be1622] text-white rounded-[34px] p-9 relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-2xl font-black">Menu Termurah</h2>

            @if($menuTermurah)
                <h3 class="text-5xl font-black mt-5">
                    Rp{{ number_format($menuTermurah->harga, 0, ',', '.') }}
                </h3>

                <p class="text-lg mt-2">{{ $menuTermurah->nama }}</p>
            @else
                <h3 class="text-4xl font-black mt-5">Rp0</h3>
                <p class="text-lg mt-2">Belum ada menu</p>
            @endif

            <span class="inline-block bg-white/20 px-6 py-2 rounded-full mt-16 font-bold">
                Rating: 4.8/5.0
            </span>
        </div>

        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full"></div>
    </div>
</div>

<div class="bg-[#f6eee8] rounded-[34px] overflow-hidden">
    <div class="flex justify-between items-center p-8">
        <h2 class="text-3xl font-black">Daftar Menu Aktif</h2>

        <div class="bg-[#e8e1dc] rounded-full px-6 py-4 w-[300px]">
            🔍
            <input type="text"
                   id="searchMenuInput"
                   placeholder="Cari nama menu..."
                   class="bg-transparent outline-none ml-2 w-[220px]">
        </div>
    </div>

    <table class="w-full">
        <thead class="bg-[#eee4dc]">
            <tr class="text-left tracking-[2px] text-sm">
                <th class="p-6">MENU</th>
                <th class="p-6">HARGA</th>
                <th class="p-6">INFORMASI GIZI</th>
                <th class="p-6">STATUS</th>
                <th class="p-6">AKSI</th>
            </tr>
        </thead>

        <tbody id="menuTableBody">
            @forelse($menus as $menu)
                <tr class="border-b border-[#e3d8cf] menu-row"
                    data-name="{{ strtolower($menu->nama) }}">
                    <td class="p-6">
                        <div class="flex items-center gap-5">
                            <img src="{{ $menu->image_url }}"
                                 class="w-16 h-16 rounded-full object-cover bg-[#eee4dc]"
                                 alt="{{ $menu->nama }}">

                            <h3 class="font-black text-lg">{{ $menu->nama }}</h3>
                        </div>
                    </td>

                    <td class="p-6 font-black text-lg">
                        Rp{{ number_format($menu->harga, 0, ',', '.') }}
                    </td>

                    <td class="p-6">
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-xs">
                                {{ $menu->kalori ?? 0 }} kcal
                            </span>

                            <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-xs">
                                {{ $menu->protein ?? 0 }}g Protein
                            </span>

                            <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-xs">
                                {{ $menu->lemak ?? 0 }}g Lemak
                            </span>
                        </div>
                    </td>

                    <td class="p-6">
                        @if($menu->status === 'Aktif')
                            <span class="bg-green-100 text-green-700 px-5 py-2 rounded-full font-black text-sm">
                                ● Aktif
                            </span>
                        @else
                            <span class="bg-gray-200 text-gray-600 px-5 py-2 rounded-full font-black text-sm">
                                ● Nonaktif
                            </span>
                        @endif
                    </td>

                    <td class="p-6">
                        <div class="flex gap-5 items-center">
                            <a href="{{ route('mitra.menu.edit', $menu->id) }}"
                               class="text-xl hover:scale-110 transition"
                               title="Edit menu">
                                ✎
                            </a>

                            <button type="button"
                                    data-url="{{ route('mitra.menu.destroy', $menu->id) }}"
                                    data-name="{{ $menu->nama }}"
                                    class="delete-menu-btn text-red-600 text-xl hover:scale-110 transition"
                                    title="Hapus menu">
                                🗑
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-10 text-center text-gray-500">
                        Belum ada menu. Klik Tambah Menu dulu.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-8 flex justify-between items-center">
        <p class="text-gray-600">
            Menampilkan {{ $menus->count() }} menu
        </p>

        <div class="flex gap-3">
            <button class="w-10 h-10 rounded-full bg-white">‹</button>
            <button class="w-10 h-10 rounded-full bg-white">›</button>
        </div>
    </div>
</div>

<div id="deleteModal"
     class="hidden fixed inset-0 z-[9999] bg-black/40 backdrop-blur-sm items-center justify-center px-5">
    <div class="bg-white rounded-[34px] p-8 w-full max-w-[430px] shadow-2xl text-center">
        <div class="w-16 h-16 mx-auto rounded-full bg-red-100 text-[#be1622] grid place-items-center text-3xl mb-5">
            🗑
        </div>

        <h2 class="text-2xl font-black">Hapus Menu?</h2>

        <p class="text-gray-500 mt-3 leading-7">
            Apakah Anda yakin ingin menghapus
            <span id="deleteMenuName" class="font-black text-[#171717]"></span>?
            Data ini tidak bisa dikembalikan.
        </p>

        <div class="flex gap-3 mt-8">
            <button type="button"
                    onclick="closeDeleteModal()"
                    class="flex-1 bg-[#e8e1dc] py-4 rounded-full font-black hover:bg-[#ded5ce] transition">
                Tidak
            </button>

            <form id="deleteForm" method="POST" class="flex-1">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="w-full bg-[#be1622] text-white py-4 rounded-full font-black shadow-lg hover:bg-[#a9131d] transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal(actionUrl, menuName) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const name = document.getElementById('deleteMenuName');

    form.action = actionUrl;
    name.textContent = menuName;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-menu-btn').forEach(button => {
        button.addEventListener('click', function () {
            openDeleteModal(this.dataset.url, this.dataset.name);
        });
    });

    const searchInput = document.getElementById('searchMenuInput');
    const rows = document.querySelectorAll('.menu-row');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();

            rows.forEach(row => {
                const name = row.dataset.name || '';
                row.style.display = name.includes(keyword) ? '' : 'none';
            });
        });
    }
});
</script>
@endsection