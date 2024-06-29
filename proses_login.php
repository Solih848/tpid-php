<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND role = 'operator'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['authenticated'] = true; // Tandai bahwa login berhasil
        // Cek apakah pengguna adalah jufriyadi dengan password 654321
        if ($username === 'jufriyadi' && $password === '654321') {
            $_SESSION['is_jufriyadi'] = true;
        } else {
            $_SESSION['is_jufriyadi'] = false;
        }
        header('Location: operator.php'); // Redirect ke halaman operator
        exit(); // Tambahkan exit() setelah header
    } else {
        $_SESSION['login_error'] = 'Username atau password salah.';
        header('Location: login.php');
        exit(); // Tambahkan exit() setelah header
    }
} else {
    header('Location: login.php');
    exit(); // Tambahkan exit() setelah header
}
?>
