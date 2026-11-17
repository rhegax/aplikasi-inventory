<?php

class Barang
{
    public static function search(string $keyword = '', int $limit = 10, int $offset = 0): array
    {
        $sql = 'SELECT b.*, k.nama AS kategori_nama
                FROM barang b
                LEFT JOIN kategori k ON k.id = b.kategori_id';

        $params = [];
        if ($keyword !== '') {
            $sql .= ' WHERE b.nama LIKE ? OR b.kode LIKE ?';
            $params[] = '%' . $keyword . '%';
            $params[] = '%' . $keyword . '%';
        }

        $sql .= ' ORDER BY b.nama LIMIT ' . (int) $limit . ' OFFSET ' . (int) $offset;

        $stmt = db()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public static function countSearch(string $keyword = ''): int
    {
        $sql = 'SELECT COUNT(*) FROM barang';
        $params = [];

        if ($keyword !== '') {
            $sql .= ' WHERE nama LIKE ? OR kode LIKE ?';
            $params[] = '%' . $keyword . '%';
            $params[] = '%' . $keyword . '%';
        }

        $stmt = db()->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn();
    }

    public static function find(int $id): ?array
    {
        $stmt = db()->prepare(
            'SELECT b.*, k.nama AS kategori_nama
             FROM barang b
             LEFT JOIN kategori k ON k.id = b.kategori_id
             WHERE b.id = ?'
        );
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public static function findByKode(string $kode): ?array
    {
        $stmt = db()->prepare('SELECT * FROM barang WHERE kode = ?');
        $stmt->execute([$kode]);

        return $stmt->fetch() ?: null;
    }

    public static function options(): array
    {
        return db()->query(
            'SELECT id, kode, nama, satuan, stok FROM barang ORDER BY nama'
        )->fetchAll();
    }

    public static function lowStock(): array
    {
        return db()->query(
            'SELECT b.*, k.nama AS kategori_nama
             FROM barang b
             LEFT JOIN kategori k ON k.id = b.kategori_id
             WHERE b.stok <= b.stok_minimum
             ORDER BY b.stok
             LIMIT 10'
        )->fetchAll();
    }

    public static function count(): int
    {
        return (int) db()->query('SELECT COUNT(*) FROM barang')->fetchColumn();
    }

    public static function totalNilai(): float
    {
        return (float) db()->query(
            'SELECT COALESCE(SUM(stok * harga_beli), 0) FROM barang'
        )->fetchColumn();
    }

    public static function create(array $data): void
    {
        $stmt = db()->prepare(
            'INSERT INTO barang (kode, nama, kategori_id, satuan, stok, stok_minimum, harga_beli, harga_jual)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['kode'],
            $data['nama'],
            $data['kategori_id'] ?: null,
            $data['satuan'],
            $data['stok'],
            $data['stok_minimum'],
            $data['harga_beli'],
            $data['harga_jual'],
        ]);
    }

    public static function update(int $id, array $data): void
    {
        $stmt = db()->prepare(
            'UPDATE barang
             SET kode = ?, nama = ?, kategori_id = ?, satuan = ?, stok_minimum = ?, harga_beli = ?, harga_jual = ?
             WHERE id = ?'
        );
        $stmt->execute([
            $data['kode'],
            $data['nama'],
            $data['kategori_id'] ?: null,
            $data['satuan'],
            $data['stok_minimum'],
            $data['harga_beli'],
            $data['harga_jual'],
            $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $stmt = db()->prepare('DELETE FROM barang WHERE id = ?');
        $stmt->execute([$id]);
    }
}
