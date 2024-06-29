<?php
// Sertakan file koneksi
include 'koneksi_coba.php';

// Periksa jika metode permintaan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah input id dan judul_produk sudah tersedia
    if (isset($_POST["id"]) && isset($_POST["judul_produk"])) {
                // Tangkap nilai id dan judul_produk dari permintaan POST
        $idProduk = $_POST["id"];
        $judulProdukUpdate = $_POST["judul_produk"];
        $subJudulProdukUpdate = $_POST["sub_judul_produk"];

        // Persiapkan pernyataan SQL untuk memperbarui data di database
        $sql = "UPDATE produk SET judul_produk='$judulProdukUpdate', sub_judul_produk='$subJudulProdukUpdate' WHERE id=$idProduk";

        // Jalankan pernyataan SQL
        if (mysqli_query($koneksi, $sql)) {
            // Kirim respons sukses
            echo "Data produk berhasil diperbarui.";
        } else {
            // Jika terjadi kesalahan, tampilkan pesan kesalahan SQL
            echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
        }
    } else {
        // Jika data tidak lengkap, tampilkan pesan
        echo "Data tidak lengkap.";
    }
} else {
    // Tidak melakukan pengalihan header
}
?>

