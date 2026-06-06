<?php
include '../middleware/auth_check.php';
include '../middleware/admin_check.php';
include '../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: anggota.php?error=" . urlencode("ID anggota tidak valid."));
    exit;
}

$id_anggota = $_GET['id'];
$error = "";

$stmt = $conn->prepare("SELECT * FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id_anggota);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: anggota.php?error=" . urlencode("Data anggota tidak ditemukan."));
    exit;
}

$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_anggota = trim($_POST['nama_anggota']);
    $nim = trim($_POST['nim']);
    $kelas = trim($_POST['kelas']);
    $no_hp = trim($_POST['no_hp']);

    if (empty($nama_anggota) || empty($nim) || empty($kelas) || empty($no_hp)) {
        $error = "Semua input wajib diisi.";
    } else {
        $cek = $conn->prepare("SELECT id_anggota FROM anggota WHERE nim = ? AND id_anggota != ?");
        $cek->bind_param("si", $nim, $id_anggota);
        $cek->execute();
        $hasil = $cek->get_result();

        if ($hasil->num_rows > 0) {
            $error = "NIM sudah digunakan oleh anggota lain.";
        } else {
            $update = $conn->prepare("UPDATE anggota SET nama_anggota = ?, nim = ?, kelas = ?, no_hp = ? WHERE id_anggota = ?");
            $update->bind_param("ssssi", $nama_anggota, $nim, $kelas, $no_hp, $id_anggota);

            if ($update->execute()) {
                header("Location: anggota.php?success=" . urlencode("Data anggota berhasil diperbarui."));
                exit;
            } else {
                $error = "Data anggota gagal diperbarui.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Anggota - Sistem Kas Kelas</title>
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

    <h3 class="mb-3">Edit Anggota</h3>

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
                    <input type="text" name="nama_anggota" class="form-control" value="<?php echo htmlspecialchars($data['nama_anggota']); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" name="nim" class="form-control" value="<?php echo htmlspecialchars($data['nim']); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <input type="text" name="kelas" class="form-control" value="<?php echo htmlspecialchars($data['kelas']); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="<?php echo htmlspecialchars($data['no_hp']); ?>">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="anggota.php" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>

</body>
</html>