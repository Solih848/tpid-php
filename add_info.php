<?php
// Validasi input
if (!isset($_POST['title']) || !isset($_POST['description']) || !isset($_POST['link'])) {
    http_response_code(400); // Bad request
    echo json_encode(['message' => 'Gagal menambahkan info. Data tidak lengkap.']);
    exit();
}

// Baca data JSON dari file
$data = json_decode(file_get_contents('ekonomi.json'), true);

// Ambil data dari request
$newInfo = [
    'title' => $_POST['title'],
    'description' => $_POST['description'],
    'link' => $_POST['link']
];

// Tambahkan data baru ke array
$data[] = $newInfo;

// Tulis kembali data ke file JSON dengan penguncian file
if (file_put_contents('ekonomi.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false) {
    // Beri respons bahwa data telah ditambahkan
    echo json_encode(['success' => true, 'message' => 'Info telah ditambahkan.']);
} else {
    // Jika gagal menulis ke file, beri respons gagal
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'message' => 'Gagal menambahkan info. Terjadi kesalahan server.']);
}
?>
