<?php
// proses_lupa_password.php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username1'];

    // Sanitasi input untuk mencegah SQL injection
    $username = mysqli_real_escape_string($koneksi, $username);

    $query = "SELECT * FROM admin WHERE username1 = '$username' AND role = 'admin_super'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        // Jika username/email ada, arahkan ke halaman reset password
        $_SESSION['reset_username'] = $username;
        header('Location: reset_password.php');
    } else {
        $_SESSION['reset_error'] = 'Username atau email tidak ditemukan.';
        header('Location: lupa_password.php');
    }
} else {
    header('Location: lupa_password.php');
}
