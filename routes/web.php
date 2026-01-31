<?php

use App\Http\Controllers\ProdukImportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/import-produk', [ProdukImportController::class, 'import'])->name('import.produk');
