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

// File JSON untuk menyimpan data inflasi 12 bulan terakhir
$jsonFile = 'data_inflasi.json';

// Baca data yang ada dalam file JSON
$existingData = [];
if (file_exists($jsonFile)) {
    $jsonContent = file_get_contents($jsonFile);
    $existingData = json_decode($jsonContent, true);
}

// Ambil data 12 bulan terakhir dari database
$sql = "SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, inflasi, inflasi_tahun_kalender, inflasi_tahun_ke_tahun 
       FROM data_inflasi ORDER BY tanggal DESC LIMIT 12"; // Ambil 12 entri terakhir
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Tambahkan entri baru ke existingData jika tidak ada
        if (!in_array($row, $existingData)) {
            array_unshift($existingData, $row);
        }
    }

    // Simpan hanya 12 bulan terakhir dalam existingData
    $existingData = array_slice($existingData, 0, 12);

    // Simpan existingData ke file JSON
    file_put_contents($jsonFile, json_encode($existingData));
}

// Tutup koneksi setelah selesai
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Inflasi Terbaru</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        /* Gaya untuk animasi bounce */
        @keyframes bounce-in {
            0% {
                transform: scale(0.5);
                /* Skala lebih kecil di awal */
                opacity: 0;
                /* Transparan di awal */
            }

            60% {
                transform: scale(1.1);
                /* Lebih besar dari ukuran normal */
                opacity: 1;
                /* Meningkatkan opacity */
            }

            80% {
                transform: scale(0.9);
                /* Sedikit lebih kecil */
            }

            100% {
                transform: scale(1);
                /* Kembali ke ukuran normal */
            }
        }

        /* Gaya untuk tabel */
        .bounce-table {
            border-collapse: collapse;
            /* Menggabungkan border */
            width: 85%;
            /* Lebar tabel 85% */
            margin-left: auto;
            /* Memposisikan di tengah */
            margin-right: auto;
            /* Memposisikan di tengah */
            font-family: Arial, sans-serif;
            /* Jenis font */
            animation: bounce-in 1s ease;
            /* Terapkan animasi bounce-in */
        }


        /* Gaya untuk tabel */
        table {
            border-collapse: collapse;
            /* Menggabungkan border */
            width: 85%;
            /* Lebar tabel 85% */
            margin-left: auto;
            /* Memposisikan di tengah */
            margin-right: auto;
            /* Memposisikan di tengah */
            font-family: Arial, sans-serif;
            /* Jenis font */
        }

        th,
        td {
            border: 1px solid #ddd;
            /* Border tabel */
            padding: 12px;
            /* Padding dalam tabel */
            text-align: center;
            /* Posisikan teks di tengah */
        }

        th {
            background-color: #f2f2f2;
            /* Warna latar belakang untuk header */
            color: #333;
            /* Warna teks untuk header */
            font-weight: bold;
            /* Teks tebal untuk header */
        }

        tr:nth-child(odd) {
            background-color: #f9f9f9;
            /* Warna latar belakang untuk baris ganjil */
        }

        tr:hover {
            background-color: #e2e2e2;
            /* Warna saat hover pada baris */
        }

        /* Gaya untuk tombol delete */
        .delete-button {
            background-color: red;
            /* Warna tombol merah */
            color: white;
            /* Warna teks putih */
            padding: 10px 20px;
            /* Padding untuk tombol */
            border: none;
            /* Hilangkan border */
            border-radius: 5px;
            /* Sudut tombol melengkung */
            cursor: pointer;
            /* Gaya kursor */
            margin-right: 10px;
            display: inline-block;
            /* Tombol tetap horizontal di tampilan desktop */

        }

        .delete-button:hover {
            background-color: darkred;
            /* Warna saat hover */
        }

        /* Gaya untuk tombol update */
        .update-button {
            background-color: blue;
            /* Warna tombol biru */
            color: white;
            /* Warna teks putih */
            padding: 10px 20px;
            /* Padding untuk tombol */
            border: none;
            /* Hilangkan border */
            border-radius: 5px;
            /* Sudut tombol melengkung */
            cursor: pointer;
            /* Gaya kursor */
            margin-left: 10px;
            display: inline-block;
            /* Tombol tetap horizontal di tampilan desktop */

        }

        .update-button:hover {
            background-color: darkblue;
            /* Warna saat hover */
        }

        /* Definisikan animasi untuk garis bawah */
        @keyframes expand-underline {
            from {
                width: 0%;
                /* Mulai dari garis bawah dengan lebar 0% */
            }

            to {
                width: 100%;
                /* Animasi ke garis bawah dengan lebar 100% */
            }
        }

        /* Gaya untuk elemen h1 dengan garis bawah yang dianimasikan */
        .centered-underline {
            position: relative;
            /* Posisi relatif untuk elemen h1 */
            text-align: center;
            /* Posisi teks di tengah */
            display: inline-block;
            /* Membuat garis bawah sesuai dengan teks */
            padding-bottom: 10px;
            /* Ruang di bawah teks */
            margin-bottom: 60px;
            /* Ruang di bawah h1 */
            margin-top: 40px;
            /* Ruang di atas h1 */
        }

        /* Garis bawah dengan animasi, dipusatkan secara horizontal */
        .centered-underline::after {
            content: '';
            /* Elemen semu untuk garis bawah */
            position: absolute;
            /* Posisi absolut untuk garis */
            bottom: 0;
            /* Posisi di bawah elemen h1 */
            left: 50%;
            /* Mulai dari tengah */
            transform: translateX(-50%);
            /* Menggeser ke tengah */
            height: 2px;
            /* Tinggi garis bawah */
            background-color: black;
            /* Warna garis bawah */
            width: 0;
            /* Lebar awal garis bawah adalah 0% */
            animation: expand-underline 2s forwards;
            /* Animasi untuk garis bawah */
        }

        @media (max-width: 767px) {

            .delete-button,
            .update-button {
                display: block;
                /* Tombol menjadi vertikal di tampilan mobile */
                margin: 0 auto;
                /* Mengatur margin untuk membuat tombol berada di tengah kolom */
                margin-bottom: 10px;
                /* Beri jarak antara tombol */
            }

            .table-container {
                overflow-x: auto;
                /* Mengatur overflow agar tabel dapat digulir ke samping */
            }
        }
    </style>
    <script>
        $(document).ready(function() {
            $(".delete-button").click(function() {
                var bulan = $(this).data("bulan");
                var confirmDelete = confirm("Apakah Anda yakin ingin menghapus data untuk " + bulan + "?");

                if (confirmDelete) {
                    $.ajax({
                        url: "delete_grafik.php", // Endpoint untuk delete
                        method: "POST",
                        data: {
                            bulan: bulan
                        }, // Kirim bulan untuk dihapus
                        success: function(response) {
                            alert(response); // Umpan balik untuk pengguna
                            location.reload(); // Refresh setelah delete
                        },
                        error: function(err) {
                            console.error("Error saat menghapus data:", err);
                            alert("Gagal menghapus data. Coba lagi nanti.");
                        }
                    });
                }
            });

            $(".update-button").click(function() {
                var bulan = $(this).data("bulan");
                var inflasi = prompt("Masukkan inflasi bulanan baru untuk " + bulan);
                var inflasi_tahun_kalender = prompt("Masukkan inflasi tahun kalender baru");
                var inflasi_tahun_ke_tahun = prompt("Masukkan inflasi tahun ke tahun baru");

                if (inflasi && inflasi_tahun_kalender && inflasi_tahun_ke_tahun) {
                    $.ajax({
                        url: "update_grafik.php", // Endpoint untuk update
                        method: "POST",
                        data: {
                            bulan: bulan,
                            inflasi: inflasi,
                            inflasi_tahun_kalender: inflasi_tahun_kalender,
                            inflasi_tahun_ke_tahun: inflasi_tahun_ke_tahun
                        },
                        success: function(response) {
                            alert(response); // Umpan balik untuk pengguna
                            location.reload(); // Refresh setelah update
                        },
                        error: function(err) {
                            console.error("Error saat memperbarui data:", err);
                            alert("Gagal memperbarui data. Coba lagi nanti.");
                        }
                    });
                }
            });
        });
    </script>
