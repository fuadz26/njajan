<?php
// koneksi database
include 'connection.php';
// memulai session
session_start();


$id = $_SESSION['user_id'];
$name = $_POST['name'];
$address = $_POST['address'];
$city = $_POST['city'];
$kodepos = $_POST['kodepos'];
$telepon = $_POST['telepon'];

// memeriksa apakah ada data yang kosong
if (empty($id) || empty($name) || empty($address) || empty($city) || empty($kodepos) || empty($telepon)) {
    $_SESSION['alert_message'] = "Harap mengisi semua data yang dibutuhkan!";
    header("location: ../../tambah_alamat.php"); // mengalihkan ke halaman form
} else {
    // menginput data ke database
    $sql = "INSERT INTO alamatpengiriman (user_id, nama_penerima, alamat, kota, kode_pos, nomor_telepon)
        VALUES ('$id', '$name', '$address', '$city', '$kodepos', '$telepon')";
    $result = pg_query($conn, $sql);

    if (!$result) {
        $_SESSION['alert_message'] = "Terjadi kesalahan saat menambahkan data!";
        header("location: ../../tambah_alamat.php"); // mengalihkan kembali ke halaman form
        echo $result;
    } else {
        $_SESSION['alert_message'] = "Data berhasil ditambahkan!";
        header("location: address.php?=$id"); // mengalihkan ke halaman index
    }
}
