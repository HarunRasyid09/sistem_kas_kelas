<?php
include '../middleware/auth_check.php';
include '../middleware/admin_check.php';
include '../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: transaksi.php?error=" . urlencode("ID transaksi tidak valid."));
    exit;
}

$id_transaksi = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM transaksi_kas WHERE id_transaksi = ?");
$stmt->bind_param("i", $id_transaksi);

if ($stmt->execute()) {
    header("Location: transaksi.php?success=" . urlencode("Data transaksi berhasil dihapus."));
    exit;
} else {
    header("Location: transaksi.php?error=" . urlencode("Data transaksi gagal dihapus."));
    exit;
}
?>