<?php

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProdukImportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/import-produk', [ProdukImportController::class, 'import'])->name('import.produk');

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/bisa-dijual', [ProdukController::class, 'bisaDijual'])->name('produk.bisaDijual');
Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');

Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
