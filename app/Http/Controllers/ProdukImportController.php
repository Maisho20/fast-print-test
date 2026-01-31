<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProdukImportController extends Controller
{
    public function import()
    {
        $response = Http::asForm()->post(
            'https://recruitment.fastprint.co.id/tes/api_tes_programmer',
            [
                'username' => 'tesprogrammer300126C15',
                'password' => md5('bisacoding-30-01-26'),
            ]
        );

        if ($response->failed()) {
            return 'Gagal mengambil data API';
        }

        $items = $response->json('data');

        foreach ($items as $item) {

            // 1️⃣ kategori
            $kategori = Kategori::firstOrCreate([
                'nama_kategori' => trim($item['kategori'])
            ]);

            // 2️⃣ status
            $status = Status::firstOrCreate([
                'nama_status' => trim($item['status'])
            ]);

            // 3️⃣ produk
            Produk::updateOrCreate(
                ['id_produk' => (int)$item['id_produk']],
                [
                    'nama_produk' => $item['nama_produk'],
                    'harga' => (int)$item['harga'],
                    'kategori_id' => $kategori->id_kategori,
                    'status_id' => $status->id_status,
                ]
            );
        }

        return 'Import produk berhasil';
    }
}
