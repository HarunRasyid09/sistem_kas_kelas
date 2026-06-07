<?php
include '../middleware/auth_check.php';
include '../config/database.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$filename = "data_transaksi_kas_kelas.csv";

header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=$filename");

// BOM agar karakter UTF-8 terbaca baik di Excel
echo "\xEF\xBB\xBF";

$output = fopen("php://output", "w");

// Header kolom
fputcsv($output, [
    'No',
    'Tanggal',
    'Nama Anggota',
    'NIM',
    'Jenis Transaksi',
    'Keterangan',
    'Nominal',
    'Dicatat Oleh'
], ';');

$query = mysqli_query($conn, "
    SELECT 
        transaksi_kas.*, 
        anggota.nama_anggota,
        anggota.nim,
        users.nama AS nama_user
    FROM transaksi_kas
    INNER JOIN anggota ON transaksi_kas.id_anggota = anggota.id_anggota
    INNER JOIN users ON transaksi_kas.id_user = users.id_user
    ORDER BY transaksi_kas.tanggal DESC, transaksi_kas.id_transaksi DESC
");

$no = 1;
while ($data = mysqli_fetch_assoc($query)) {
    fputcsv($output, [
        $no++,
        $data['tanggal'],
        $data['nama_anggota'],
        $data['nim'],
        ucfirst($data['jenis']),
        $data['keterangan'],
        $data['nominal'],
        $data['nama_user']
    ], ';');
}

fclose($output);
exit;
?>