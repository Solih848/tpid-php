<?php
session_start();

if (!isset($_SESSION['username2'])) {
    header('Location: login_inflasi.php');
    exit();
}

$host = 'localhost';
$dbname = 'sem';
$username = 'root';
$password = '';

try {
    $koneksi = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi ke database gagal: " . $e->getMessage();
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM data_inflasi WHERE id = :id";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header('Location: edit_inflasi.php');
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