</head>

<body>

    <div style="text-align: center;"> <!-- Memusatkan konten secara horizontal -->
        <!-- Gunakan kelas 'centered-underline' untuk h1 -->
        <h1 class="centered-underline">Data Inflasi Terbaru</h1>
    </div>

    <div class="table-container">
        <!-- Tabel menampilkan 12 data inflasi terbaru -->
        <!-- Tabel dengan animasi bounce-in -->
        <table class="bounce-table" id="tab" border="1" cellpadding="5">
            <tr>
                <th>Bulan</th>
                <th>Inflasi Bulanan</th>
                <th>Inflasi Tahun Kalender</th>
                <th>Inflasi Tahun ke Tahun</th>
                <th>Aksi</th>
            </tr>

            <?php
            // Tampilkan semua 12 entri terbaru
            foreach ($existingData as $data) {
                echo "<tr>";
                echo "<td>" . $data['bulan'] . "</td>";
                echo "<td>" . $data['inflasi'] . "</td>";
                echo "<td>" . $data['inflasi_tahun_kalender'] . "</td>";
                echo "<td>" . $data['inflasi_tahun_ke_tahun'] . "</td>";
                echo "<td>";
                echo '<button class="delete-button" data-bulan="' . $data['bulan'] . '">Delete</button>'; // Tombol delete
                echo '<button class="update-button" data-bulan="' . $data['bulan'] . '">Update</button>'; // Tombol update
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>