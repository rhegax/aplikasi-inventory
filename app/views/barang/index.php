<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Data Barang</h4>
    <a href="<?= url('index.php?page=barang&action=create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Barang
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <form method="get" class="row g-2">
            <input type="hidden" name="page" value="barang">
            <div class="col-auto flex-grow-1">
                <input type="text" name="q" class="form-control" placeholder="Cari nama atau kode barang..."
                       value="<?= e($keyword) ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th class="text-end">Stok</th>
                    <th class="text-end">Harga Beli</th>
                    <th class="text-end">Harga Jual</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$barangs): ?>
                    <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada data barang.</td></tr>
                <?php endif; ?>
                <?php foreach ($barangs as $b): ?>
                    <tr class="<?= $b['stok'] <= $b['stok_minimum'] ? 'table-warning' : '' ?>">
                        <td><?= e($b['kode']) ?></td>
                        <td><?= e($b['nama']) ?></td>
                        <td><?= e($b['kategori_nama'] ?? '-') ?></td>
                        <td><?= e($b['satuan']) ?></td>
                        <td class="text-end fw-bold <?= $b['stok'] <= $b['stok_minimum'] ? 'text-danger' : '' ?>">
                            <?= number_format((int) $b['stok'], 0, ',', '.') ?>
                        </td>
                        <td class="text-end"><?= e(rupiah($b['harga_beli'])) ?></td>
                        <td class="text-end"><?= e(rupiah($b['harga_jual'])) ?></td>
                        <td class="text-end">
                            <a href="<?= url('index.php?page=barang&action=edit&id=' . (int) $b['id']) ?>"
                               class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="post" class="d-inline"
                                  action="<?= url('index.php?page=barang&action=destroy') ?>"
                                  onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= (int) $b['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
        <small class="text-muted">Total: <?= number_format($total, 0, ',', '.') ?> barang</small>
        <?php if ($totalPage > 1): ?>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                            <a class="page-link"
                               href="<?= url('index.php?page=barang&q=' . urlencode($keyword) . '&p=' . $i) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
