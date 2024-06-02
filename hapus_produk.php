<?php

include 'asset/php/connection.php';

session_start();

$id = $_GET['id'];

if (empty($id)) {
    $_SESSION['alert_message'] = "ID tidak valid!";
    header("location: list_product.php");
    exit;
}

$sql = "DELETE FROM produk WHERE produk_id = $id";

$result = pg_query($conn, $sql);

if ($result) {
    $_SESSION['alert_message'] = "Data berhasil dihapus!";
    header("location: list_product.php");
    exit;
} else {
    $_SESSION['alert_message'] = "Terjadi kesalahan saat menghapus data: " . pg_last_error($conn);
    header("location: list_product.php");
    exit;
}
