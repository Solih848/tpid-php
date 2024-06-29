<?php
session_start();

if (!isset($_SESSION['username2'])) {
    header('Location: login_inflasi.php');
    exit();
}

$host = 'localhost';
$dbname = 'sem';
$dbusername = 'root';
$password = '';

try {
    $koneksi = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $password);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi ke database gagal: " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $tanggal = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-01';
    $inflasi = $_POST['inflasi'];
    $inflasi_tahun_kalender = $_POST['inflasi_tahun_kalender'];
    $inflasi_tahun_ke_tahun = $_POST['inflasi_tahun_ke_tahun'];

    $sql = "INSERT INTO data_inflasi (tanggal, inflasi, inflasi_tahun_kalender, inflasi_tahun_ke_tahun) VALUES (:tanggal, :inflasi, :inflasi_tahun_kalender, :inflasi_tahun_ke_tahun)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':tanggal', $tanggal);
    $stmt->bindParam(':inflasi', $inflasi);
    $stmt->bindParam(':inflasi_tahun_kalender', $inflasi_tahun_kalender);
    $stmt->bindParam(':inflasi_tahun_ke_tahun', $inflasi_tahun_ke_tahun);

    if ($stmt->execute()) {
        header('Location: edit_inflasi.php');
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
