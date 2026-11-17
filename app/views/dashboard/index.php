<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Dashboard</h4>
    <span class="text-muted">Halo, <?= e($user['nama']) ?></span>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">Total Barang</h6>
                        <h3 class="mb-0"><?= number_format($totalBarang, 0, ',', '.') ?></h3>
                    </div>
                    <i class="bi bi-boxes fs-1 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">Kategori</h6>
                        <h3 class="mb-0"><?= number_format($totalKategori, 0, ',', '.') ?></h3>
                    </div>
                    <i class="bi bi-tags fs-1 text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">Masuk Hari Ini</h6>
                        <h3 class="mb-0"><?= number_format($masukHariIni, 0, ',', '.') ?></h3>
                    </div>
                    <i class="bi bi-arrow-down-circle fs-1 text-info"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">Keluar Hari Ini</h6>
                        <h3 class="mb-0"><?= number_format($keluarHariIni, 0, ',', '.') ?></h3>
                    </div>
                    <i class="bi bi-arrow-up-circle fs-1 text-danger"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <strong>Transaksi Terakhir</strong>
                <a href="<?= url('index.php?page=transaksi') ?>">Lihat semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Barang</th>
                            <th>Jenis</th>
                            <th class="text-end">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$transaksiTerakhir): ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">Belum ada transaksi.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($transaksiTerakhir as $t): ?>
                            <tr>
                                <td class="text-nowrap"><?= e(tanggal_id($t['created_at'])) ?></td>
                                <td><?= e($t['barang_nama']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $t['jenis'] === 'masuk' ? 'info' : 'warning' ?>">
                                        <?= $t['jenis'] === 'masuk' ? 'Masuk' : 'Keluar' ?>
                                    </span>
                                </td>
                                <td class="text-end"><?= number_format((int) $t['jumlah'], 0, ',', '.') ?> <?= e($t['satuan']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white"><strong>Total Nilai Stok</strong></div>
            <div class="card-body">
                <h3 class="text-primary mb-0"><?= e(rupiah($totalNilai)) ?></h3>
                <small class="text-muted">Berdasarkan harga beli</small>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>Stok Menipis</strong></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th class="text-end">Stok</th>
                            <th class="text-end">Min.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$barangMenipis): ?>
                            <tr><td colspan="3" class="text-center text-muted py-4">Semua stok aman.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($barangMenipis as $b): ?>
                            <tr>
                                <td><?= e($b['nama']) ?></td>
                                <td class="text-end <?= $b['stok'] <= 0 ? 'text-danger fw-bold' : 'text-warning fw-bold' ?>">
                                    <?= number_format((int) $b['stok'], 0, ',', '.') ?>
                                </td>
                                <td class="text-end text-muted"><?= number_format((int) $b['stok_minimum'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
