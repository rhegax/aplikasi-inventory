<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<h4 class="mb-4"><?= e($title) ?></h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="post"
              action="<?= url('index.php?page=users&action=' . ($user ? 'update' : 'store')) ?>">
            <?= csrf_field() ?>
            <?php if ($user): ?>
                <input type="hidden" name="id" value="<?= (int) $user['id'] ?>">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" required
                           value="<?= e($user['username'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" required
                           value="<?= e($user['nama'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">
                        Password
                        <?php if ($user): ?><small class="text-muted">(kosongkan jika tidak diubah)</small><?php endif; ?>
                    </label>
                    <input type="password" name="password" class="form-control"
                           <?= $user ? '' : 'required' ?>>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="petugas" <?= ($user['role'] ?? '') === 'petugas' ? 'selected' : '' ?>>Petugas</option>
                        <option value="admin" <?= ($user['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= url('index.php?page=users') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
