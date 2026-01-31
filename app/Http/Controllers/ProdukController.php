<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Status;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::with(['kategori', 'status'])->get();
        return view('pages.produk.produk-list', compact('produk'));
    }

    public function bisaDijual()
    {
        $produk = Produk::whereHas('status', function ($q) {
            $q->where('nama_status', 'bisa dijual');
        })->with(['kategori', 'status'])->get();

        return view('pages.produk.produk-dijual', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.produk.form', [
            'kategori' => Kategori::all(),
            'status' => Status::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required',
            'status_id' => 'required',
        ]);

        Produk::create([
            'id_produk' => Produk::max('id_produk') + 1,
            ...$request->all()
        ]);

        return redirect()->route('produk.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Produk::findOrFail($id);

        return view('pages.produk.form', [
            'produk' => $produk,
            'kategori' => Kategori::all(),
            'status' => Status::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategori,id_kategori',
            'status_id' => 'required|exists:status,id_status',
        ]);

        $produk = Produk::findOrFail($id);

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'kategori_id' => $request->kategori_id,
            'status_id' => $request->status_id,
        ]);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);

        $produk->delete();

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}
