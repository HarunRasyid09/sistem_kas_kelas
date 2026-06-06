# Sistem Kas Kelas

Sistem Kas Kelas adalah aplikasi web dinamis berbasis PHP native yang digunakan untuk mengelola data kas kelas, meliputi data anggota, transaksi pemasukan, transaksi pengeluaran, serta perhitungan saldo kas.

Project ini dibuat sebagai Final Project mata kuliah Pemrograman Web.

## Teknologi yang Digunakan

* PHP Native
* MySQL/MariaDB
* HTML
* CSS
* Bootstrap
* XAMPP
* phpMyAdmin

## Fitur Aplikasi

* Login dan logout menggunakan session
* Role pengguna admin dan user
* Dashboard ringkasan kas
* CRUD data anggota
* CRUD data transaksi kas
* Data pemasukan dan pengeluaran
* Perhitungan saldo kas otomatis
* Validasi input tidak boleh kosong
* Password terenkripsi menggunakan `password_hash()`
* Login menggunakan `password_verify()`
* Query menggunakan prepared statement
* Pembatasan akses halaman berdasarkan role
* Tampilan web menggunakan Bootstrap dan CSS custom

## Role Pengguna

### Admin

Admin memiliki akses untuk:

* Melihat dashboard
* Mengelola data anggota
* Menambah data anggota
* Mengedit data anggota
* Menghapus data anggota
* Mengelola transaksi kas
* Menambah transaksi
* Mengedit transaksi
* Menghapus transaksi
* Logout

### User

User memiliki akses untuk:

* Melihat dashboard
* Melihat data anggota
* Melihat data transaksi kas
* Logout

User tidak dapat menambah, mengedit, atau menghapus data.

## Struktur Database

Database yang digunakan bernama:

```text
sistem_kas_kelas
```

Terdapat 3 tabel utama:

1. `users`
2. `anggota`
3. `transaksi_kas`

### Tabel `users`

Digunakan untuk menyimpan data akun pengguna aplikasi.

Field utama:

* `id_user`
* `nama`
* `username`
* `password`
* `role`

### Tabel `anggota`

Digunakan untuk menyimpan data anggota kelas.

Field utama:

* `id_anggota`
* `nama_anggota`
* `nim`
* `kelas`
* `no_hp`

### Tabel `transaksi_kas`

Digunakan untuk menyimpan data transaksi pemasukan dan pengeluaran kas.

Field utama:

* `id_transaksi`
* `id_anggota`
* `id_user`
* `tanggal`
* `jenis`
* `keterangan`
* `nominal`
* `created_at`

## Relasi Database

Relasi tabel pada aplikasi ini adalah:

* Tabel `users` berelasi dengan tabel `transaksi_kas` melalui `id_user`
* Tabel `anggota` berelasi dengan tabel `transaksi_kas` melalui `id_anggota`

Artinya, setiap transaksi kas memiliki data anggota dan user/admin yang mencatat transaksi tersebut.

## Akun Login

### Admin

Username:

```text
admin
```

Password:

```text
admin123
```

### User

Username:

```text
user
```

Password:

```text
user123
```

## Cara Menjalankan Project

1. Download atau clone repository ini.
2. Pindahkan folder project ke dalam folder `htdocs`.

Contoh lokasi:

```text
C:\xampp\htdocs\sistem_kas_kelas
```

3. Jalankan XAMPP.
4. Start Apache dan MySQL.
5. Buka phpMyAdmin melalui browser:

```text
http://localhost/phpmyadmin
```

6. Buat database baru dengan nama:

```text
sistem_kas_kelas
```

7. Import file database:

```text
database/sistem_kas_kelas.sql
```

8. Jalankan aplikasi melalui browser:

```text
http://localhost/sistem_kas_kelas
```

9. Login menggunakan akun admin atau user.

## Struktur Folder Project

```text
sistem_kas_kelas/
│
├── assets/
│   └── css/
│       └── style.css
│
├── auth/
│   ├── login.php
│   ├── logout.php
│   └── proses_login.php
│
├── config/
│   └── database.php
│
├── database/
│   └── sistem_kas_kelas.sql
│
├── middleware/
│   ├── admin_check.php
│   └── auth_check.php
│
├── pages/
│   ├── anggota.php
│   ├── dashboard.php
│   ├── edit_anggota.php
│   ├── edit_transaksi.php
│   ├── hapus_anggota.php
│   ├── hapus_transaksi.php
│   ├── tambah_anggota.php
│   ├── tambah_transaksi.php
│   └── transaksi.php
│
├── index.php
└── README.md
```

## Keamanan Dasar

Aplikasi ini menerapkan beberapa keamanan dasar, yaitu:

* Password tidak disimpan dalam bentuk teks biasa
* Password disimpan menggunakan `password_hash()`
* Proses login menggunakan `password_verify()`
* Halaman dilindungi menggunakan session
* Halaman admin dibatasi berdasarkan role
* Query penting menggunakan prepared statement
* Input divalidasi agar tidak boleh kosong

## Pembuat

Project ini dibuat oleh Kelompok 9 untuk Final Project Pemrograman Web.

Anggota kelompok:

1. Muhammad Harun Al-Rasyid - 24081010164
2. Mohammad Fachry Abdullah Putra - 24081010159

## Nama Project

Sistem Kas Kelas