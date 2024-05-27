<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// Include koneksi database
include 'asset/php/connection.php';

$uploadDir = './asset/file/';

session_start();

$username = $_SESSION['user'];

if (isset($_POST['upload'])) {
    $fileName = $_FILES['user_img']['name'];
    $tmpName = $_FILES['user_img']['tmp_name'];
    $fileSize = $_FILES['user_img']['size'];
    $fileType = $_FILES['user_img']['type'];
    $filePath = $uploadDir . $fileName;

    $result = move_uploaded_file($tmpName, $filePath);

    if (!$result) {
        echo "Error uploading file";
        exit;
    }

    // Konfigurasi AWS
    $awsConfig = [
        'version' => 'latest',
        'region'  => 'ap-northeast-3',
        'credentials' => [
            'key'    => 'AKIA5FTZEUCNVLLQKMEP',
            'secret' => '',
        ],
    ];

    // Buat instance S3Client
    $s3Client = new S3Client($awsConfig);

    // Informasi S3
    $bucketName = 'njajan2';
    $s3Key = 'profile/' . $username . '/' . $fileName;

    // Fungsi untuk mengunggah file ke S3
    function uploadFileToS3($s3Client, $bucketName, $filePath, $s3Key)
    {
        try {
            $result = $s3Client->putObject([
                'Bucket' => $bucketName,
                'Key'    => $s3Key,
                'SourceFile' => $filePath,
            ]);
            echo "File berhasil diunggah ke S3. URL: " . $result['ObjectURL'] . "\n";
            return $result['ObjectURL'];
        } catch (AwsException $e) {
            echo "Gagal mengunggah file ke S3: " . $e->getMessage() . "\n";
            return false;
        }
    }

    // Upload file ke S3
    $s3Url = uploadFileToS3($s3Client, $bucketName, $filePath, $s3Key);

    if ($s3Url) {
        // Menyimpan URL S3 ke database
        $query = "UPDATE users SET user_img = '$s3Url' WHERE username = '$username'";
        $result = pg_query($conn, $query);

        if ($result === false) {
            echo "Error updating database";
            exit;
        }
    }

    echo "<br>File uploaded<br>";
    header('Location: ../../profile.php');
    exit;
}
