<?php
$json_file_path = 'inflasi_text.json';

// Mendapatkan data teks paragraf dari file JSON
$json_data = file_get_contents($json_file_path);
$penjelasan = json_decode($json_data, true);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mendapatkan data dari form
    $penjelasan_1 = $_POST['penjelasan_1'];
    $penjelasan_2 = $_POST['penjelasan_2'];
    $penjelasan_3 = $_POST['penjelasan_3'];

    // Update JSON dengan data baru
    $penjelasan['penjelasan_1'] = $penjelasan_1;
    $penjelasan['penjelasan_2'] = $penjelasan_2;
    $penjelasan['penjelasan_3'] = $penjelasan_3;

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
    <title>Edit Penjelasan Inflasi</title>
    <!-- CSS Framework untuk gaya yang lebih elegan -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: Poppins, sans-serif;
        }

        .container {
            max-width: 800px;
            /* Lebar maksimum container */
            margin: 0 auto;
            /* Centering secara horizontal */
            padding: 20px;
            /* Ruang di dalam container */
            background-color: #f9f9f9;
            /* Warna latar belakang */
            border-radius: 10px;
            /* Sudut melengkung */
            /* Border biasa dengan warna abu-abu */
            border: 1px solid #ccc;
            /* Border dengan ketebalan 2px */
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
            background-color: #4CAF50;
            /* Warna hijau */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            /* Animasi transisi */
        }

        input[type="submit"]:hover {
            background-color: #45a049;
            /* Warna saat di-hover */
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
            <h1>Edit Penjelasan Inflasi</h1>
        </div>

        <?php if (isset($message)) : ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="post">
            <div>
                <label for="penjelasan_1">Paragraf 1:</label><br>
                <textarea name="penjelasan_1" rows="5"><?php echo htmlspecialchars($penjelasan['penjelasan_1']); ?></textarea>
            </div>

            <div style="margin-top: 20px;">
                <label for="penjelasan_2">Paragraf 2:</label><br>
                <textarea name="penjelasan_2" rows="5"><?php echo htmlspecialchars($penjelasan['penjelasan_2']); ?></textarea>
            </div>

            <div style="margin-top: 20px;">
                <label for="penjelasan_3">Paragraf 3:</label><br>
                <textarea name="penjelasan_3" rows="5"><?php echo htmlspecialchars($penjelasan['penjelasan_3']); ?></textarea>
            </div>

            <div style="margin-top: 20px; text-align: center;">
                <input type="submit" value="Simpan">
            </div>
        </form>
    </div>
</body>

</html>