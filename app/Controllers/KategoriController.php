<?php

class KategoriController
{
    public function index(): void
    {
        $title = 'Kategori Barang';
        $kategoris = Kategori::all();

        require BASE_PATH . '/app/views/kategori/index.php';
    }

    public function store(): void
    {
        csrf_check();
        $nama = trim($_POST['nama'] ?? '');

        if ($nama === '') {
            flash('error', 'Nama kategori wajib diisi.');
            redirect('index.php?page=kategori');
        }

        Kategori::create($nama);
        flash('success', 'Kategori berhasil ditambahkan.');
        redirect('index.php?page=kategori');
    }

    public function update(): void
    {
        csrf_check();
        $id = (int) ($_POST['id'] ?? 0);
        $nama = trim($_POST['nama'] ?? '');

        if ($nama === '') {
            flash('error', 'Nama kategori wajib diisi.');
            redirect('index.php?page=kategori');
        }

        Kategori::update($id, $nama);
        flash('success', 'Kategori berhasil diperbarui.');
        redirect('index.php?page=kategori');
    }

    public function destroy(): void
    {
        csrf_check();
        $id = (int) ($_POST['id'] ?? 0);

        try {
            Kategori::delete($id);
            flash('success', 'Kategori berhasil dihapus.');
        } catch (PDOException $e) {
            flash('error', 'Kategori tidak dapat dihapus karena masih dipakai barang.');
        }

        redirect('index.php?page=kategori');
    }
}
