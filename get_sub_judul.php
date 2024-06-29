<?php
// Koneksi ke database
include 'koneksi_coba.php';

// Periksa koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

// Ambil judul produk yang dipilih pengguna
$judulProduk = $_GET['judul_produk'];

// Ambil daftar sub judul produk yang sesuai dari database
$query = "SELECT sub_judul_produk FROM produk WHERE judul_produk = '$judulProduk'";
$result = mysqli_query($koneksi, $query);

// Tampilkan daftar sub judul produk sebagai pilihan pada list box
while ($row = mysqli_fetch_array($result)) {
    echo "<option value='" . $row['sub_judul_produk'] . "'>" . $row['sub_judul_produk'] . "</option>";
}

// Tutup koneksi database
mysqli_close($koneksi);
?>
