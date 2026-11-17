<?php

class TransaksiController
{
    public function index(): void
    {
        $jenis = in_array($_GET['jenis'] ?? '', ['masuk', 'keluar'], true) ? $_GET['jenis'] : '';
        $from = trim($_GET['from'] ?? '');
        $to = trim($_GET['to'] ?? '');

        $title = 'Transaksi Stok';
        $transaksis = Transaksi::filter($jenis, $from, $to);
        $totalMasuk = Transaksi::summary('masuk', $from, $to);
        $totalKeluar = Transaksi::summary('keluar', $from, $to);

        require BASE_PATH . '/app/views/transaksi/index.php';
    }

    public function form(): void
    {
        $jenis = ($_GET['jenis'] ?? 'masuk') === 'keluar' ? 'keluar' : 'masuk';

        $title = $jenis === 'masuk' ? 'Barang Masuk' : 'Barang Keluar';
        $barangs = Barang::options();

        require BASE_PATH . '/app/views/transaksi/form.php';
    }

    public function store(): void
    {
        csrf_check();

        $jenis = ($_POST['jenis'] ?? 'masuk') === 'keluar' ? 'keluar' : 'masuk';
        $barangId = (int) ($_POST['barang_id'] ?? 0);
        $jumlah = (int) ($_POST['jumlah'] ?? 0);
        $keterangan = trim($_POST['keterangan'] ?? '');

        if ($barangId <= 0 || $jumlah <= 0) {
            flash('error', 'Barang dan jumlah wajib diisi dengan benar.');
            redirect('index.php?page=transaksi&action=form&jenis=' . $jenis);
        }

        try {
            Transaksi::create($jenis, $barangId, $jumlah, $keterangan, current_user()['id']);
            flash('success', 'Transaksi berhasil disimpan.');
        } catch (RuntimeException $e) {
            flash('error', $e->getMessage());
        }

        redirect('index.php?page=transaksi');
    }
}
