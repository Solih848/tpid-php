<?php
$db = new PDO('mysql:host=localhost;dbname=sem', 'root', '');

$query_subjudul = 'SELECT * FROM sub_judul_produk ORDER BY judul_produk ASC, nama_bahan_pokok ASC';
$stmt_subjudul = $db->query($query_subjudul);
$data_subjudul = $stmt_subjudul->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
include 'koneksi_sembako.php';


if (isset($_POST['cari'])) {
    $tanggal = $_POST['tanggal'];
    $nama_pasar = $_POST['nama_pasar'];
    $query = "SELECT * FROM sub_judul_produk WHERE tanggal='$tanggal' AND nama_pasar='$nama_pasar' ORDER BY tanggal DESC";
    $stmt = $db->query($query);
    $data_subjudul = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else if (isset($_POST['tampilkan_semua'])) {
    $query = "SELECT * FROM sub_judul_produk ORDER BY tanggal DESC";
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TPID Sumenep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@900&display=swap">
    <link rel="website icon" href="icon/Logo.png?v=<?php echo time(); ?>">
    <style>
        /* CSS for loading overlay */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            /* Transparent white background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            /* Pastikan overlay muncul di atas elemen lain */
        }

        /* CSS for loading spinner */
        .spinner {
            width: 70px;
            height: 70px;
            border: 13px dashed #365486;
            /* Ubah ketebalan garis menjadi 3px */
            border-radius: 50%;
            animation: spin 2s linear infinite;
            /* Animasi untuk spinner */
        }

        /* Keyframes for spinner animation */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }


        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .carousel-control-prev,
        .carousel-control-next {
            color: red;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover,
        .carousel-control-prev:focus,
        .carousel-control-next:focus {
            color: red;
        }

        .carousel-control-prev {
            left: -150px;
        }

        .carousel-control-next {
            right: -125px;
        }

        .slider-container {
            margin-top: -20px;
        }

        .slider-container {
            position: relative;
            width: 100%;
            overflow: hidden;
            margin-bottom: -250px;
            padding: 0px;
        }

        .slider {
            position: relative;
            display: flex;
            transition: transform 0.8s ease-in-out;
            width: 300%;
            height: 1000px;
            /* Mengatur tinggi slider menjadi 500px */
            margin-top: 100px;
        }


        #slide {
            flex: 0 0 33.33%;
            position: relative;
        }

        #slide img {
            width: 100%;
            height: 70%;
            object-fit: cover;
        }



        .slider-controls {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .tmblsebelum,
        .tmblsesudah {
            background-color: rgba(0, 0, 0, 0.2);
            /* Hitam transparan */
            border-radius: 50%;
            width: 70px;
            height: 70px;
            position: relative;
            margin-top: -200px;
            margin-left: 10px;
            /* Tambahkan jarak dari sisi kiri */
            margin-right: 10px;
            /* Tambahkan jarak dari sisi kanan */
        }



        /* Untuk panah kanan */
        .tmblsebelum::before {
            content: "\003E";
            /* Kode Unicode untuk panah ke kanan */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(180deg);
            /* Pusatkan dan balikkan arah */
            font-size: 35px;
            /* Atur ukuran font sesuai kebutuhan */
            color: white;
            /* Warna putih */
        }


        /* Untuk panah kiri */
        .tmblsesudah::before {
            content: "\003E";
            /* Kode Unicode untuk panah ke kanan */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* Pusatkan */
            font-size: 35px;
            /* Atur ukuran font sesuai kebutuhan */
            color: white;
            /* Warna putih */
        }

        .tmblsebelum:hover,
        .tmblsesudah:hover {
            background-color: rgba(0, 0, 0, 0.8);
            /* Hitam transparan */
        }

        button {
            padding: 10px;
            margin: 0 10px;
            border: none;
            background-color: transparent;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        button:hover {
            transform: scale(1.2);
        }

        h1 {
            text-align: center;
        }

        #filter_nama_barang {
            width: 200px;
            margin-right: 10px;
        }

        #filter_nama_pasar {
            width: 200px;
            margin-right: 10px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 5px 7px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a button {
            background-color: #f44336;
            color: white;
            padding: 5px 7px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        button[type="submit"]:hover,
        a button:hover {
            transform: scale(1);
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 30px;
            text-align: center;
            /* Teks berada di tengah secara horizontal */
        }

        th,
        td {
            padding: 10px;
            vertical-align: middle;
            /* Teks berada di tengah secara vertikal */
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd;
            font-size: 0.9em;
        }

        th:first-child,
        td:first-child {
            border-left: 1px solid #ddd;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 120px;
            /* Lebar kolom Tanggal */
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 150px;
            /* Lebar kolom Tanggal */
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 190px;
            /* Lebar kolom Tanggal */
        }

        th,
        td {
            padding: 10px;
            vertical-align: middle;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd;
            font-size: 0.9em;
        }

        #cont {
            border: 1px solid #ccc;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin: 20px auto 0;
        }


        /* Style untuk judul */
        .judul-kecil {
            display: inline-block;
            color: #333;
            /* Ubah warna judul sesuai kebutuhan */
            text-align: center;
        }


        .card {
            color: #000;
            /* Ubah warna teks ke hitam */
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 10px auto;
            /* Mengatur margin menjadi auto untuk pusat horizontal */
            width: 360px;
            display: block;
            /* Mengatur tampilan menjadi blok untuk mengambil margin otomatis */
        }


        .card h3 {
            color: #333;
        }

        .data-content p {
            margin: 0;
        }

        .icon {
            font-size: 24px;
            margin-bottom: 10px;
        }

        /* Animasi */
        .animate__animated {
            animation-duration: 1s;
        }

        .animate__bounceIn {
            animation-name: bounceIn;
        }

        @keyframes bounceIn {

            from,
            20%,
            40%,
            60%,
            80%,
            to {
                animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
            }

            0% {
                opacity: 0;
                transform: scale3d(0.3, 0.3, 0.3);
            }

            20% {
                transform: scale3d(1.1, 1.1, 1.1);
            }

            40% {
                transform: scale3d(0.9, 0.9, 0.9);
            }

            60% {
                opacity: 1;
                transform: scale3d(1.03, 1.03, 1.03);
            }

            80% {
                transform: scale3d(0.97, 0.97, 0.97);
            }

            to {
                opacity: 1;
                transform: scale3d(1, 1, 1);
            }
        }

        .card .icon i {
            color: #365486;
            font-size: 24px;
        }

        .card:hover .icon {
            background-color: #F3F8FF;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
            background-color: #F3F8FF;
            /* Tetapkan warna latar belakang yang sama saat dihover */
        }

        .berita {
            text-align: center;
        }


        .contact-info {
            background-color: rgba(128, 128, 128, 0.8);
            color: white;
            padding: 10px;
            border-bottom: 1px solid white;
            position: relative;
            z-index: 1;
            margin-top: -5px;
        }


        @media screen and (min-width: 768px) {
            .slider-container {
                margin-top: -178px;
            }
        }


        /* CSS untuk tampilan mobile */
        @media only screen and (max-width: 768px) and (min-device-width: 320px) and (max-device-width: 1024px) {

            .contact-info {
                background-color: rgba(54, 84, 134, 0.8);
            }

            #name {
                font-size: 12px;
                /* Ukuran font yang diinginkan */
            }


            /* Atur ukuran ikon untuk perangkat mobile */
            .contact-info i {
                font-size: 12px;
                /* Sesuaikan dengan ukuran yang diinginkan */
            }

            /* Atur ukuran teks "Lokasi Anda" untuk perangkat mobile */
            .contact-info .col {
                font-size: 12px;
                /* Sesuaikan dengan ukuran yang diinginkan */
            }

            .tmblsebelum,
            .tmblsesudah {
                display: none;
                /* menyembunyikan tombol di perangkat mobile */
            }

            .slider-container {
                margin-bottom: -110px;
                /* Sesuaikan tinggi slider sesuai kebutuhan */
            }

            .slider {
                height: 300px;
                /* Sesuaikan tinggi slider sesuai kebutuhan */
            }

            table {
                overflow-x: auto;
                display: block;
            }

            th,
            td {
                min-width: 120px;
            }

            th:first-child,
            td:first-child {
                min-width: 60px;
            }

            th:nth-child(2),
            td:nth-child(2) {
                width: 120px;
                /* Lebar kolom Tanggal */
            }

            th:nth-child(3),
            td:nth-child(3) {
                min-width: 150px;
                /* Lebar kolom Tanggal */
            }

            th:nth-child(4),
            td:nth-child(4) {
                min-width: 190px;
                /* Lebar kolom Tanggal */
            }

            .judul-row td {
                min-width: auto;
            }

            .header {
                padding-top: 20px;
                /* Menyesuaikan padding untuk header */
            }

            #harga-tabel {
                padding: 10px;
                /* Menyesuaikan padding untuk tabel */
            }

            /* Ukuran form dan tombol yang lebih kecil */
            input[type="date"],
            select,
            button {
                width: auto;
                padding: 2px 6px;
                font-size: 0.8em;
                /* Ukuran font yang lebih kecil */
            }

            /* Ukuran font tombol "Tampilkan Semua" dan "Cari" */
            button[name="cari"],
            button[name="tampilkan_semua"] {
                margin-top: 20px;
                padding: 5px 10px;
                background-color: dodgerblue;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 0.8em;
                /* Ukuran font yang lebih kecil */
                display: inline-block;
                /* Jadikan tombol sebagai blok agar bisa diatur lebar dan posisi */
                margin: 15px 0 auto 5px;
                /* Pusatkan tombol dengan margin auto */
            }

            th:first-child,
            td:first-child {
                border-left: 1px solid #ddd;
            }

            h2 {
                font-size: 1.5rem !important;
                /* Ubah ukuran teks judul tabel menjadi 1rem */
            }

        }

        /* Definisikan animasi */
        @keyframes underlineAnimation {
            from {
                width: 0;
                left: 50%;
            }

            to {
                width: 100%;
                left: 0;
            }
        }

        /* Gaya untuk elemen dengan garis bawah animasi */
        .animated-underline {
            position: relative;
            display: inline-block;
            padding-bottom: 5px;
            border-bottom: 2px solid transparent;
            /* Gunakan warna transparan saat animasi belum dimulai */
        }

        /* Garis bawah animasi yang diaktifkan dengan class tambahan */
        .animated-underline.activated::after {
            content: '';
            position: absolute;
            bottom: 0;
            height: 2px;
            background-color: #000;
            transition: width 0.5s, left 0.5s;
            animation: underlineAnimation 0.5s forwards;
        }

        @media (max-width: 768px) {
            .slider {
                height: 500px;
                /* Tinggi tetap untuk perangkat dengan lebar kurang dari 768px */
            }
        }

        @keyframes bounce-in {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            50% {
                transform: scale(1.1);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }

        .bounce-in {
            animation: bounce-in 2s ease;
        }

        .judul-kecil {
            opacity: 0;
            /* Teks tidak terlihat awalnya */
            transition: opacity 0.9s;
            /* Transisi untuk membuat teks terlihat */
        }

        .bounce-in {
            opacity: 1;
            /* Saat animasi, teks muncul */
        }

        /* Media query untuk tampilan mobile */
        @media (max-width: 1000px) {
            .col-md-4 {
                display: block;
                /* Pada tampilan mobile, kartu berjajar secara vertikal */
            }

            .card {
                width: 100%;
                /* Mengatur lebar menjadi 100% untuk mengisi lebar layar pada mobile */
                margin: 10px auto;
                /* Mengatur margin menjadi auto untuk pusat horizontal */
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

        .graf {
            margin-top: 30px;
            margin-bottom: 60px;
        }

        @media (max-width: 1000px) {

            /* Gaya untuk teks animasi */
            .cool-text {
                top: 50px;
                /* Jarak dari atas */
                left: 50%;
                /* Pusatkan secara horizontal */
                padding: 30px;
                /* Padding */
                margin-bottom: -115px;
                margin-top: -10px;
                font-family: 'Raleway', sans-serif;
                /* Gunakan font Raleway */
                font-weight: 900;
                /* Font tebal */
                font-size: 41px;
                /* Ukuran font besar */
                text-transform: uppercase;
                /* Semua huruf kapital */
                text-align: center;
                /* Rata tengah */
                background: linear-gradient(45deg, #00c6ff, #333A73, #0B60B0, #00c6ff);
                /* Gradien biru */
                background-size: 200% 200%;
                /* Untuk membuat animasi gradien bekerja */
                background-clip: text;
                /* Gradien hanya terlihat pada teks */
                -webkit-background-clip: text;
                /* Kompatibilitas untuk WebKit */
                color: transparent;
                /* Warna teks transparan agar latar belakang terlihat */
                animation: blue-shift 5s infinite;
                /* Animasi gradien */
                z-index: 9999;
                /* Pastikan elemen di atas elemen lain */
            }

            /* Animasi untuk teks */
            @keyframes blue-shift {
                0% {
                    background-position: 0% 50%;
                    /* Awal animasi */
                }

                50% {
                    background-position: 100% 50%;
                    /* Tengah animasi */
                }

                100% {
                    background-position: 0% 50%;
                    /* Akhir animasi */
                }
            }
        }
    </style>

    <!-- Pastikan pustaka ini disertakan sebelum grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body>
    <?php include 'navbar.php'; ?>

    <div id="loading-overlay">
        <div class="spinner"></div>
    </div>
    <!-- Informasi lokasi, email, dan nomor telepon -->
    <div class="contact-info">
        <div class="container">
            <div class="row text-center" id="hub" style="padding-top: 80px;">
                <!-- Ubah kolom menjadi col -->
                <div class="col" id="lokasi" style="font-family: 'Roboto', sans-serif;">
                    <i class="fas fa-map-marker-alt"></i> Sumenep - Madura
                </div>
                <!-- Ubah kolom menjadi col -->
                <div class="col" id="telepon" style="font-family: 'Roboto', sans-serif;">
                    <i class="fas fa-phone-alt"></i> +6287712377783
                </div>
                <!-- Ubah kolom menjadi col -->
                <div class="col-lg-4 col-md-12 col-sm-12" id="name" style="font-family: 'Roboto', sans-serif;">
                    <i class="fas fa-envelope"></i> kominfo.sumenep@gmail.com
                </div>
            </div>
        </div>
    </div>
    <div class="cool-text">TPID SUMENEP</div>



    <div class="slider-container">
        <!-- Perbarui penampilan gambar slider -->
        <div class="slider">
            <?php
            // Dapatkan daftar gambar slider secara dinamis dari folder slider
            $sliderFolder = 'slider/';
            $files = scandir($sliderFolder);
            $files = array_diff($files, array('.', '..'));

            // Tampilkan gambar slider sesuai dengan file yang ada dalam folder slider
            foreach ($files as $file) {
                // Pastikan file yang ditampilkan adalah file gambar
                if (exif_imagetype($sliderFolder . $file)) {
                    echo "<div class='slide' id='slide'>";
                    echo "<img src='slider/$file' alt='Gambar'>";
                    echo "</div>";
                }
            }
            ?>
        </div>
        <div class="slider-controls">
            <button class="tmblsebelum"></button>
            <button class="tmblsesudah"></button>
        </div>
    </div>

    <div class="graf hidden" id="it">
        <?php
        // Sertakan file grafik.php
        include 'grafik.php';
        ?>
    </div>
    <!-- Komoditi -->
    <?php
    include 'koneksi_sembako.php';

    $query_terbaru = "SELECT * FROM sub_judul_produk ORDER BY tanggal DESC LIMIT 10";
    $stmt_terbaru = $db->query($query_terbaru);
    $data_terbaru = $stmt_terbaru->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container-fluid">
        <div class="container hidden" id="cont">
            <h2 style="text-align: center; border-bottom: 2px solid #000; display: inline-block; margin-top: -20px; padding-top: 20px; padding-bottom:5px">Tabel Harga Terbaru Konsumen</h2>
            <p class="info-text">Harga Rata-Rata Kabupaten Sumenep di Tingkat Konsumen Tanggal <span id="today-date"></span></p>
            <table class="table table-bordered"> <!-- Tambahkan kelas "hidden" -->
                <thead>
                    <tr>
                        <th style="background-color: #365486; color: white;">NO</th>
                        <th style="background-color: #365486; color: white;">TANGGAL</th>
                        <th style="background-color: #365486; color: white;">PASAR</th>
                        <th style="background-color: #365486; color: white;">NAMA BAHAN POKOK</th>
                        <th style="background-color: #365486; color: white;">SATUAN</th>
                        <th style="background-color: #365486; color: white;">HARGA KEMARIN</th>
                        <th style="background-color: #365486; color: white;">HARGA SEKARANG</th>
                        <th style="background-color: #365486; color: white;">PERUBAHAN (Rp)</th>
                        <th style="background-color: #365486; color: white;">PERUBAHAN (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($data_terbaru as $subjudul) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo '<td style="width: 80px;">' . $subjudul['tanggal'] . '</td>';
                        echo "<td>" . $subjudul['nama_pasar'] . "</td>";
                        echo '<td style="width: 180px;">' . $subjudul['nama_bahan_pokok'] . '</td>';
                        echo "<td>" . $subjudul['satuan'] . "</td>";
                        echo "<td>" . number_format($subjudul['harga_kemarin'], 0, ',', '.') . "</td>";
                        echo "<td>" . number_format($subjudul['harga_sekarang'], 0, ',', '.') . "</td>";

                        $perubahan_rp = $subjudul['harga_sekarang'] - $subjudul['harga_kemarin'];
                        $perubahan_persen = ($subjudul['harga_sekarang'] - $subjudul['harga_kemarin']) / $subjudul['harga_sekarang'] * 100;

                        echo "<td>" . number_format($perubahan_rp, 0, ',', '.') . "</td>";
                        echo "<td>" . number_format($perubahan_persen, 2, ',', '.') . "%</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="komoditi.php" class="btn btn-primary btn-block">Selengkapnya</a>
        </div>
    </div>
    <!-- end komoditi -->

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

    ?>


    <div class="container-fluid" id="co" style="padding-bottom: 50px;" style="margin-top:-100px; padding-bottom: 70px; ">
        <div class="header" style="text-align: center;">
            <h2 class="judul-kecil" style="margin-top: 55px;">- Data Inflasi bulanan -</h2>
        </div>

        <div class="card-container animate__animated animate__bounceIn">

            <div class="row justify-content-center" style="margin-top:10px; " id="inflasi">
                <div class="col-md-4 hidden" id="inf">
                    <div class="card text-center" style="padding: 20px; border-radius: 15px;">
                        <h3><?php echo str_replace(array_keys($bulan), array_values($bulan), date('F Y', strtotime($data['tanggal']))); ?></h3>
                        <?php if ($data && $data['inflasi'] != '') : ?>
                            <div class="icon"><i class="fas fa-chart-line"></i></div>
                            <div class="data-content">
                                <p>Inflasi: <?php echo $data['inflasi'] . '%'; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($data && $data['inflasi_tahun_kalender'] != '') : ?>
                    <div class="col-md-4 hidden" id="fik">
                        <div class="card text-center" style="padding: 20px; border-radius: 15px;">
                            <h3><?php echo str_replace(array_keys($bulan), array_values($bulan), date('F Y', strtotime($data['tanggal']))); ?></h3>
                            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                            <div class="data-content">
                                <p>Inflasi Tahun Kalender: <?php echo $data['inflasi_tahun_kalender'] . '%'; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($data && $data['inflasi_tahun_ke_tahun'] != '') : ?>
                    <div class="col-md-4 hidden" id="dim">
                        <div class="card text-center" style="padding: 20px; border-radius: 15px;">
                            <h3><?php echo str_replace(array_keys($bulan), array_values($bulan), date('F Y', strtotime($data['tanggal']))); ?></h3>
                            <div class="icon"><i class="fas fa-chart-bar"></i></div>
                            <div class="data-content">
                                <p>Inflasi Tahun ke Tahun: <?php echo $data['inflasi_tahun_ke_tahun'] . '%'; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>





    <!-- Berita -->
    <?php
    $rss = simplexml_load_file('https://rss.app/feeds/eXBUg8eJATESJyNW.xml');

    if ($rss === false) {
        die('Error: Unable to load RSS feed.');
    }
    ?>

    <div class="container-fluid" style=" padding-top: 50px; padding-bottom: 20px; margin-bottom: 50px;">
        <!-- Judul dengan animasi garis bawah -->
        <h2 class="animated-underline text-center mb-4">Berita Terbaru</h2>
        <div class="row justify-content-center" id="news-container">
            <?php
            $count = 0;
            foreach ($rss->channel->item as $item) :
                if ($count < 3) :
            ?>
                    <div class="col-md-4 news-card hidden">
                        <div class="card mb-4" style="border-radius: 15px;">
                            <div class="card-body">
                                <img src="<?php echo $item->enclosure['url']; ?>" class="card-img-top" style="height: 200px; object-fit: cover" alt="...">
                                <h5 class="card-title"><?php echo $item->title; ?></h5>
                                <a href="<?php echo $item->link; ?>" class="btn btn-primary">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
            <?php
                    $count++;
                endif;
            endforeach;
            ?>
        </div>
        <div class="text-center"> <!-- Tambahkan kelas text-center -->
            <a href="berita.php" class="btn btn-primary">Berita Lainnya <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z" />
                </svg></a>
        </div>
    </div>
    <!--end berita-->

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

    <!-- ANIMASI SCROLL -->
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
                threshold: 0.5 // Hanya memicu ketika 50% elemen terlihat
            });

            const cards = document.querySelectorAll('.news-card'); // Mengambil semua card yang ingin diamati
            cards.forEach((card) => {
                observer.observe(card); // Mengamati setiap card secara individu
            });
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
            observer.observe(document.getElementById('cont')); // Mengamati tabel harga
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
            observer.observe(document.getElementById('inf')); // Mengamati tabel harga
        });
    </script>

    <script>
        document.getElementById('today-date').textContent = new Date().toLocaleDateString();

        document.addEventListener("DOMContentLoaded", function() {
            const slider = document.querySelector(".slider");
            const slides = document.querySelectorAll("#slide");
            const slideWidth = slides[0].clientWidth;
            let currentIndex = 0;

            document.querySelector(".tmblsesudah").addEventListener("click", function() {
                nextSlide();
            });

            document.querySelector(".tmblsebelum").addEventListener("click", function() {
                prevSlide();
            });

            function nextSlide() {
                if (currentIndex < slides.length - 1) {
                    currentIndex++;
                } else {
                    currentIndex = 0;
                }
                updateSlider();
            }

            function prevSlide() {
                if (currentIndex === 0) {
                    currentIndex = slides.length - 1;
                } else {
                    currentIndex--;
                }
                updateSlider();
            }

            function updateSlider() {
                slider.style.transform = `translateX(${-currentIndex * slideWidth}px)`;
            }

            setInterval(nextSlide, 3000);
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Tampilkan aksi loading
        document.getElementById("loading-overlay").style.display = "flex";

        // Sembunyikan aksi loading setelah 5 detik
        setTimeout(function() {
            document.getElementById("loading-overlay").style.display = "none";
        }, 1500); // 5000 milidetik = 5 detik
    </script>

    <script>
        // Intersection Observer dengan threshold untuk mengaktifkan animasi
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    // Aktifkan animasi ketika elemen terlihat
                    entry.target.classList.add('activated');
                    // Hentikan pengamatan setelah animasi dipicu
                    observer.unobserve(entry.target);
                }
            });
        }, {
            rootMargin: '-180px', // Menunda animasi hingga elemen lebih jauh masuk ke tengah layar
            threshold: 0.0 // Threshold rendah untuk mendeteksi dengan margin
        });

        // Mengamati elemen yang ingin dipicu animasinya
        const elementToObserve = document.querySelector('.animated-underline');
        observer.observe(elementToObserve);
    </script>


    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const judulKecil = document.querySelector('.judul-kecil');

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('bounce-in');
                        observer.unobserve(entry.target); // Hentikan observasi setelah animasi
                    }
                });
            });

            observer.observe(judulKecil);
        });
    </script>


</body>
<?php include 'footer.php'; ?>

</html>