<?php
// Baca data JSON dari file
$data = json_decode(file_get_contents('ekonomi.json'), true);

// Ambil index data yang akan diedit
$index = $_POST['index'];

// Ambil data baru dari request
$newInfo = [
    'title' => $_POST['title'],
    'description' => $_POST['description'],
    'link' => $_POST['link']
];

// Edit data sesuai dengan index yang diberikan
$data[$index] = $newInfo;

// Tulis kembali data ke file JSON
file_put_contents('ekonomi.json', json_encode($data));

// Beri respons bahwa data telah diedit
echo json_encode(['message' => 'Info telah diubah.']);
?>
