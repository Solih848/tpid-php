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
    
    $query_inflasi = "UPDATE inflasi SET nip='$nip', jabatan='$jabatan', opd='$opd', whatsapp='$whatsapp', email='$email', password='$password' WHERE username2='$username'";
    $result_inflasi = mysqli_query($koneksi, $query_inflasi);

    $query_users = "UPDATE users SET password='$password' WHERE username='$username'";
    $result_users = mysqli_query($koneksi, $query_users);

    if ($result_inflasi && $result_users) {
        header('Location: halaman_inflasi.php');
        echo "Data operator berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui data operator. Silakan coba lagi.";
    }
} 
?>
