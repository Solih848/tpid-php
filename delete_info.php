<?php
// Baca data JSON dari file
$data = json_decode(file_get_contents('ekonomi.json'), true);

// Ambil index data yang akan dihapus
$index = $_POST['index'];

// Hapus data sesuai dengan index yang diberikan
array_splice($data, $index, 1);

// Tulis kembali data ke file JSON
file_put_contents('ekonomi.json', json_encode($data));

// Beri respons bahwa data telah dihapus
echo json_encode(['message' => 'Info telah dihapus.']);
?>
