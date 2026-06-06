<?php
include '../middleware/auth_check.php';
include '../middleware/admin_check.php';
include '../config/database.php';

$error = "";

$query_anggota = mysqli_query($conn, "SELECT * FROM anggota ORDER BY nama_anggota ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_anggota = trim($_POST['id_anggota']);
    $id_user = $_SESSION['id_user'];
    $tanggal = trim($_POST['tanggal']);
    $jenis = trim($_POST['jenis']);
    $keterangan = trim($_POST['keterangan']);
    $nominal = trim($_POST['nominal']);

    if (empty($id_anggota) || empty($tanggal) || empty($jenis) || empty($keterangan) || empty($nominal)) {
        $error = "Semua input wajib diisi.";
    } elseif (!in_array($jenis, ['pemasukan', 'pengeluaran'])) {
        $error = "Jenis transaksi tidak valid.";
    } elseif (!is_numeric($nominal) || $nominal <= 0) {
        $error = "Nominal harus berupa angka dan lebih dari 0.";
    } else {
        $nominal = (int) $nominal;

        $stmt = $conn->prepare("
            INSERT INTO transaksi_kas 
            (id_anggota, id_user, tanggal, jenis, keterangan, nominal) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("iisssi", $id_anggota, $id_user, $tanggal, $jenis, $keterangan, $nominal);

        if ($stmt->execute()) {
            header("Location: transaksi.php?success=" . urlencode("Data transaksi berhasil ditambahkan."));
            exit;
        } else {
            $error = "Data transaksi gagal ditambahkan.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Transaksi - Sistem Kas Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Sistem Kas Kelas</a>

        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
            <a class="nav-link" href="anggota.php">Data Anggota</a>
            <a class="nav-link active" href="transaksi.php">Data Transaksi</a>
            <a class="nav-link" href="../auth/logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <h3 class="mb-3">Tambah Transaksi Kas</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <?php if (!empty($error)) { ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php } ?>

            <?php if (mysqli_num_rows($query_anggota) == 0) { ?>
                <div class="alert alert-warning">
                    Belum ada data anggota. Silakan tambahkan data anggota terlebih dahulu.
                </div>
            <?php } ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Anggota</label>
                    <select name="id_anggota" class="form-control">
                        <option value="">-- Pilih Anggota --</option>

                        <?php while ($anggota = mysqli_fetch_assoc($query_anggota)) { ?>
                            <option value="<?php echo $anggota['id_anggota']; ?>">
                                <?php echo htmlspecialchars($anggota['nama_anggota']); ?> - <?php echo htmlspecialchars($anggota['nim']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Transaksi</label>
                    <select name="jenis" class="form-control">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="pemasukan">Pemasukan</option>
                        <option value="pengeluaran">Pengeluaran</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Iuran kas mingguan">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nominal</label>
                    <input type="number" name="nominal" class="form-control" placeholder="Contoh: 10000">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="transaksi.php" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>

</body>
</html>