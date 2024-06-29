<?php
// Sertakan file koneksi
include 'koneksi_coba.php';

// Periksa jika metode permintaan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah parameter id tersedia dalam permintaan POST
    if (isset($_POST["id"])) {
        // Ambil nilai id dari permintaan POST
        $idPasar = $_POST["id"];

        // Persiapkan statement SQL untuk menghapus data dari database
        $sql = "DELETE FROM pasar WHERE id = '$idPasar'";

        // Jalankan statement SQL
        if (mysqli_query($koneksi, $sql)) {
            // Kirim respons sukses
            echo "Data pasar berhasil dihapus.";
        } else {
            // Kirim respons error jika gagal menghapus
            echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
        }
    } else {
        // Kirim pesan error jika parameter id tidak tersedia
        echo "ID pasar tidak ditemukan dalam permintaan POST.";
    }
} else {
    // Kirim pesan error jika metode permintaan bukan POST
    echo "Metode permintaan harus POST.";
}
?>
