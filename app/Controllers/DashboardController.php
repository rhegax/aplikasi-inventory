<?php

class DashboardController
{
    public function index(): void
    {
        $title = 'Dashboard';
        $totalBarang = Barang::count();
        $totalKategori = Kategori::count();
        $totalNilai = Barang::totalNilai();
        $barangMenipis = Barang::lowStock();
        $transaksiTerakhir = Transaksi::latest(5);
        $masukHariIni = Transaksi::summary('masuk', date('Y-m-d'), date('Y-m-d'));
        $keluarHariIni = Transaksi::summary('keluar', date('Y-m-d'), date('Y-m-d'));

        require BASE_PATH . '/app/views/dashboard/index.php';
    }
}
