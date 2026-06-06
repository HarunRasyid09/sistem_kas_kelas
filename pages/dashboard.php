<?php
include '../middleware/auth_check.php';
include '../config/database.php';

$query_pemasukan = mysqli_query($conn, "SELECT SUM(nominal) AS total FROM transaksi_kas WHERE jenis = 'pemasukan'");
$data_pemasukan = mysqli_fetch_assoc($query_pemasukan);
$total_pemasukan = $data_pemasukan['total'] ?? 0;

$query_pengeluaran = mysqli_query($conn, "SELECT SUM(nominal) AS total FROM transaksi_kas WHERE jenis = 'pengeluaran'");
$data_pengeluaran = mysqli_fetch_assoc($query_pengeluaran);
$total_pengeluaran = $data_pengeluaran['total'] ?? 0;

$saldo = $total_pemasukan - $total_pengeluaran;

$query_anggota = mysqli_query($conn, "SELECT COUNT(*) AS total FROM anggota");
$data_anggota = mysqli_fetch_assoc($query_anggota);
$total_anggota = $data_anggota['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Sistem Kas Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Sistem Kas Kelas</a>

        <div class="navbar-nav ms-auto">
            <a class="nav-link active" href="dashboard.php">Dashboard</a>
            <a class="nav-link" href="anggota.php">Data Anggota</a>
            <a class="nav-link" href="transaksi.php">Data Transaksi</a>
            <a class="nav-link" href="../auth/logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <div class="alert alert-info">
        Selamat datang, <strong><?php echo htmlspecialchars($_SESSION['nama']); ?></strong>
        sebagai <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong>.
    </div>

    <h3 class="mb-4">Dashboard</h3>

    <div class="row">

        <div class="col-md-3">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Pemasukan</h5>
                    <h4>Rp <?php echo number_format($total_pemasukan, 0, ',', '.'); ?></h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Pengeluaran</h5>
                    <h4>Rp <?php echo number_format($total_pengeluaran, 0, ',', '.'); ?></h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Saldo Kas</h5>
                    <h4>Rp <?php echo number_format($saldo, 0, ',', '.'); ?></h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Anggota</h5>
                    <h4><?php echo $total_anggota; ?> Orang</h4>
                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>