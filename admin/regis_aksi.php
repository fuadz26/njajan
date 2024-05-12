<?php
    // koneksi database
    include '../asset/php/connection.php';
    // memulai session
    session_start();

    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // memeriksa apakah ada data yang kosong
    if (empty($name) || empty($email) || empty($username) || empty($password)){
        $_SESSION['alert_message'] = "Harap mengisi semua data yang dibutuhkan!";
        header("location: regis_admin.php"); // mengalihkan ke halaman form
    } else {
        // menginput data ke database
        $sql = "INSERT INTO admin (admin_nama_lengkap, admin_email, admin_name,admin_pass)
        VALUES ('$name', '$email', '$username', '$password')";
        $result = pg_query($conn, $sql);

        if (!$result) {
            $_SESSION['alert_message'] = "Terjadi kesalahan saat menambahkan data!";
            header("location: ./regis.php"); // mengalihkan kembali ke halaman form
        } else {
            $_SESSION['alert_message'] = "Data berhasil ditambahkan!";
            header("location: Home.php"); // mengalihkan ke halaman index
        }
    }
?>
