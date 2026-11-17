<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<h4 class="mb-4"><?= e($title) ?></h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="post"
              action="<?= url('index.php?page=barang&action=' . ($barang ? 'update' : 'store')) ?>">
            <?= csrf_field() ?>
            <?php if ($barang): ?>
                <input type="hidden" name="id" value="<?= (int) $barang['id'] ?>">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="kode" class="form-control"
                           value="<?= e($barang['kode'] ?? '') ?>" placeholder="Kosongkan untuk otomatis">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" required
                           value="<?= e($barang['nama'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-select">
                        <option value="">- Tidak ada -</option>
                        <?php foreach ($kategoris as $k): ?>
                            <option value="<?= (int) $k['id'] ?>"
                                <?= (isset($barang['kategori_id']) && (int) $barang['kategori_id'] === (int) $k['id']) ? 'selected' : '' ?>>
                                <?= e($k['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" placeholder="pcs, box, kg..."
                           value="<?= e($barang['satuan'] ?? 'pcs') ?>">
                </div>
                <?php if (!$barang): ?>
                <div class="col-md-6">
                    <label class="form-label">Stok Awal</label>
                    <input type="number" name="stok" class="form-control" min="0" value="0">
                </div>
                <?php endif; ?>
                <div class="col-md-6">
                    <label class="form-label">Stok Minimum</label>
                    <input type="number" name="stok_minimum" class="form-control" min="0"
                           value="<?= e($barang['stok_minimum'] ?? 0) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control" min="0" step="0.01"
                           value="<?= e($barang['harga_beli'] ?? 0) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" min="0" step="0.01"
                           value="<?= e($barang['harga_jual'] ?? 0) ?>">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= url('index.php?page=barang') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
