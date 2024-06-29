<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username1'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username1 = '$username' AND password = '$password' AND role = 'admin_super'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username1'] = $username;
        $_SESSION['role'] = 'admin_super'; // Menandakan sebagai admin super
        header('Location: admin_super.php');
    } else {
        $_SESSION['login_error'] = 'Username atau password salah.';
        header('Location: login_admin.php');
    }
} else {
    header('Location: login_admin.php');
}
?>