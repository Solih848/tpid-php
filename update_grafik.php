<?php
$jsonFile = 'data_inflasi.json';

// Pastikan file JSON ada
if (file_exists($jsonFile)) {
    // Baca data yang ada dalam file JSON
    $existingData = json_decode(file_get_contents($jsonFile), true);

    // Ambil data dari permintaan POST
    $bulan = $_POST['bulan'];
    $inflasi = $_POST['inflasi'];
    $inflasi_tahun_kalender = $_POST['inflasi_tahun_kalender'];
    $inflasi_tahun_ke_tahun = $_POST['inflasi_tahun_ke_tahun'];

    // Cari entri dengan bulan yang sesuai dan perbarui
    $updated = false;
    foreach ($existingData as &$data) {
        if ($data['bulan'] === $bulan) {
            $data['inflasi'] = $inflasi;
            $data['inflasi_tahun_kalender'] = $inflasi_tahun_kalender;
            $data['inflasi_tahun_ke_tahun'] = $inflasi_tahun_ke_tahun;
            $updated = true; // Tandai bahwa data telah diperbarui
        }
    }

    if ($updated) {
        // Simpan data yang diperbarui ke file JSON
        file_put_contents($jsonFile, json_encode($existingData));
        echo "Data untuk bulan $bulan berhasil diperbarui.";
    } else {
        echo "Data untuk bulan $bulan tidak ditemukan.";
    }
} else {
    echo "File JSON tidak ditemukan.";
}
?>
