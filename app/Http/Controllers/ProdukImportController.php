<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProdukImportController extends Controller
{
    public function import()
    {
        DB::beginTransaction();

        try {
            $response = Http::asForm()->post(
                'https://recruitment.fastprint.co.id/tes/api_tes_programmer',
                [
                    'username' => 'tesprogrammer030226C08',
                    'password' => md5('bisacoding-03-02-26'),
                ]
            );

            if ($response->failed()) {
                return redirect()->back()->with('error', 'Gagal mengambil data dari API.');
            }

            $items = $response->json('data');

            if (empty($items)) {
                return redirect()->back()->with('error', 'Data dari API kosong.');
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            DB::table('produk')->delete();
            DB::table('kategori')->delete();
            DB::table('status')->delete();

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');


            $kategoriMap = [];
            $statusMap = [];

            foreach ($items as $item) {
                $kategoriNama = trim($item['kategori']);
                $statusNama = trim($item['status']);

                if (!isset($kategoriMap[$kategoriNama])) {
                    $kategori = Kategori::create(['nama_kategori' => $kategoriNama]);
                    $kategoriMap[$kategoriNama] = $kategori->id_kategori;
                }

                if (!isset($statusMap[$statusNama])) {
                    $status = Status::create(['nama_status' => $statusNama]);
                    $statusMap[$statusNama] = $status->id_status;
                }
            }

            $produkData = [];
            foreach ($items as $item) {
                $produkData[] = [
                    'id_produk' => (int)$item['id_produk'],
                    'nama_produk' => $item['nama_produk'],
                    'harga' => (int)$item['harga'],
                    'kategori_id' => $kategoriMap[trim($item['kategori'])],
                    'status_id' => $statusMap[trim($item['status'])],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Produk::insert($produkData);

            DB::commit();

            return redirect()->back()->with('success', 'Data produk berhasil diimpor dari API.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
