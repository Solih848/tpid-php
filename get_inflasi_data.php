<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sem";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mendapatkan 12 data terbaru dari database, diurutkan berdasarkan tanggal secara descending
$sql = "SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, inflasi, inflasi_tahun_kalender, inflasi_tahun_ke_tahun 
        FROM data_inflasi 
        ORDER BY tanggal DESC 
        LIMIT 12";

$result = $conn->query($sql);

$allData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $allData[] = $row;
    }
}

// Urutkan data berdasarkan bulan secara ascending untuk memastikan data dalam urutan waktu yang benar
usort($allData, function ($a, $b) {
    return strtotime($a['bulan']) - strtotime($b['bulan']);
});

// Menetapkan header JSON dan mengirimkan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($allData);

// Menutup koneksi
$conn->close();
