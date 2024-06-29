<?php
// proses_reset_password.php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['reset_username'])) {
        header('Location: lupa_password.php');
        exit();
    }

    $username = $_SESSION['reset_username'];
    $new_password = $_POST['new_password'];

    $query = "UPDATE admin SET password = '$new_password' WHERE username1 = '$username' AND role = 'admin_super'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Password berhasil direset
        unset($_SESSION['reset_username']);
        header('Location: login_admin.php');
    } else {
        // Jika ada kesalahan
        $_SESSION['reset_error'] = 'Gagal mengubah password. Silakan coba lagi.';
        header('Location: reset_password.php');
    }
} else {
    header('Location: lupa_password.php');
}
