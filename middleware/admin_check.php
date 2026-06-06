<?php
if ($_SESSION['role'] != 'admin') {
    header("Location: ../pages/dashboard.php");
    exit;
}
?>