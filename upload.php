<?php
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
    
    include 'asset/php/connection.php';
    $query = "UPDATE users SET user_img = '$filePath' WHERE username = '$username'";
    $result = pg_query($conn, $query);
    
    if ($result === false) {
        echo "Error updating database";
        exit;
    }
    
    include 'closedb.php';
    
    echo "<br>File uploaded<br>";
    header('Location: ../../profile.php');
    exit;
}
?>
