@extends('layouts.app')

@section('title', 'Review UMKM - Admin SIGMA')

@section('content')
<section class="px-8 lg:px-12 xl:px-16 py-10">
    <div class="mb-8">
    <a href="{{ url()->previous() }}"
       class="inline-flex items-center gap-3 bg-[#be1622] text-white px-7 py-4 rounded-full font-black shadow-lg hover:bg-[#a9131d] transition">
        Kembali
    </a>
</div>

    <div class="grid lg:grid-cols-[0.9fr_1.1fr] gap-10">

        <div>
            <img src="{{ $umkm->image_url }}"
                 class="w-full h-[420px] object-cover rounded-[34px] shadow-xl"
                 alt="{{ $umkm->nama_usaha }}">

            <div class="grid grid-cols-3 gap-4 mt-5">
                @foreach($umkm->photos as $photo)
                    <img src="{{ $photo->image_url }}"
                         class="w-full h-[120px] object-cover rounded-2xl"
                         alt="Foto UMKM">
                @endforeach
            </div>
        </div>

        <div class="bg-[#f6eee8] rounded-[34px] p-10">
            <h1 class="text-4xl font-black">{{ $umkm->nama_usaha }}</h1>

            <div class="mt-6 space-y-4 text-lg">
                <p><b>Kategori:</b> {{ $umkm->kategori }}</p>
                <p><b>Lokasi:</b> {{ $umkm->lokasi }}</p>
                <p><b>Alamat:</b> {{ $umkm->alamat }}</p>
                <p><b>WhatsApp:</b> {{ $umkm->whatsapp }}</p>
                <p><b>Jam Operasional:</b> {{ $umkm->jam_operasional }}</p>
                <p><b>Deskripsi:</b> {{ $umkm->deskripsi }}</p>
                <p><b>Status:</b> {{ strtoupper($umkm->status) }}</p>
            </div>

            @if($umkm->status === 'pending')
                <div class="flex gap-4 mt-10">
                    <form action="{{ route('admin.umkm.approve', $umkm->id) }}" method="POST">
                        @csrf
                        <button class="bg-green-600 text-white px-8 py-4 rounded-full font-black">
                            Approve
                        </button>
                    </form>

                    <form action="{{ route('admin.umkm.reject', $umkm->id) }}" method="POST" class="flex gap-3">
                        @csrf
                        <input type="text"
                               name="catatan_admin"
                               placeholder="Alasan ditolak"
                               class="bg-white rounded-full px-6 py-4 outline-none">

                        <button class="bg-[#be1622] text-white px-8 py-4 rounded-full font-black">
                            Reject
                        </button>
                    </form>
                </div>
            @endif
        </div>

    </div>

</section>
@endsection