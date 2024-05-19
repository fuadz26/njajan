<?php
$host = "njajan-2.clky42we419p.ap-northeast-3.rds.amazonaws.com";
$user = "postgres";
$password = "zakizaki123";
$dbname = "zipedia";

$conn = pg_connect("host=$host port=5432 dbname=$dbname user=$user password=$password");
if (!$conn) {
    die("Koneksi Gagal:");
}
