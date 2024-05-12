<?php
    // koneksi database
    include 'connection.php';
    // memulai session
    session_start();

    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // memeriksa apakah ada data yang kosong
    if (empty($name) || empty($email) || empty($username) || empty($password)){
        $_SESSION['alert_message'] = "Harap mengisi semua data yang dibutuhkan!";
        header("location: ../../regis.php"); // mengalihkan ke halaman form
    } else {
        // menginput data ke database
        $sql = "INSERT INTO users(nama_lengkap, email, username, password)
        VALUES ('$name', '$email', '$username', '$password')";

        $result = pg_query($conn, $sql);

        if (!$result) {
            $_SESSION['alert_message'] = "Terjadi kesalahan saat menambahkan data!";
            header("location: ../../regis.php"); // mengalihkan kembali ke halaman form
        } else {
            $_SESSION['alert_message'] = "Data berhasil ditambahkan!";
            header("location: ../../login.php"); // mengalihkan ke halaman index
        }
    }
?>
