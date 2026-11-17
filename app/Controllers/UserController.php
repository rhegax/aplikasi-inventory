<?php

class UserController
{
    public function __construct()
    {
        require_admin();
    }

    public function index(): void
    {
        $title = 'Manajemen User';
        $users = User::all();

        require BASE_PATH . '/app/views/users/index.php';
    }

    public function create(): void
    {
        $title = 'Tambah User';
        $user = null;

        require BASE_PATH . '/app/views/users/form.php';
    }

    public function store(): void
    {
        csrf_check();
        $data = $this->input();

        if ($data['username'] === '' || $data['nama'] === '' || $data['password'] === '') {
            flash('error', 'Semua field wajib diisi.');
            redirect('index.php?page=users&action=create');
        }

        if (User::findByUsername($data['username'])) {
            flash('error', 'Username sudah digunakan.');
            redirect('index.php?page=users&action=create');
        }

        User::create($data);
        flash('success', 'User berhasil ditambahkan.');
        redirect('index.php?page=users');
    }

    public function edit(): void
    {
        $user = User::find((int) ($_GET['id'] ?? 0));

        if (!$user) {
            flash('error', 'User tidak ditemukan.');
            redirect('index.php?page=users');
        }

        $title = 'Edit User';

        require BASE_PATH . '/app/views/users/form.php';
    }

    public function update(): void
    {
        csrf_check();
        $id = (int) ($_POST['id'] ?? 0);
        $user = User::find($id);

        if (!$user) {
            flash('error', 'User tidak ditemukan.');
            redirect('index.php?page=users');
        }

        $data = $this->input();

        if ($data['username'] === '' || $data['nama'] === '') {
            flash('error', 'Username dan nama wajib diisi.');
            redirect('index.php?page=users&action=edit&id=' . $id);
        }

        $existing = User::findByUsername($data['username']);
        if ($existing && (int) $existing['id'] !== $id) {
            flash('error', 'Username sudah digunakan.');
            redirect('index.php?page=users&action=edit&id=' . $id);
        }

        User::update($id, $data);

        if ($id === current_user()['id']) {
            $_SESSION['user']['nama'] = $data['nama'];
            $_SESSION['user']['role'] = $data['role'];
        }

        flash('success', 'User berhasil diperbarui.');
        redirect('index.php?page=users');
    }

    public function destroy(): void
    {
        csrf_check();
        $id = (int) ($_POST['id'] ?? 0);

        if ($id === current_user()['id']) {
            flash('error', 'Anda tidak dapat menghapus akun sendiri.');
            redirect('index.php?page=users');
        }

        User::delete($id);
        flash('success', 'User berhasil dihapus.');
        redirect('index.php?page=users');
    }

    private function input(): array
    {
        return [
            'username' => trim($_POST['username'] ?? ''),
            'nama' => trim($_POST['nama'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'role' => ($_POST['role'] ?? 'petugas') === 'admin' ? 'admin' : 'petugas',
        ];
    }
}
