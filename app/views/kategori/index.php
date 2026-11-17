<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<h4 class="mb-4">Kategori Barang</h4>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><strong>Tambah Kategori</strong></div>
            <div class="card-body">
                <form method="post" action="<?= url('index.php?page=kategori&action=store') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <input type="text" name="nama" class="form-control" placeholder="Nama kategori" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Tambah</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nama Kategori</th>
                            <th class="text-end">Jumlah Barang</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$kategoris): ?>
                            <tr><td colspan="3" class="text-center text-muted py-4">Belum ada kategori.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($kategoris as $k): ?>
                            <tr>
                                <td><?= e($k['nama']) ?></td>
                                <td class="text-end"><?= number_format((int) $k['jumlah_barang'], 0, ',', '.') ?></td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#editKategori<?= (int) $k['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form method="post" class="d-inline"
                                          action="<?= url('index.php?page=kategori&action=destroy') ?>"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= (int) $k['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php foreach ($kategoris as $k): ?>
<div class="modal fade" id="editKategori<?= (int) $k['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= url('index.php?page=kategori&action=update') ?>">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= (int) $k['id'] ?>">
                    <input type="text" name="nama" class="form-control" value="<?= e($k['nama']) ?>" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
