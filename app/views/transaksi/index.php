<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Riwayat Transaksi</h4>
    <div>
        <a href="<?= url('index.php?page=transaksi&action=form&jenis=masuk') ?>" class="btn btn-info">
            <i class="bi bi-arrow-down-circle me-1"></i>Barang Masuk
        </a>
        <a href="<?= url('index.php?page=transaksi&action=form&jenis=keluar') ?>" class="btn btn-warning">
            <i class="bi bi-arrow-up-circle me-1"></i>Barang Keluar
        </a>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="get" class="row g-2 align-items-end">
            <input type="hidden" name="page" value="transaksi">
            <div class="col-md-3">
                <label class="form-label small">Jenis</label>
                <select name="jenis" class="form-select">
                    <option value="">Semua</option>
                    <option value="masuk" <?= $jenis === 'masuk' ? 'selected' : '' ?>>Masuk</option>
                    <option value="keluar" <?= $jenis === 'keluar' ? 'selected' : '' ?>>Keluar</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small">Dari Tanggal</label>
                <input type="date" name="from" class="form-control" value="<?= e($from) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label small">Sampai Tanggal</label>
                <input type="date" name="to" class="form-control" value="<?= e($to) ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
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
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada transaksi.</td></tr>
                <?php endif; ?>
                <?php foreach ($transaksis as $t): ?>
                    <tr>
                        <td class="text-nowrap"><?= e(tanggal_id($t['created_at'])) ?></td>
                        <td>
                            <span class="badge bg-<?= $t['jenis'] === 'masuk' ? 'info' : 'warning' ?>">
                                <?= $t['jenis'] === 'masuk' ? 'Masuk' : 'Keluar' ?>
                            </span>
                        </td>
                        <td><?= e($t['barang_nama']) ?> <small class="text-muted">(<?= e($t['kode']) ?>)</small></td>
                        <td class="text-end fw-bold"><?= number_format((int) $t['jumlah'], 0, ',', '.') ?> <?= e($t['satuan']) ?></td>
                        <td><?= e($t['keterangan'] ?: '-') ?></td>
                        <td><?= e($t['user_nama'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        <small>
            Total masuk: <strong class="text-info"><?= number_format($totalMasuk, 0, ',', '.') ?></strong>
            &nbsp;|&nbsp;
            Total keluar: <strong class="text-danger"><?= number_format($totalKeluar, 0, ',', '.') ?></strong>
        </small>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
