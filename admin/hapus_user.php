<?php
// koneksi database
include '../asset/php/connection.php';
// memulai session
session_start();

// menangkap data yang dikirim melalui URL
$id = $_GET['id'];

if (empty($id)) {
    $_SESSION['alert_message'] = "ID tidak valid!";
    header("location: user.php");
    exit;
}

$sql = "DELETE FROM users WHERE user_id = '$id'";

$result = pg_query($conn, $sql);

if ($result) {
    $_SESSION['alert_message'] = "Data pengguna berhasil dihapus!";
    header("location: user.php");
    exit;
} else {
    $_SESSION['alert_message'] = "Terjadi kesalahan saat menghapus data pengguna.";
    header("location: user.php");
    exit;
}
?>
