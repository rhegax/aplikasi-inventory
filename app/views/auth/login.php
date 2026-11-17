<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | <?= e(APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body class="bg-light">
<div class="login-wrapper">
    <div class="card shadow-sm login-card">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <i class="bi bi-box-seam text-primary display-5"></i>
                <h4 class="mt-2 mb-0"><?= e(APP_NAME) ?></h4>
                <p class="text-muted small">Silakan login untuk melanjutkan</p>
            </div>
            <?php if ($error = flash('error')): ?>
                <div class="alert alert-danger py-2"><?= e($error) ?></div>
            <?php endif; ?>
            <?php if ($success = flash('success')): ?>
                <div class="alert alert-success py-2"><?= e($success) ?></div>
            <?php endif; ?>
            <form method="post" action="<?= url('index.php?page=auth&action=attempt') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
