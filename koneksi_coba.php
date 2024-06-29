<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'uji_coba';

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
