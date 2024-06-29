<?php
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

$sql = "SELECT tanggal, inflasi, inflasi_tahun_kalender, inflasi_tahun_ke_tahun FROM data_inflasi ORDER BY tanggal DESC LIMIT 1";
try {
    $stmt = $koneksi->query($sql);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$bulan = array(
    'January' => 'Januari',
    'February' => 'Februari',
    'March' => 'Maret',
    'April' => 'April',
    'May' => 'Mei',
    'June' => 'Juni',
    'July' => 'Juli',
    'August' => 'Agustus',
    'September' => 'September',
    'October' => 'Oktober',
    'November' => 'November',
    'December' => 'Desember'
);

// Membaca penjelasan dari file JSON
$json_file_path = 'inflasi_text.json';
$json_data = file_get_contents($json_file_path);
$penjelasan = json_decode($json_data, true);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TPID | Info Inflasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="website icon" href="icon/Logo.png?v=<?php echo time(); ?>">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        #conn {
            margin-bottom: 150px;
        }

        #aku {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }


        .card-container {
            display: flex;
            margin-top: 20px;
        }


        .card {
            background-color: #ffe6e6;
            color: #000;
            /* Ubah warna teks ke hitam */
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: calc(100% - 50px);
            text-align: center;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 30px;
            overflow: hidden;
            /* Hapus atau komentar properti overflow */
            height: 330px;
            /* Hapus atau komentari  */
        }


        .card-container .card {
            margin: 10px;
            width: calc(100% - 20px);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
            background-color: #F3F8FF;
            /* Tetapkan warna latar belakang yang sama saat dihover */
        }

        .card .icon {
            width: 100px;
            height: auto;
            background-color: #FFFFFF;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
        }

        .card:hover .icon {
            background-color: #F3F8FF;
        }

        .card .icon i {
            color: #365486;
            font-size: 24px;
        }

        .judul-besar {
            font-size: 30px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-top: -30px;
        }

        .judul-kecil {
            font-size: 16px;
        }

        .card h3 {
            color: #000;
            font-size: 22px;
        }

        .card p {
            color: #000;
        }

        .explanation p {
            margin-top: 5px;
            color: #888888;
        }

        .table-content {
            margin-top: 0px;

        }

        @media only screen and (min-width: 10px) and (max-width: 600px) {

            .card-container {
                flex-direction: column;
            }

            .content {
                margin-bottom: -990px;
            }

            .card {
                overflow: hidden;
                /* Hapus atau komentar properti overflow */
                min-height: 330px;
                /* Hapus atau komentari  */
            }
        }

        table {
            border-collapse: collapse;
            /* Menggabungkan batas antar sel */
            margin: 20px auto;
            /* Pusatkan tabel dengan margin auto */
            width: 90%;
            /* Lebar tabel 100% dari container */
            font-family: 'Poppins', sans-serif;
            /* Jenis font */
            border: 1px solid #ccc;
            /* Border di tepi tabel */
            margin-bottom: 50px;
        }

        table th {
            background-color: #333A73;
            /* Warna latar belakang header */
            color: white;
            /* Warna teks header */
            padding: 10px;
            /* Padding dalam sel */
            text-align: center;
            /* Penempatan teks */
            border-bottom: 2px solid #ddd;
            /* Batas bawah header */
        }

        table tr {
            border-bottom: 1px solid #ddd;
            /* Batas bawah baris */
            transition: background-color 0.3s;
            /* Efek transisi untuk perubahan warna */
        }

        /* Gaya saat baris di-hover */
        table tr:hover {
            background-color: #f1f1f1;
            /* Warna saat di-hover */
        }

        /* Gaya untuk sel tabel */
        table td {
            padding: 10px;
            /* Padding dalam sel */
            text-align: center;
            /* Penempatan teks */
        }

        /* Gaya untuk sel ganjil dan genap untuk membuat striping */
        table tr:nth-child(odd) {
            background-color: #f2f2f2;
            /* Warna latar belakang untuk baris ganjil */
        }

        table tr:nth-child(even) {
            background-color: #ffffff;
            /* Warna latar belakang untuk baris genap */
        }

        /* Gaya untuk meningkatkan keterbacaan */
        table {
            box-shadow: 0px 4px 10px 0px rgba(0, 0, 0, 0.1);
            /* Bayangan lembut di sekitar tabel */
            border-radius: 5px;
            /* Batas melengkung */
            overflow: hidden;
            /* Untuk menjaga bayangan */
        }

        /* Gaya saat baris di-hover, dengan latar belakang hitam dan teks putih */
        table tr:hover {
            background-color: #ccc;
            ;
            /* Warna saat di-hover */
            color: black;
            /* Warna teks saat di-hover */
        }

        @media only screen and (max-width: 800px) {

            table {
                margin-bottom: 60px;
                width: 90%;
                /* Lebar tabel 100% dari container */
            }


            /* Gaya untuk sel tabel */
            table td {
                padding: 10px;
                /* Padding dalam sel */
                font-size: 0.8em;
                text-align: center;
                /* Penempatan teks */
            }

            /* Gaya untuk header tabel */
            table th {
                background-color: #333A73;
                /* Warna latar belakang header */
                color: white;
                /* Warna teks header */
                padding: 10px;
                /* Padding dalam sel */
                text-align: center;
                /* Penempatan teks */
                border-bottom: 2px solid #ddd;
                /* Batas bawah header */
                font-size: 0.8em;
            }

            /* Gaya untuk kolom pertama dalam baris header */
            th:first-child {
                width: 25%;
                /* Lebar yang lebih besar untuk kolom pertama */
            }

        }

        /* ANIMASI SCROLL*/
        .hidden {
            opacity: 0;
            /* Tidak terlihat pada awalnya */
            transform: translateY(50px);
            /* Gerakan ke bawah untuk efek animasi */
        }

        .fade-in {
            animation: fadeInUp 1s ease forwards;
            /* Animasi saat terlihat */
        }

        /* Keyframe untuk animasi "fade-in" dari bawah */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                /* Mulai dengan tidak terlihat */
                transform: translateY(65px);
                /* Mulai dari bawah */
            }

            to {
                opacity: 1;
                /* Berakhir dengan terlihat */
                transform: translateY(0);
                /* Kembali ke posisi awal */
            }
        }

        /* Menerapkan animasi pada kelas header */
        .header {
            text-align: center;
            padding: 20px;
        }

        /* Menerapkan animasi bounceIn ke judul-besar dan judul-kecil */
        .judul-besar,
        .judul-kecil {
            animation: bounceIn 1s;
            animation-fill-mode: forwards;
        }
    </style>
