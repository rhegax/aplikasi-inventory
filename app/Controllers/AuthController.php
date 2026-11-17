<?php

class AuthController
{
    public function login(): void
    {
        $title = 'Login';
        require BASE_PATH . '/app/views/auth/login.php';
    }

    public function attempt(): void
    {
        csrf_check();

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            flash('error', 'Username dan password wajib diisi.');
            redirect('index.php?page=auth');
        }

        if (User::count() === 0) {
            User::create([
                'username' => 'admin',
                'password' => 'admin123',
                'nama' => 'Administrator',
                'role' => 'admin',
            ]);
        }

        $user = User::findByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            flash('error', 'Username atau password salah.');
            redirect('index.php?page=auth');
        }

        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'username' => $user['username'],
            'nama' => $user['nama'],
            'role' => $user['role'],
        ];

        redirect('index.php?page=dashboard');
    }

    public function logout(): void
    {
        session_destroy();
        redirect('index.php?page=auth');
    }
}
