<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM barang WHERE id = $id";
    mysqli_query($koneksi, $query);
    header('Location: admin.php');
}
?>
