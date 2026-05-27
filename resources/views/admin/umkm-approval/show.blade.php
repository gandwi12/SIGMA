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

    @if(session('success'))
        <div class="mb-8 bg-green-100 border border-green-200 text-green-800 px-6 py-4 rounded-[20px] font-bold">
            {{ session('success') }}
        </div>
    @endif

    @if(session('dev_credentials'))
        <div class="mb-8 bg-[#f6eee8] border-2 border-[#be1622] text-[#171717] px-6 py-5 rounded-[20px] flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <strong class="text-[#be1622] flex items-center gap-2"><span class="text-xl">🛠️</span> [DEV MODE] Kredensial UMKM:</strong>
                <div class="mt-2 text-sm">
                    <div>Email: <span class="font-black font-mono bg-white px-2 py-1 rounded">{{ session('dev_credentials.email') }}</span></div>
                    <div class="mt-1">Password: <span class="font-black font-mono bg-white px-2 py-1 rounded">{{ session('dev_credentials.password') }}</span></div>
                </div>
            </div>
            <button onclick="navigator.clipboard.writeText('Email: {{ session('dev_credentials.email') }}\nPassword: {{ session('dev_credentials.password') }}').then(() => alert('Kredensial berhasil disalin!'))" 
                    class="bg-[#be1622] text-white px-5 py-3 rounded-full font-black text-sm shadow-xl hover:bg-[#a9131d] transition shrink-0">
                Salin Kredensial
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-8 bg-red-100 border border-red-200 text-red-800 px-6 py-4 rounded-[20px] font-bold">
            {{ session('error') }}
        </div>
    @endif

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
            @elseif($umkm->status === 'Aktif')
                <div class="flex gap-4 mt-10">
                    <form action="{{ route('admin.umkm.reset-password', $umkm->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mereset password akun UMKM ini? Password baru akan otomatis digenerate.');">
                        @csrf
                        <button type="submit" class="bg-blue-600 text-white px-8 py-4 rounded-full font-black shadow-lg hover:bg-blue-700 transition">
                            Reset Password UMKM
                        </button>
                    </form>
                </div>
            @endif
        </div>

    </div>

</section>
@endsection