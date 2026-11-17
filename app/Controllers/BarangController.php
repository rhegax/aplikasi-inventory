<?php

class BarangController
{
    public function index(): void
    {
        $keyword = trim($_GET['q'] ?? '');
        $page = max(1, (int) ($_GET['p'] ?? 1));
        $perPage = 10;

        $title = 'Data Barang';
        $barangs = Barang::search($keyword, $perPage, ($page - 1) * $perPage);
        $total = Barang::countSearch($keyword);
        $totalPage = max(1, (int) ceil($total / $perPage));

        require BASE_PATH . '/app/views/barang/index.php';
    }

    public function create(): void
    {
        $title = 'Tambah Barang';
        $kategoris = Kategori::all();
        $barang = null;

        require BASE_PATH . '/app/views/barang/form.php';
    }

    public function store(): void
    {
        csrf_check();
        $data = $this->input();

        if ($data['nama'] === '') {
            flash('error', 'Nama barang wajib diisi.');
            redirect('index.php?page=barang&action=create');
        }

        if ($data['kode'] !== '' && Barang::findByKode($data['kode'])) {
            flash('error', 'Kode barang sudah digunakan.');
            redirect('index.php?page=barang&action=create');
        }

        if ($data['kode'] === '') {
            $data['kode'] = 'BRG-' . str_pad((string) (Barang::count() + 1), 4, '0', STR_PAD_LEFT);
        }

        Barang::create($data);
        flash('success', 'Barang berhasil ditambahkan.');
        redirect('index.php?page=barang');
    }

    public function edit(): void
    {
        $barang = Barang::find((int) ($_GET['id'] ?? 0));

        if (!$barang) {
            flash('error', 'Barang tidak ditemukan.');
            redirect('index.php?page=barang');
        }

        $title = 'Edit Barang';
        $kategoris = Kategori::all();

        require BASE_PATH . '/app/views/barang/form.php';
    }

    public function update(): void
    {
        csrf_check();
        $id = (int) ($_POST['id'] ?? 0);
        $barang = Barang::find($id);

        if (!$barang) {
            flash('error', 'Barang tidak ditemukan.');
            redirect('index.php?page=barang');
        }

        $data = $this->input();

        if ($data['nama'] === '') {
            flash('error', 'Nama barang wajib diisi.');
            redirect('index.php?page=barang&action=edit&id=' . $id);
        }

        if ($data['kode'] !== '' && ($existing = Barang::findByKode($data['kode'])) && (int) $existing['id'] !== $id) {
            flash('error', 'Kode barang sudah digunakan.');
            redirect('index.php?page=barang&action=edit&id=' . $id);
        }

        Barang::update($id, $data);
        flash('success', 'Barang berhasil diperbarui.');
        redirect('index.php?page=barang');
    }

    public function destroy(): void
    {
        csrf_check();

        $id = (int) ($_POST['id'] ?? 0);
        $barang = Barang::find($id);

        if (!$barang) {
            flash('error', 'Barang tidak ditemukan.');
            redirect('index.php?page=barang');
        }

        try {
            if (Transaksi::hasForBarang($id)) {
                flash('error', 'Barang tidak dapat dihapus karena memiliki riwayat transaksi.');
                redirect('index.php?page=barang');
            }

            Barang::delete($id);
            flash('success', 'Barang berhasil dihapus.');
        } catch (PDOException $e) {
            flash('error', 'Barang tidak dapat dihapus.');
        }

        redirect('index.php?page=barang');
    }

    private function input(): array
    {
        return [
            'kode' => trim($_POST['kode'] ?? ''),
            'nama' => trim($_POST['nama'] ?? ''),
            'kategori_id' => (int) ($_POST['kategori_id'] ?? 0),
            'satuan' => trim($_POST['satuan'] ?? '') ?: 'pcs',
            'stok' => max(0, (int) ($_POST['stok'] ?? 0)),
            'stok_minimum' => max(0, (int) ($_POST['stok_minimum'] ?? 0)),
            'harga_beli' => max(0, (float) ($_POST['harga_beli'] ?? 0)),
            'harga_jual' => max(0, (float) ($_POST['harga_jual'] ?? 0)),
        ];
    }
}
