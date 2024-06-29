<?php
include 'koneksi_sembako.php'; // Pastikan file koneksi sudah sesuai dengan konfigurasi Anda

if (isset($_GET['nama_bahan_pokok']) && isset($_GET['nama_pasar'])) {
    $namaBahanPokok = $_GET['nama_bahan_pokok'];
    $namaPasar = $_GET['nama_pasar'];

    // Query untuk mengambil harga sekarang berdasarkan nama bahan pokok, nama pasar, dan tanggal terbaru
    $query = "SELECT harga_sekarang FROM sub_judul_produk WHERE nama_bahan_pokok = :namaBahanPokok AND nama_pasar = :namaPasar ORDER BY tanggal DESC LIMIT 1";
    $stmt = $koneksi->prepare($query);
    $stmt->bindParam(":namaBahanPokok", $namaBahanPokok);
    $stmt->bindParam(":namaPasar", $namaPasar);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo $result['harga_sekarang'];
    } else {
        echo "Harga tidak ditemukan";
    }
} else {
    echo "Parameter tidak lengkap";
}
?>
