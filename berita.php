<?php
$rss = simplexml_load_file('https://rss.app/feeds/eXBUg8eJATESJyNW.xml');

if ($rss === false) {
    die('Error: Unable to load RSS feed.');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" href="icon/Logo.png?v=<?php echo time(); ?>">

    <title>TPID | Berita</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .card {
            margin-bottom: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        /* Animasi garis bawah */
        @keyframes expand-underline {
            from {
                width: 0; /* Lebar awal garis */
            }
            to {
                width: 100%; /* Lebar akhir garis */
            }
        }

        /* Gaya untuk elemen h1 dengan garis bawah dan teks tebal */
        .centered-underline {
            position: relative; /* Posisi relatif untuk elemen h1 */
            text-align: center; /* Posisi teks di tengah */
            display: inline-block; /* Membuat garis bawah sesuai dengan teks */
            padding-bottom: 10px; /* Ruang di bawah teks */
            margin-bottom: 60px; /* Ruang di bawah h1 */
            margin-top: -20px; /* Ruang di atas h1 */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 30px;
            font-weight: bold;
            text-transform: uppercase;
        }


        /* Garis bawah dengan animasi */
        .centered-underline::after {
            content: ''; /* Elemen semu untuk garis bawah */
            position: absolute; /* Posisi absolut untuk garis */
            bottom: 0; /* Posisi di bawah elemen h1 */
            left: 50%; /* Mulai dari tengah */
            transform: translateX(-50%); /* Menggeser ke tengah */
            height: 2.5px; /* Tinggi garis bawah */
            background-color: black; /* Warna garis bawah */
            width: 0; /* Mulai dengan lebar 0 */
            animation: expand-underline 2s forwards; /* Durasi animasi 2 detik */
        }

                /* ANIMASI SCROLL*/
        .hidden {
            opacity: 0; /* Tidak terlihat pada awalnya */
            transform: translateY(50px); /* Gerakan ke bawah untuk efek animasi */
        }

        .fade-in {
            animation: fadeInUp 1s ease forwards; /* Animasi saat terlihat */
        }

        /* Keyframe untuk animasi "fade-in" dari bawah */
        @keyframes fadeInUp {
            from {
                opacity: 0; /* Mulai dengan tidak terlihat */
                transform: translateY(65px); /* Mulai dari bawah */
            }
            to {
                opacity: 1; /* Berakhir dengan terlihat */
                transform: translateY(0); /* Kembali ke posisi awal */
            }
        }

    </style>
    <?php include 'navbar.php'; ?>

</head>
<body>
    <div class="container-fluid text-center" style="margin-top: 125px; margin-bottom: 75px; padding: 20px;">

        <div style="text-align: center;"> <!-- Memusatkan konten secara horizontal -->
            <!-- Gunakan kelas 'centered-underline' untuk h1 -->
            <h1 class="centered-underline">Berita</h1>
        </div>

        <div class="row">
            <?php foreach ($rss->channel->item as $item): ?>
                <div class="col-md-4 news-card hidden">
                    <div class="card">
                        <div class="card-body">
                            <img src="<?php echo $item->enclosure['url']; ?>" class="card-img-top" style="height: 200px; object-fit: cover" alt="...">
                            <h5 class="card-title"><?php echo $item->title; ?></h5>
                            <a href="<?php echo $item->link; ?>" class="btn btn-primary">Baca selengkapnya</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


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


    <?php include 'footer.php'; ?>
</body>
</html>
