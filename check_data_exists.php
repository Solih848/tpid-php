<?php
session_start();
include 'koneksi_sembako.php'; // Koneksi ke database "sembako_db"

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul_produk = $_POST['judul_produk'];
    $sub_judul_produk = $_POST['sub_judul_produk'];
    $nama_pasar = $_POST['nama_pasar'];
    $tanggal = $_POST['tanggal'];
    $satuan = $_POST['satuan'];
    $harga_kemarin = $_POST['harga_kemaren'];
    $harga_sekarang = $_POST['harga_sekarang'];
    $operator_pasar = $_SESSION['username'];

    // Query untuk memeriksa apakah data sudah ada
    $query_check = "SELECT COUNT(*) FROM sub_judul_produk WHERE judul_produk = ? AND nama_bahan_pokok = ? AND nama_pasar = ? AND tanggal = ? AND satuan = ? AND harga_kemarin = ? AND harga_sekarang = ? AND operator_pasar = ?";
    $stmt = $koneksi->prepare($query_check);
    $stmt->bindParam(1, $judul_produk);
    $stmt->bindParam(2, $sub_judul_produk);
    $stmt->bindParam(3, $nama_pasar);
    $stmt->bindParam(4, $tanggal);
    $stmt->bindParam(5, $satuan);
    $stmt->bindParam(6, $harga_kemarin);
    $stmt->bindParam(7, $harga_sekarang);
    $stmt->bindParam(8, $operator_pasar);
    $stmt->execute();

    $row_count = $stmt->fetchColumn();

    // Jika data sudah ada, kirimkan respons "exists"
    if ($row_count > 0) {
        echo "exists";
    } else {
        echo "not_exists";
    }
}
?>
