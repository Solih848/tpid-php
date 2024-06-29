<?php
$jsonFile = 'data_inflasi.json';

// Pastikan file JSON ada
if (file_exists($jsonFile)) {
    // Baca data yang ada dalam file JSON
    $existingData = json_decode(file_get_contents($jsonFile), true);

    // Ambil bulan dari permintaan POST
    $bulan = $_POST['bulan'];

    // Cari entri dengan bulan yang sesuai dan hapus
    $newData = [];
    foreach ($existingData as $data) {
        if ($data['bulan'] !== $bulan) {
            $newData[] = $data; // Tambahkan data yang tidak dihapus
        }
    }

    // Simpan data baru ke file JSON
    file_put_contents($jsonFile, json_encode($newData));

    echo "Data untuk bulan $bulan berhasil dihapus.";
} else {
    echo "File JSON tidak ditemukan.";
}
?>
