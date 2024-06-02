<?php
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    include 'connection.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT user_id FROM users WHERE username = '$username' AND password = '$password' AND is_verif = 1";
    $result = pg_query($conn, $sql);

    if ($result !== false && pg_num_rows($result) == 1) {
        $row = pg_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_is_logged_in'] = true;
        $_SESSION['user'] = $username;
        header('Location: ../../index.php');
        exit;
    } else {

        $sql = "SELECT admin_id FROM admin WHERE admin_name = '$username' AND admin_pass = '$password'";
        $result = pg_query($conn, $sql);

        if ($result !== false && pg_num_rows($result) == 1) {
            $row = pg_fetch_assoc($result);
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['admin_is_logged_in'] = true;
            $_SESSION['admin'] = $username;
            $_SESSION['alert_message'] = 'Anda berhasil login';
            header('Location: ../../admin/home.php');
            exit;
        } else {
            $_SESSION['alert_message'] = 'Maaf, username atau password salah';
            header('Location: /login.php');
            exit;
        }
    }
} else {
    $_SESSION['alert_message'] = 'Silakan masukkan username dan password';
    header('Location: /login.php');
    exit;
}
