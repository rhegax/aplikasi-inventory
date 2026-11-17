<?php

class User
{
    public static function all(): array
    {
        return db()->query('SELECT * FROM users ORDER BY username')->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = db()->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public static function findByUsername(string $username): ?array
    {
        $stmt = db()->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);

        return $stmt->fetch() ?: null;
    }

    public static function count(): int
    {
        return (int) db()->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

    public static function create(array $data): void
    {
        $stmt = db()->prepare(
            'INSERT INTO users (username, password, nama, role) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['username'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['nama'],
            $data['role'],
        ]);
    }

    public static function update(int $id, array $data): void
    {
        if ($data['password'] !== '') {
            $stmt = db()->prepare(
                'UPDATE users SET username = ?, password = ?, nama = ?, role = ? WHERE id = ?'
            );
            $stmt->execute([
                $data['username'],
                password_hash($data['password'], PASSWORD_DEFAULT),
                $data['nama'],
                $data['role'],
                $id,
            ]);

            return;
        }

        $stmt = db()->prepare(
            'UPDATE users SET username = ?, nama = ?, role = ? WHERE id = ?'
        );
        $stmt->execute([$data['username'], $data['nama'], $data['role'], $id]);
    }

    public static function delete(int $id): void
    {
        $stmt = db()->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
    }
}
