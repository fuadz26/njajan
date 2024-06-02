<?php

include 'asset/php/connection.php';

session_start();


$id = $_GET['id'];

if (empty($id)) {
    $_SESSION['alert_message'] = "ID tidak valid!";
    header("location: produk.php");
    exit;
}

$sql = "DELETE FROM keranjang WHERE keranjang_id = $id";

$result = pg_query($conn, $sql);

if ($result) {
    $_SESSION['alert_message'] = "Data berhasil dihapus!";
    header("location: wishlist.php");
    exit;
} else {
    $_SESSION['alert_message'] = "Terjadi kesalahan saat menghapus data.";
    $error = pg_last_error($conn);
    echo $error;
}
