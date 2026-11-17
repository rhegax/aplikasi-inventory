<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Manajemen User</h4>
    <a href="<?= url('index.php?page=users&action=create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah User
    </a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= e($u['username']) ?></td>
                        <td><?= e($u['nama']) ?></td>
                        <td>
                            <span class="badge bg-<?= $u['role'] === 'admin' ? 'danger' : 'secondary' ?>">
                                <?= e($u['role']) ?>
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="<?= url('index.php?page=users&action=edit&id=' . (int) $u['id']) ?>"
                               class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <?php if ((int) $u['id'] !== (int) $user['id']): ?>
                                <form method="post" class="d-inline"
                                      action="<?= url('index.php?page=users&action=destroy') ?>"
                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
