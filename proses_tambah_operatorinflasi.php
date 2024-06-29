<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username2'];
    $nip = $_POST['nip'];
    $jabatan = $_POST['jabatan'];
    $opd = $_POST['opd'];
    $whatsapp = $_POST['whatsapp'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'inflasi')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $query_operator = "INSERT INTO inflasi (username2, nip, jabatan, opd, whatsapp, email, password) VALUES ('$username', '$nip', '$jabatan', '$opd', '$whatsapp', '$email', '$password')";
        $result_operator = mysqli_query($koneksi, $query_operator);
        
        if ($result_operator) {
            header('Location: halaman_inflasi.php'); 
            echo "Operator berhasil ditambahkan.";

        } else {
            echo "Gagal menambahkan operator. Silakan coba lagi.";
        }
    } else {
        echo "Gagal menambahkan operator. Silakan coba lagi.";
    }
} 
?>
