<?php
include 'connection.php';
session_start();

$name = $_POST['name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$code = md5($email . date('Y-m-d'));

require '../../vendor/autoload.php'; // Pastikan jalur ini benar

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

if (empty($name) || empty($email) || empty($username) || empty($password)) {
    $_SESSION['alert_message'] = "Harap mengisi semua data yang dibutuhkan!";
    header("Location: ../../regis.php");
} else {
    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ahmadfuadi2611@gmail.com';
        $mail->Password = 'uxbycneydxcliwib'; // Gunakan kata sandi aplikasi
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('from@tumbas.com', 'Verifikasi');
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi akun TUMBAS';
        $mail->Body = 'HI! ' . $username . ', Terimakasih sudah mendaftar di website ini, <br> Mohon verifikasi akun kamu dengan mengklik tautan berikut: <br><a href="http://localhost:8080/asset/php/verif.php?code=' . $code . '">Verifikasi</a>';
        $mail->AltBody = 'HI! ' . $username . ', Terimakasih sudah mendaftar di website ini. Mohon verifikasi akun kamu dengan mengunjungi tautan berikut: http://localhost:8080/asset/php/verif.php?code=' . $code;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        
    }
  

    $sql = "INSERT INTO users (nama_lengkap, email, username, password, kode_verif) VALUES ('$name', '$email', '$username', '$password', '$code')";
    $result = pg_query($conn, $sql);

    if (!$result) {
        $error_message = pg_last_error($conn);
        echo $error_message;
        $_SESSION['alert_message'] = "Terjadi kesalahan saat menambahkan data!";
        header("Location: ../../regis.php");
    } else {
        $_SESSION['alert_message'] = "Registrasi berhasil! silahkan verifikasi akun anda";
        header("Location: ../../login.php");
    }
}
?>
