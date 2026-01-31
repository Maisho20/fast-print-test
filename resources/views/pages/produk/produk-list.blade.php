@extends('pages.layouts.pages')

@section('title', 'Daftar Produk')

@section('content')
    <div class="bg-white p-6 rounded shadow">

        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-semibold">Data Semua Produk</h2>
            <a href="{{ route('produk.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                + Tambah Produk
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">ID Produk</th>
                    <th class="p-2 border w-8">Nama</th>
                    <th class="p-2 border">Harga</th>
                    <th class="p-2 border">Kategori</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border text-center font-medium">
                            {{ $loop->iteration }}
                        </td>

                        <td class="p-2 border text-center">{{ $item->id_produk }}</td>
                        <td class="p-2 border">{{ $item->nama_produk }}</td>
                        <td class="p-2 border">Rp {{ number_format($item->harga) }}</td>
                        <td class="p-2 border">{{ $item->kategori->nama_kategori }}</td>
                        <td class="p-2 border text-center">
                            <span
                                class="px-2 py-1 rounded text-sm
                        {{ $item->status->nama_status === 'bisa dijual' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $item->status->nama_status }}
                            </span>
                        </td>
                        <td class="p-2 border space-x-2 text-center">
                            <a href="{{ route('produk.edit', $item->id_produk) }}"
                                class="text-blue-600 hover:underline">Edit</a>

                            <form method="POST" action="{{ route('produk.destroy', $item->id_produk) }}" class="inline"
                                onsubmit="return confirm('Yakin hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
