<?php session_start();
$errorMessage = '';

if (isset($_POST['username']) && isset($_POST['password'])) {
    include 'connection.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek username dan password di tabel users
    $sql = "SELECT username, user_id FROM users WHERE username = '$username' AND password = '$password'";
    $result = pg_query($conn, $sql);

    if ($result !== false) {
        if (pg_num_rows($result) == 1) {
            $row = pg_fetch_object($result);
            $_SESSION['user_id'] = $row->user_id;
            $_SESSION['user_is_logged_in'] = true;
            $_SESSION['user'] = $username;
            header('Location: ../../index.php');
            exit;
        } else {
            // Jika tidak ada cocok di tabel users, cek di tabel admin
            $sql = "SELECT admin_name, admin_id FROM admin WHERE admin_name = '$username' AND admin_pass = '$password'";
            $result = pg_query($conn, $sql);

            if ($result !== false && pg_num_rows($result) == 1) {
                $row = pg_fetch_object($result);
                $_SESSION['admin_id'] = $row->admin_id;
                $_SESSION['admin_is_logged_in'] = true;
                $_SESSION['admin'] = $username;
                header('Location: ../../admin/home.php');
                exit;
            } else {
                $_SESSION['errorMessages'] = 'Sorry, wrong user ID / password';
                header('Location: /login.php');
                exit;
            }
        }
    } else {
        $_SESSION['errorMessages'] = 'Database error occurred';
        header('Location: /login.php');
        exit;
    }

    include 'closedb.php';
}
