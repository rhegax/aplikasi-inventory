<?php

class LaporanController
{
    public function index(): void
    {
        $from = trim($_GET['from'] ?? '') ?: date('Y-m-01');
        $to = trim($_GET['to'] ?? '') ?: date('Y-m-d');

        $title = 'Laporan Transaksi';
        $transaksis = Transaksi::filter('', $from, $to);
        $totalMasuk = Transaksi::summary('masuk', $from, $to);
        $totalKeluar = Transaksi::summary('keluar', $from, $to);

        require BASE_PATH . '/app/views/laporan/index.php';
    }
}
