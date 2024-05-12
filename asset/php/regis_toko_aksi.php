<?php
session_start();
include 'connection.php';

if(isset($_POST['nama_toko']) && isset($_POST['deskripsi_toko']) && isset($_POST['nomor_telepon']) && isset($_POST['alamat_toko'])) {
    $nama_toko = $_POST['nama_toko'];
    $deskripsi_toko = $_POST['deskripsi_toko'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $alamat_toko = $_POST['alamat_toko'];
    $user_id = $_SESSION['user_id'];

    // Query untuk menyimpan data toko ke database
    $sql = "INSERT INTO toko (user_id,nama_toko, deskripsi_toko, nomor_telepon_toko, alamat_toko)
            VALUES ($user_id,$1, $2, $3, $4)";
    $stmt = pg_prepare($conn, "insert_store", $sql);

    // Eksekusi query
    $result = pg_execute($conn, "insert_store", array($nama_toko, $deskripsi_toko, $nomor_telepon, $alamat_toko));

    // Cek hasil eksekusi query
    if ($result) {
        // Jika berhasil disimpan, tampilkan pesan sukses
        $_SESSION['success_message'] = "Store registered successfully.";
        header('Location: ../../toko.php');
        exit();
    } else {
        // Jika terjadi kesalahan, tampilkan pesan error
        $_SESSION['error_message'] = "Error registering store.";
        //header('Location: ../../regis_toko.php');
        exit();
    }
} else {
    // Jika data tidak lengkap, kembalikan ke halaman regis_toko.php
    $_SESSION['error_message'] = "Please fill in all the fields.";
    header('Location: ../../regis_toko.php');
    exit();
}

include 'closedb.php';
