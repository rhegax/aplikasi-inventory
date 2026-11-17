<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Laporan Transaksi</h4>
    <button type="button" class="btn btn-outline-secondary no-print" onclick="window.print()">
        <i class="bi bi-printer me-1"></i>Cetak
    </button>
</div>

<div class="card shadow-sm mb-3 no-print">
    <div class="card-body">
        <form method="get" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="laporan">
            <div class="col-md-4">
                <label class="form-label small">Dari Tanggal</label>
                <input type="date" name="from" class="form-control" value="<?= e($from) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small">Sampai Tanggal</label>
                <input type="date" name="to" class="form-control" value="<?= e($to) ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i>Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white text-center">
        <strong>Periode: <?= e(tanggal_id($from . ' 00:00:00')) ?> s/d <?= e(tanggal_id($to . ' 00:00:00')) ?></strong>
    </div>
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>Jenis</th>
                    <th>Barang</th>
                    <th class="text-end">Jumlah</th>
                    <th>Keterangan</th>
                    <th>Oleh</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$transaksis): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data pada periode ini.</td></tr>
                <?php endif; ?>
                <?php foreach ($transaksis as $i => $t): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td class="text-nowrap"><?= e(tanggal_id($t['created_at'])) ?></td>
                        <td><?= $t['jenis'] === 'masuk' ? 'Masuk' : 'Keluar' ?></td>
                        <td><?= e($t['barang_nama']) ?> <small class="text-muted">(<?= e($t['kode']) ?>)</small></td>
                        <td class="text-end"><?= number_format((int) $t['jumlah'], 0, ',', '.') ?> <?= e($t['satuan']) ?></td>
                        <td><?= e($t['keterangan'] ?: '-') ?></td>
                        <td><?= e($t['user_nama'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Total Masuk</th>
                    <th class="text-end text-info"><?= number_format($totalMasuk, 0, ',', '.') ?></th>
                    <th colspan="2"></th>
                </tr>
                <tr>
                    <th colspan="4" class="text-end">Total Keluar</th>
                    <th class="text-end text-danger"><?= number_format($totalKeluar, 0, ',', '.') ?></th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
