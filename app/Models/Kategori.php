<?php

class Kategori
{
    public static function all(): array
    {
        return db()->query(
            'SELECT k.*, COUNT(b.id) AS jumlah_barang
             FROM kategori k
             LEFT JOIN barang b ON b.kategori_id = k.id
             GROUP BY k.id
             ORDER BY k.nama'
        )->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = db()->prepare('SELECT * FROM kategori WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public static function count(): int
    {
        return (int) db()->query('SELECT COUNT(*) FROM kategori')->fetchColumn();
    }

    public static function create(string $nama): void
    {
        $stmt = db()->prepare('INSERT INTO kategori (nama) VALUES (?)');
        $stmt->execute([$nama]);
    }

    public static function update(int $id, string $nama): void
    {
        $stmt = db()->prepare('UPDATE kategori SET nama = ? WHERE id = ?');
        $stmt->execute([$nama, $id]);
    }

    public static function delete(int $id): void
    {
        $stmt = db()->prepare('DELETE FROM kategori WHERE id = ?');
        $stmt->execute([$id]);
    }
}
