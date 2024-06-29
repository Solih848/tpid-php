<?php
// Sertakan file koneksi
include 'koneksi_coba.php';

// Periksa jika metode permintaan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah input id dan nama_pasar sudah tersedia
    if (isset($_POST["id"]) && isset($_POST["nama_pasar"])) {
        // Tangkap nilai id dan nama_pasar dari permintaan POST
        $idPasar = $_POST["id"];
        $namaPasarUpdate = $_POST["nama_pasar"];

        // Persiapkan pernyataan SQL untuk memperbarui data di database
        $sql = "UPDATE pasar SET nama_pasar='$namaPasarUpdate' WHERE id=$idPasar";

        // Jalankan pernyataan SQL
        if (mysqli_query($koneksi, $sql)) {
            // Berhasil
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
