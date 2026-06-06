<?php
include '../middleware/auth_check.php';
include '../middleware/admin_check.php';
include '../config/database.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_anggota = trim($_POST['nama_anggota']);
    $nim = trim($_POST['nim']);
    $kelas = trim($_POST['kelas']);
    $no_hp = trim($_POST['no_hp']);

    if (empty($nama_anggota) || empty($nim) || empty($kelas) || empty($no_hp)) {
        $error = "Semua input wajib diisi.";
    } else {
        $cek = $conn->prepare("SELECT id_anggota FROM anggota WHERE nim = ?");
        $cek->bind_param("s", $nim);
        $cek->execute();
        $hasil = $cek->get_result();

        if ($hasil->num_rows > 0) {
            $error = "NIM sudah terdaftar. Gunakan NIM lain.";
        } else {
            $stmt = $conn->prepare("INSERT INTO anggota (nama_anggota, nim, kelas, no_hp) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama_anggota, $nim, $kelas, $no_hp);

            if ($stmt->execute()) {
                header("Location: anggota.php?success=" . urlencode("Data anggota berhasil ditambahkan."));
                exit;
            } else {
                $error = "Data anggota gagal ditambahkan.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Anggota - Sistem Kas Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Sistem Kas Kelas</a>

        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
            <a class="nav-link active" href="anggota.php">Data Anggota</a>
            <a class="nav-link" href="transaksi.php">Data Transaksi</a>
            <a class="nav-link" href="../auth/logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <h3 class="mb-3">Tambah Anggota</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <?php if (!empty($error)) { ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php } ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Nama Anggota</label>
                    <input type="text" name="nama_anggota" class="form-control" placeholder="Masukkan nama anggota">
                </div>

                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" name="nim" class="form-control" placeholder="Masukkan NIM">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <input type="text" name="kelas" class="form-control" placeholder="Masukkan kelas">
                </div>

                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="Masukkan nomor HP">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="anggota.php" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>

</body>
</html>