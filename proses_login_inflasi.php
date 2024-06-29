<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username2'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND role = 'inflasi'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username2'] = $username;
        header('Location: edit_inflasi.php'); // Redirect ke halaman admin
    } else {
        $_SESSION['login_error'] = 'Username atau password salah.';
        header('Location: login_inflasi.php');
    }
} else {
    header('Location: login_inflasi.php');
}
?>
