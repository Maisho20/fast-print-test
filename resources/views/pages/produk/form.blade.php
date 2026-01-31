@extends('pages.layouts.pages')

@section('title', isset($produk) ? 'Edit Produk' : 'Tambah Produk')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

        <h2 class="text-xl font-semibold mb-4">
            {{ isset($produk) ? 'Edit Produk' : 'Tambah Produk' }}
        </h2>

        <form method="POST"
            action="{{ isset($produk) ? route('produk.update', $produk->id_produk) : route('produk.store') }}">
            @csrf
            @isset($produk)
                @method('PUT')
            @endisset

            <div class="mb-4">
                <label class="block mb-1">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk ?? '') }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Harga</label>
                <input type="number" name="harga" value="{{ old('harga', $produk->harga ?? '') }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Kategori</label>
                <select name="kategori_id" class="w-full border rounded px-3 py-2">
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id_kategori }}"
                            @isset($produk)
                            {{ $produk->kategori_id == $k->id_kategori ? 'selected' : '' }}
                        @endisset>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Status</label>
                <select name="status_id" class="w-full border rounded px-3 py-2">
                    @foreach ($status as $s)
                        <option value="{{ $s->id_status }}"
                            @isset($produk)
                            {{ $produk->status_id == $s->id_status ? 'selected' : '' }}
                        @endisset>
                            {{ $s->nama_status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('produk.index') }}" class="text-gray-600 hover:underline">Kembali</a>

                <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Simpan
                </button>
            </div>

        </form>
    </div>
@endsection
