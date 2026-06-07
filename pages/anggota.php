<?php
include '../middleware/auth_check.php';
include '../config/database.php';

$query = mysqli_query($conn, "SELECT * FROM anggota ORDER BY id_anggota DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Anggota - Sistem Kas Kelas</title>
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

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Anggota</h3>

        <?php if ($_SESSION['role'] == 'admin') { ?>
    <div>
        <a href="export_anggota.php" class="btn btn-success me-2">Export CSV</a>
        <a href="tambah_anggota.php" class="btn btn-primary">Tambah Anggota</a>
    </div>
<?php } ?>

    <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php } ?>

    <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php } ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Anggota</th>
                        <th>NIM</th>
                        <th>Kelas</th>
                        <th>No HP</th>

                        <?php if ($_SESSION['role'] == 'admin') { ?>
                            <th width="18%">Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $no = 1;
                    if (mysqli_num_rows($query) > 0) {
                        while ($data = mysqli_fetch_assoc($query)) {
                    ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($data['nama_anggota']); ?></td>
                                <td><?php echo htmlspecialchars($data['nim']); ?></td>
                                <td><?php echo htmlspecialchars($data['kelas']); ?></td>
                                <td><?php echo htmlspecialchars($data['no_hp']); ?></td>

                                <?php if ($_SESSION['role'] == 'admin') { ?>
                                    <td>
                                        <a href="edit_anggota.php?id=<?php echo $data['id_anggota']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="hapus_anggota.php?id=<?php echo $data['id_anggota']; ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Yakin ingin menghapus anggota ini?')">
                                           Hapus
                                        </a>
                                    </td>
                                <?php } ?>
                            </tr>
                    <?php
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="<?php echo ($_SESSION['role'] == 'admin') ? '6' : '5'; ?>" class="text-center">
                                Belum ada data anggota.
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>

</div>

</body>
</html>