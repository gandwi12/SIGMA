@extends('layouts.mitra')

@section('title', 'Profil UMKM - SIGMA')

@section('content')
<div class="flex justify-between items-start mb-10">
    <div>
        <h1 class="text-4xl font-black">Profil UMKM</h1>
        <p class="text-gray-600 text-lg mt-2">
            Update informasi usaha yang tampil di halaman publik.
        </p>
    </div>

    @if($umkm)
        <a href="{{ route('umkm.show', $umkm->id) }}"
           class="bg-[#be1622] text-white px-8 py-4 rounded-full font-black shadow-xl">
            Lihat Halaman Publik →
        </a>
    @endif
</div>

@if($umkm)
<form action="{{ route('mitra.profile.update') }}"
      method="POST"
      enctype="multipart/form-data"
      class="grid lg:grid-cols-[.85fr_1.15fr] gap-8">
    @csrf
    @method('PUT')

    <div class="space-y-8">
        <div class="bg-white rounded-[34px] overflow-hidden shadow-sm">
            <img src="{{ $umkm->image_url }}"
                 class="w-full h-[330px] object-cover bg-[#eee4dc]"
                 alt="{{ $umkm->nama_usaha }}">

            <div class="p-8">
                <label class="font-bold text-sm">Ganti Foto UMKM</label>
                <input type="file"
                       name="foto"
                       accept="image/*"
                       class="w-full mt-3 bg-[#f6eee8] rounded-full px-6 py-4">
            </div>
        </div>

        <div class="bg-[#be1622] text-white rounded-[34px] p-8">
            <h2 class="text-2xl font-black">Status UMKM</h2>
            <p class="text-4xl font-black mt-4">{{ $umkm->status }}</p>
        </div>
    </div>

    <div class="bg-[#f6eee8] rounded-[34px] p-8">
        <h2 class="text-2xl font-black mb-7">Edit Detail Usaha</h2>

        <div class="space-y-5">
            <div>
                <label class="font-bold text-sm">Nama UMKM</label>
                <input type="text" name="nama_usaha"
                       value="{{ old('nama_usaha', $umkm->nama_usaha) }}"
                       class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
            </div>

            <div>
                <label class="font-bold text-sm">Kategori</label>
                <select name="kategori" class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
                    @foreach(['Makanan Saja', 'Makanan Sehat', 'Makanan dan Minuman', 'Minuman Saja'] as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori', $umkm->kategori) == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-bold text-sm">Lokasi</label>
                <input type="text" name="lokasi"
                       value="{{ old('lokasi', $umkm->lokasi) }}"
                       class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
            </div>

            <div>
                <label class="font-bold text-sm">Alamat Lengkap</label>
                <textarea name="alamat" rows="3"
                          class="w-full mt-3 bg-white rounded-[26px] px-7 py-5 outline-none">{{ old('alamat', $umkm->alamat) }}</textarea>
            </div>

            <div>
                <label class="font-bold text-sm">WhatsApp</label>
                <input type="text" name="whatsapp"
                       value="{{ old('whatsapp', $umkm->whatsapp) }}"
                       class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
            </div>

            <div>
                <label class="font-bold text-sm">Jam Operasional</label>
                <input type="text" name="jam_operasional"
                       value="{{ old('jam_operasional', $umkm->jam_operasional) }}"
                       class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
            </div>

            <div>
                <label class="font-bold text-sm">Deskripsi Singkat Usaha</label>
                <textarea name="deskripsi" rows="4"
                          class="w-full mt-3 bg-white rounded-[26px] px-7 py-5 outline-none">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
            </div>

            <div class="pt-8 border-t border-[#e3d8cf]">
                <p class="text-[#be1622] font-black tracking-[4px] text-sm">SEJARAH & WARISAN</p>

                <div class="mt-5">
                    <label class="font-bold text-sm">Judul Sejarah</label>
                    <input type="text" name="sejarah_judul"
                           value="{{ old('sejarah_judul', $umkm->sejarah_judul) }}"
                           placeholder="Contoh: Menjaga Nyala Pawon Sejak 1974"
                           class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
                </div>

                <div class="mt-5">
                    <label class="font-bold text-sm">Deskripsi Sejarah</label>
                    <textarea name="sejarah_deskripsi" rows="5"
                              placeholder="Ceritakan sejarah usaha Anda..."
                              class="w-full mt-3 bg-white rounded-[26px] px-7 py-5 outline-none">{{ old('sejarah_deskripsi', $umkm->sejarah_deskripsi) }}</textarea>
                </div>
            </div>

            <div class="pt-8 border-t border-[#e3d8cf]">
                <p class="text-[#be1622] font-black tracking-[4px] text-sm">FILOSOFI KAMI</p>

                @for($i = 1; $i <= 3; $i++)
                    <div class="mt-5">
                        <label class="font-bold text-sm">Filosofi {{ $i }} - Judul</label>
                        <input type="text"
                               name="filosofi_{{ $i }}_judul"
                               value="{{ old('filosofi_'.$i.'_judul', $umkm->{'filosofi_'.$i.'_judul'}) }}"
                               class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">

                        <textarea name="filosofi_{{ $i }}_deskripsi" rows="2"
                                  placeholder="Deskripsi filosofi {{ $i }}"
                                  class="w-full mt-3 bg-white rounded-[22px] px-7 py-5 outline-none">{{ old('filosofi_'.$i.'_deskripsi', $umkm->{'filosofi_'.$i.'_deskripsi'}) }}</textarea>
                    </div>
                @endfor
            </div>

            <div class="pt-8 border-t border-[#e3d8cf]">
                <p class="text-[#be1622] font-black tracking-[4px] text-sm">STATISTIK PROFIL</p>

                <div class="grid md:grid-cols-3 gap-5 mt-5">
                    @for($i = 1; $i <= 3; $i++)
                        <div>
                            <label class="font-bold text-sm">Statistik {{ $i }}</label>

                            <input type="text"
                                   name="stat_{{ $i }}_value"
                                   value="{{ old('stat_'.$i.'_value', $umkm->{'stat_'.$i.'_value'}) }}"
                                   placeholder="{{ $i == 1 ? '50th' : ($i == 2 ? '100%' : 'Zero') }}"
                                   class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">

                            <input type="text"
                                   name="stat_{{ $i }}_label"
                                   value="{{ old('stat_'.$i.'_label', $umkm->{'stat_'.$i.'_label'}) }}"
                                   placeholder="{{ $i == 1 ? 'Tahun Tradisi' : ($i == 2 ? 'Resep Autentik' : 'MSG Tambahan') }}"
                                   class="w-full mt-3 bg-white rounded-full px-7 py-5 outline-none">
                        </div>
                    @endfor
                </div>
            </div>

            <div class="pt-8 border-t border-[#e3d8cf]">
                <p class="text-[#be1622] font-black tracking-[4px] text-sm">FASILITAS & SERTIFIKASI</p>

                <div class="grid md:grid-cols-3 gap-5 mt-5">
                    <input type="text" name="fasilitas_1"
                           value="{{ old('fasilitas_1', $umkm->fasilitas_1) }}"
                           placeholder="Free Wi-Fi"
                           class="w-full bg-white rounded-full px-7 py-5 outline-none">

                    <input type="text" name="fasilitas_2"
                           value="{{ old('fasilitas_2', $umkm->fasilitas_2) }}"
                           placeholder="Halal Certified"
                           class="w-full bg-white rounded-full px-7 py-5 outline-none">

                    <input type="text" name="fasilitas_3"
                           value="{{ old('fasilitas_3', $umkm->fasilitas_3) }}"
                           placeholder="Mushola"
                           class="w-full bg-white rounded-full px-7 py-5 outline-none">
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-[#be1622] text-white py-5 rounded-full font-black text-lg shadow-xl mt-8">
                Simpan Perubahan →
            </button>
        </div>
    </div>
</form>
@else
    <div class="bg-[#f6eee8] rounded-[34px] p-10 text-center">
        <h2 class="text-3xl font-black">Belum Ada UMKM Aktif</h2>
    </div>
@endif
@endsection