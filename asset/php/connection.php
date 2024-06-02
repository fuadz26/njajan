<?php
$host = "localhost";
$user = "postgres";
$password = "kimielek123";
$dbname = "NjajanFix";

$conn = pg_connect("host=$host port=5432 dbname=$dbname user=$user password=$password");
if (!$conn) {
    die("Koneksi Gagal:");
}
