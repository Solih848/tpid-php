<?php
$json_file_path = 'data.json';

// Mendapatkan data teks paragraf dari file JSON
$json_data = file_get_contents($json_file_path);
$penjelasan = json_decode($json_data, true);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mendapatkan data dari form
    // Gunakan nama yang benar sesuai dengan form input
    $penjelasan_1 = $_POST['penjelasan_1'];

    // Update JSON dengan data baru
    $penjelasan['infoText'] = $penjelasan_1;

    // Simpan kembali ke file JSON
    file_put_contents($json_file_path, json_encode($penjelasan));

    $message = "Paragraf berhasil diperbarui!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Text Tabel Komoditi</title>
    <!-- CSS Framework untuk gaya yang lebih elegan -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <style>
        .container {
            max-width: 800px; /* Lebar maksimum container */
            margin: 0 auto; /* Centering secara horizontal */
            padding: 20px; /* Ruang di dalam container */
            background-color: #f9f9f9; /* Warna latar belakang */
            border-radius: 10px; /* Sudut melengkung */
            /* Border biasa dengan warna abu-abu */
            border: 1px solid #ccc; /* Border dengan ketebalan 2px */
            /* Shadow untuk efek 3D yang ringan */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
            margin-top: 25px;
            margin-bottom: 25px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
        }
        input[type="submit"] {
            background-color: #4CAF50; /* Warna hijau */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease; /* Animasi transisi */
        }
        input[type="submit"]:hover {
            background-color: #45a049; /* Warna saat di-hover */
        }
        .message {
            color: green; 
            font-size: 16px; 
            margin-bottom: 20px;
            text-align: center;
        }

        @media (max-width: 767px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Edit Text Tabel Komoditi</h1>
        </div>
        
        <?php if (isset($message)) : ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div>
                <label for="penjelasan_1">Info Text:</label><br>
                <textarea name="penjelasan_1" rows="5"><?php echo htmlspecialchars($penjelasan['infoText']); ?></textarea>
            </div>

            <div style="margin-top: 20px; text-align: center;">
                <input type="submit" value="Simpan">
            </div>
        </form>
    </div>
</body>
</html>
