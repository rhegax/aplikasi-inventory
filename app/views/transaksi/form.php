<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<h4 class="mb-4"><?= e($title) ?></h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="post" action="<?= url('index.php?page=transaksi&action=store') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="jenis" value="<?= e($jenis) ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Barang <span class="text-danger">*</span></label>
                    <select name="barang_id" class="form-select" required>
                        <option value="">- Pilih Barang -</option>
                        <?php foreach ($barangs as $b): ?>
                            <option value="<?= (int) $b['id'] ?>">
                                <?= e($b['kode'] . ' - ' . $b['nama']) ?>
                                (stok: <?= number_format((int) $b['stok'], 0, ',', '.') ?> <?= e($b['satuan']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah" class="form-control" min="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal</label>
                    <input type="text" class="form-control" value="<?= e(date('d-m-Y H:i')) ?>" disabled>
                </div>
                <div class="col-12">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2"
                              placeholder="<?= $jenis === 'masuk' ? 'Contoh: pembelian dari supplier' : 'Contoh: permintaan gudang' ?>"></textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-<?= $jenis === 'masuk' ? 'info' : 'warning' ?>">
                    Simpan Transaksi <?= $jenis === 'masuk' ? 'Masuk' : 'Keluar' ?>
                </button>
                <a href="<?= url('index.php?page=transaksi') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
