<?php

declare(strict_types=1);

session_start();

define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/'));

require BASE_PATH . '/config/config.php';
require BASE_PATH . '/app/helpers.php';

spl_autoload_register(function (string $class): void {
    foreach (['Models', 'Controllers'] as $dir) {
        $file = BASE_PATH . '/app/' . $dir . '/' . $class . '.php';
        if (is_file($file)) {
            require $file;
            return;
        }
    }
});

$defaultActions = ['auth' => 'login'];
$page = (string) ($_GET['page'] ?? 'dashboard');
$action = (string) ($_GET['action'] ?? ($defaultActions[$page] ?? 'index'));

$routes = [
    'auth' => [AuthController::class, ['login', 'attempt', 'logout']],
    'dashboard' => [DashboardController::class, ['index']],
    'barang' => [BarangController::class, ['index', 'create', 'store', 'edit', 'update', 'destroy']],
    'kategori' => [KategoriController::class, ['index', 'store', 'update', 'destroy']],
    'transaksi' => [TransaksiController::class, ['index', 'form', 'store']],
    'laporan' => [LaporanController::class, ['index']],
    'users' => [UserController::class, ['index', 'create', 'store', 'edit', 'update', 'destroy']],
];

if (!isset($routes[$page]) || !in_array($action, $routes[$page][1], true)) {
    http_response_code(404);
    exit('Halaman tidak ditemukan.');
}

if ($page !== 'auth') {
    require_login();
}

$controller = $routes[$page][0];
(new $controller)->{$action}();
