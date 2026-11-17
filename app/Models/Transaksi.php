<?php

class Transaksi
{
    public static function filter(string $jenis = '', string $from = '', string $to = '', int $limit = 200): array
    {
        $sql = 'SELECT t.*, b.kode, b.nama AS barang_nama, b.satuan, u.nama AS user_nama
                FROM transaksi t
                JOIN barang b ON b.id = t.barang_id
                LEFT JOIN users u ON u.id = t.user_id
                WHERE 1 = 1';

        $params = [];

        if ($jenis !== '') {
            $sql .= ' AND t.jenis = ?';
            $params[] = $jenis;
        }

        if ($from !== '') {
            $sql .= ' AND t.created_at >= ?';
            $params[] = $from . ' 00:00:00';
        }

        if ($to !== '') {
            $sql .= ' AND t.created_at <= ?';
            $params[] = $to . ' 23:59:59';
        }

        $sql .= ' ORDER BY t.created_at DESC, t.id DESC LIMIT ' . (int) $limit;

        $stmt = db()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public static function summary(string $jenis, string $from = '', string $to = ''): int
    {
        $sql = 'SELECT COALESCE(SUM(jumlah), 0) FROM transaksi WHERE jenis = ?';
        $params = [$jenis];

        if ($from !== '') {
            $sql .= ' AND created_at >= ?';
            $params[] = $from . ' 00:00:00';
        }

        if ($to !== '') {
            $sql .= ' AND created_at <= ?';
            $params[] = $to . ' 23:59:59';
        }

        $stmt = db()->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn();
    }

    public static function latest(int $limit = 5): array
    {
        $stmt = db()->prepare(
            'SELECT t.*, b.kode, b.nama AS barang_nama, b.satuan
             FROM transaksi t
             JOIN barang b ON b.id = t.barang_id
             ORDER BY t.created_at DESC, t.id DESC
             LIMIT ' . (int) $limit
        );
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function hasForBarang(int $barangId): bool
    {
        $stmt = db()->prepare('SELECT COUNT(*) FROM transaksi WHERE barang_id = ?');
        $stmt->execute([$barangId]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public static function create(string $jenis, int $barangId, int $jumlah, string $keterangan, int $userId): void
    {
        $pdo = db();
        $pdo->beginTransaction();

        try {
            $stmt = $pdo->prepare('SELECT stok FROM barang WHERE id = ? FOR UPDATE');
            $stmt->execute([$barangId]);
            $barang = $stmt->fetch();

            if (!$barang) {
                throw new RuntimeException('Barang tidak ditemukan.');
            }

            if ($jenis === 'keluar' && (int) $barang['stok'] < $jumlah) {
                throw new RuntimeException('Stok tidak cukup. Sisa stok: ' . $barang['stok']);
            }

            $stmt = $pdo->prepare(
                $jenis === 'masuk'
                    ? 'UPDATE barang SET stok = stok + ?, updated_at = NOW() WHERE id = ?'
                    : 'UPDATE barang SET stok = stok - ?, updated_at = NOW() WHERE id = ?'
            );
            $stmt->execute([$jumlah, $barangId]);

            $stmt = $pdo->prepare(
                'INSERT INTO transaksi (jenis, barang_id, jumlah, keterangan, user_id) VALUES (?, ?, ?, ?, ?)'
            );
            $stmt->execute([$jenis, $barangId, $jumlah, $keterangan, $userId]);

            $pdo->commit();
        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
