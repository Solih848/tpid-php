<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $nip = $_POST['nip'];
    $jabatan = $_POST['jabatan'];
    $opd = $_POST['opd'];
    $whatsapp = $_POST['whatsapp'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $query_operator = "UPDATE operator SET nip='$nip', jabatan='$jabatan', opd='$opd', whatsapp='$whatsapp', email='$email', password='$password' WHERE username='$username'";
    $result_operator = mysqli_query($koneksi, $query_operator);

    $query_users = "UPDATE users SET password='$password' WHERE username='$username'";
    $result_users = mysqli_query($koneksi, $query_users);

    if ($result_operator && $result_users) {
        header('Location: admin_super.php');
        echo "Data operator berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui data operator. Silakan coba lagi.";
    }
} 
?>
