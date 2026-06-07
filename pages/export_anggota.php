<?php
include '../middleware/auth_check.php';
include '../config/database.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$filename = "data_anggota_kas_kelas.csv";

header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=$filename");

// BOM agar karakter UTF-8 terbaca baik di Excel
echo "\xEF\xBB\xBF";

$output = fopen("php://output", "w");

// Header kolom
fputcsv($output, ['No', 'Nama Anggota', 'NIM', 'Kelas', 'No HP'], ';');

$query = mysqli_query($conn, "SELECT * FROM anggota ORDER BY nama_anggota ASC");

$no = 1;
while ($data = mysqli_fetch_assoc($query)) {
    fputcsv($output, [
        $no++,
        $data['nama_anggota'],
        $data['nim'],
        $data['kelas'],
        $data['no_hp']
    ], ';');
}

fclose($output);
exit;
?>