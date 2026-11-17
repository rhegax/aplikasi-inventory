# Aplikasi Inventory

Aplikasi manajemen stok/inventori sederhana berbasis **PHP Native + MySQL**, dirancang untuk berjalan di **XAMPP**.

## Fitur

- Login & manajemen user (admin/petugas)
- Data barang & kategori (CRUD lengkap)
- Transaksi barang masuk & keluar (stok otomatis ter-update)
- Dashboard ringkasan + peringatan stok menipis
- Laporan transaksi per periode + cetak
- Keamanan dasar: password hashing, prepared statements (PDO), proteksi CSRF, session

## Persyaratan

- XAMPP (PHP 7.4+ atau 8.x, MySQL/MariaDB)

## Cara Instalasi di XAMPP

1. **Salin proyek** ke folder htdocs:

   ```
   C:\xampp\htdocs\aplikasi-inventory
   ```

   atau clone:

   ```bash
   cd C:\xampp\htdocs
   git clone https://github.com/rhegax/aplikasi-inventory.git
   ```

2. **Nyalakan Apache & MySQL** dari XAMPP Control Panel.

3. **Import database**:
   - Buka http://localhost/phpmyadmin
   - Menu **Import** → pilih file `database/schema.sql` → **Go**
   - Database `aplikasi_inventory` beserta tabel dan data awal akan dibuat otomatis.

4. **Sesuaikan konfigurasi** (jika perlu) di `config/config.php`:

   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'aplikasi_inventory');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

   Default XAMPP: user `root` tanpa password.

5. **Buka aplikasi** di browser:

   ```
   http://localhost/aplikasi-inventory/
   ```

## Login Default

| Username | Password   | Role  |
|----------|------------|-------|
| admin    | admin123   | admin |

> ⚠️ Segera ganti password default melalui menu **User** setelah login pertama.

## Struktur Proyek

```
aplikasi-inventory/
├── config/            # Konfigurasi aplikasi & koneksi database
├── app/
│   ├── Controllers/   # Logika per halaman
│   ├── Models/        # Akses database (PDO, prepared statements)
│   └── views/         # Tampilan HTML (Bootstrap 5)
├── database/
│   └── schema.sql     # Skema database + data awal
├── public/            # Satu-satunya folder yang diakses browser
│   ├── index.php      # Front controller / router
│   └── assets/
└── index.php          # Redirect ke public/
```
