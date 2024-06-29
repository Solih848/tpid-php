<?php
include 'koneksi.php';

$username = $_GET['username'];

$query_user = "DELETE FROM users WHERE username='$username'";
$query_operator = "DELETE FROM operator WHERE username='$username'";

$result_user = mysqli_query($koneksi, $query_user);
$result_operator = mysqli_query($koneksi, $query_operator);

if ($result_user && $result_operator) {
    header('Location: admin_super.php');
    echo "Data operator berhasil dihapus.";
} else {
    echo "Gagal menghapus data operator. Silakan coba lagi.";
}
?>
