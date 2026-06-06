<?php
include '../middleware/auth_check.php';
include '../middleware/admin_check.php';
include '../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: anggota.php?error=" . urlencode("ID anggota tidak valid."));
    exit;
}

$id_anggota = $_GET['id'];

$cek = $conn->prepare("SELECT COUNT(*) AS total FROM transaksi_kas WHERE id_anggota = ?");
$cek->bind_param("i", $id_anggota);
$cek->execute();
$hasil = $cek->get_result();
$data = $hasil->fetch_assoc();

if ($data['total'] > 0) {
    header("Location: anggota.php?error=" . urlencode("Anggota tidak dapat dihapus karena sudah memiliki data transaksi kas."));
    exit;
}

$stmt = $conn->prepare("DELETE FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id_anggota);

if ($stmt->execute()) {
    header("Location: anggota.php?success=" . urlencode("Data anggota berhasil dihapus."));
    exit;
} else {
    header("Location: anggota.php?error=" . urlencode("Data anggota gagal dihapus."));
    exit;
}
?>