<?php
session_start();
include 'connection.php';

if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];

    // Cari user_id berdasarkan username
    $query = "SELECT user_id FROM users WHERE username = $1";
    $result = pg_query_params($conn, $query, array($username));
    $row = pg_fetch_assoc($result);

    if ($row) {
        $user_id = $row['user_id'];
        // Jika user_id ditemukan, tambahkan produk ke keranjang
        
        $produk_id = $_GET['id'];

        // Cek apakah produk sudah ada dalam keranjang pengguna
        $checkQuery = "SELECT * FROM keranjang WHERE user_id = $1 AND produk_id = $2";
        $checkResult = pg_query_params($conn, $checkQuery, array($user_id, $produk_id));
        $checkRow = pg_fetch_assoc($checkResult);

        if ($checkRow) {
            // Jika produk sudah ada dalam keranjang, tambahkan quantity dan perbarui total harga
            $updateQuery = "UPDATE keranjang SET quantity = quantity + 1, total_harga = (SELECT harga_produk FROM produk WHERE produk_id = $2) * (quantity + 1) WHERE user_id = $1 AND produk_id = $2";
            pg_query_params($conn, $updateQuery, array($user_id, $produk_id));
            echo 'pppplll';
        } else {
            // Jika produk belum ada dalam keranjang, tambahkan produk baru dengan quantity 1 dan harga produk
            $insertQuery = "INSERT INTO keranjang (user_id, produk_id, quantity, total_harga) SELECT $user_id, $produk_id, 1, harga_produk FROM produk WHERE produk_id = $produk_id";
            pg_query($conn, $insertQuery);
            echo 'pppp';
        }

        // Berikan pesan sukses atau tindakan lainnya
        echo "Produk telah ditambahkan ke keranjang.";

        // Arahkan ulang ke halaman sebelumnya dengan tanda anchor untuk kembali ke bawah
        $previousURL = $_SERVER['HTTP_REFERER'];
        header('Location: ' . $previousURL . '#addcart');
        exit();
    } else {
        // Jika user_id tidak ditemukan, berikan pesan error atau tindakan lainnya
        echo "Pengguna dengan username '$username' tidak ditemukan.";

        // Arahkan ulang ke halaman sebelumnya dengan tanda anchor untuk kembali ke bawah
        $previousURL = $_SERVER['HTTP_REFERER'];
       // header('Location: ' . $previousURL . '#addcart');
       // exit();
    }
} else {
    // Jika pengguna belum login, redirect ke halaman login atau berikan pesan lainnya
    echo "Anda harus login terlebih dahulu untuk menambahkan produk ke keranjang.";
    header('Location: ../../login.php');
    exit();
}

include 'closedb.php';
?>
