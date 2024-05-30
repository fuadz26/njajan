<?php
include 'connection.php';

$code = $_GET['code'];
if (isset($code)) { 
    $sql = "UPDATE users SET is_verif = 1 WHERE kode_verif = '$code'";
    $result = pg_query($conn, $sql);

    if (isset($result)) {
        $_SESSION['alert_message'] = "Verifikasi Berhasil silahkan Login";
        header("location: ../../login.php");
        
    }
    else {
        $_SESSION['alert_message'] = "eror QUery";
        header("location: ../../login.php");
    }
}