</head>

<body id="aku">
    <?php include 'navbar.php'; ?>

    <div class="header" style="margin-top: 150px;">
        <h1 class="judul-besar">Data Inflasi</h1>
    </div>
    <div class="container" id="conn">
        <div class="card-container">
            <div class="card" id="it">
                <?php if ($data && $data['inflasi'] != '') : ?>
                    <h3><?php echo str_replace(array_keys($bulan), array_values($bulan), date('F Y', strtotime($data['tanggal']))); ?></h3>
                    <div class="icon"><i class="fas fa-chart-line"></i></div>
                    <div class="data-content">
                        <p>Inflasi Bulanan (M-to-M): <?php echo $data['inflasi'] . '%'; ?></p>
                    </div>
                    <div class="explanation">
                        <p><?php echo htmlspecialchars($penjelasan['penjelasan_1']); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card hidden" id="fik">
                <?php if ($data && $data['inflasi_tahun_kalender'] != '') : ?>
                    <h3><?php echo str_replace(array_keys($bulan), array_values($bulan), date('F Y', strtotime($data['tanggal']))); ?></h3>
                    <div class="icon"><i class="fas fa-chart-line"></i></div>
                    <div class="data-content">
                        <p>Inflasi Tahun Kalender (Y-to-D): <?php echo $data['inflasi_tahun_kalender'] . '%'; ?></p>
                    </div>
                    <div class="explanation">
                        <p><?php echo htmlspecialchars($penjelasan['penjelasan_2']); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card hidden" id="dim">
                <?php if ($data && $data['inflasi_tahun_ke_tahun'] != '') : ?>
                    <h3><?php echo str_replace(array_keys($bulan), array_values($bulan), date('F Y', strtotime($data['tanggal']))); ?></h3>
                    <div class="icon"><i class="fas fa-chart-line"></i></div>
                    <div class="data-content">
                        <p>Inflasi Tahunan (Y-on-Y): <?php echo $data['inflasi_tahun_ke_tahun'] . '%'; ?></p>
                    </div>
                    <div class="explanation">
                        <p><?php echo htmlspecialchars($penjelasan['penjelasan_3']); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php
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

    $sql = "SELECT id, tanggal, inflasi, inflasi_tahun_kalender, inflasi_tahun_ke_tahun FROM data_inflasi ORDER BY tanggal DESC";
    try {
        $stmt = $koneksi->query($sql);
        $data_inflasi = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>

    <div class="table-content">
        <!-- Buat tabel HTML dari data MySQL -->
        <table class='hidden table-container' id='my-table'> <!-- Ubah ID menjadi kelas dan tambahkan kelas baru 'table-container' -->
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Inflasi Bulan Ke Bulan</th>
                    <th>Inflasi Tahun ke Tahun</th>
                    <th>Inflasi Tahun Kalender</th>
            </thead>
            <tbody>
                </tr>
                <?php foreach ($data_inflasi as $data) { ?>
                    <tr>
                        <td><?php echo str_replace(array_keys($bulan), array_values($bulan), date('F Y', strtotime($data['tanggal']))); ?></td>

                        <td><?php echo $data['inflasi']; ?></td>
                        <td><?php echo $data['inflasi_tahun_ke_tahun']; ?></td>
                        <td><?php echo $data['inflasi_tahun_kalender']; ?></td>
                    </tr>
            </tbody>
        <?php } ?>
        </table>
    </div>



    <!-- end Tabel grafik dari json -->
    <!--ANIMASI SCROLL-->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in'); // Tambahkan kelas "fade-in" saat elemen terlihat
                        observer.unobserve(entry.target); // Hentikan pengamatan setelah animasi
                    }
                });
            }, {
                threshold: 0.5 // Hanya memicu ketika 100% elemen terlihat
            });
            observer.observe(document.getElementById('my-table')); // Mengamati tabel harga
        });
    </script>



    <!--ANIMASI SCROLL-->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in'); // Tambahkan kelas "fade-in" saat elemen terlihat
                        observer.unobserve(entry.target); // Hentikan pengamatan setelah animasi
                    }
                });
            }, {
                threshold: 0.5 // Hanya memicu ketika 100% elemen terlihat
            });
            observer.observe(document.getElementById('it')); // Mengamati tabel harga
        });
    </script>

    <!--ANIMASI SCROLL-->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in'); // Tambahkan kelas "fade-in" saat elemen terlihat
                        observer.unobserve(entry.target); // Hentikan pengamatan setelah animasi
                    }
                });
            }, {
                threshold: 0.5 // Hanya memicu ketika 100% elemen terlihat
            });
            observer.observe(document.getElementById('fik')); // Mengamati tabel harga
        });
    </script>

    <!--ANIMASI SCROLL-->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in'); // Tambahkan kelas "fade-in" saat elemen terlihat
                        observer.unobserve(entry.target); // Hentikan pengamatan setelah animasi
                    }
                });
            }, {
                threshold: 0.5 // Hanya memicu ketika 100% elemen terlihat
            });
            observer.observe(document.getElementById('dim')); // Mengamati tabel harga
        });
    </script>
    <?php include 'footer.php'; ?>

</body>

</html>