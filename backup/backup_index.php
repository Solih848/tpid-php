<?php
include 'koneksi.php';

$query = "SELECT * FROM barang ORDER BY tanggal DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Halaman Beranda</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="website icon" type="png" href="icon/Logo.png">

    <style>
        .card {
            width: 14rem; 
            margin: 0.5rem; 
            text-align: center;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            border-radius: 15px;
        }

        .card-img-top {
            width: 100%; 
            height: 140px; 
            object-fit: cover; 
            border-top-left-radius: 15px; 
            border-top-right-radius: 15px; 
        }

        .card-body {
            padding: 1rem; 
        }

        .card-title {
            font-size: 1rem; 
            font-weight: bold;
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
            position: relative;
            width: 100%;
            overflow: hidden;
            margin-bottom: -250px; /* Mengurangi margin-top agar slider tidak tertutup oleh navbar */
            padding: 0px;
        }
        .slider {
            position: relative;
            display: flex;
            transition: transform 0.8s ease-in-out; /* Mengubah durasi dan jenis transisi */
            width: 300%; /* Lebar total slider */
        }

        .slider-controls {
            position: absolute; /* Membuat posisi absolut untuk tombol navigasi */
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        #slide {
            flex: 0 0 33.33%; /* Lebar slide 1/3 dari lebar viewport */
            position: relative; /* Membuat posisi relatif untuk tombol navigasi */
        }

        #slide img {
            width: 100%; /* Menggunakan viewport width untuk gambar agar memenuhi lebar layar */
            height: 64%; /* Menggunakan viewport height untuk gambar agar memenuhi tinggi layar */
            object-fit: cover; /* Memastikan gambar memenuhi ruang tanpa merubah aspek ratio */
        }


        .tmblsebelum,
        .tmblsesudah {
            background-color: red;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            position: relative;
            margin-top: -200px ;
        }

        .tmblsebelum::before,
        .tmblsesudah::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0;
            height: 0;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            border-right: 15px solid white;
        }

        .tmblsesudah::before {
            transform: translate(-50%, -50%) rotate(180deg);
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
        h1{
            text-align: center;
        }

        #cardContainer{
            margin-left: 0px;
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
            /* Menghilangkan efek zoom saat tombol disorot */
            transform: scale(1);
        }



    </style>
</head>

<body>

<?php include'navbar.php';?>


    <div class="slider-container">
        <div class="slider">
            <div class="slide" id="slide">
                <img src="slider/kuliner_1.jpg" alt="Gambar 1">
            </div>
            <div class="slide" id="slide">
                <img src="slider/kuliner_2.jpg" alt="Gambar 2">
            </div>
            <div class="slide" id="slide">
                <img src="slider/kuliner_3.jpg" alt="Gambar 3">
            </div>
        </div>
        <div class="slider-controls">
            <button class="tmblsebelum"></button>
            <button class="tmblsesudah"></button>
        </div>
    </div>

<div class="container">
    <h1 class="mt-5 mb-4">Sistem Informasi Sembako</h1><br>
<div id="carouselExampleControls" class="carousel slide" >

            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>Sebelumnya</a>

            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>Selanjutnya</a>

    <div class="carousel-inner">
        <div class="form-filter">
        <form method="get">
        <label for="filter_nama_barang">Filter Nama Barang:</label>
        <select id="filter_nama_barang" name="filter_nama_barang">
            <option value="">Semua Barang</option>
            <option value="beras">Beras</option>
            <option value="gula">Gula</option>
            <option value="minyak goreng">Minyak Goreng</option>
        </select>

        <label for="filter_nama_pasar">Filter Nama Pasar:</label>
        <select id="filter_nama_pasar" name="filter_nama_pasar">
            <option value="">Semua Pasar</option>
            <option value="Pasar A">Pasar A</option>
            <option value="Pasar B">Pasar B</option>
        </select>
        <button type="submit">Filter</button>
        <a href="index.php">
          <button>Reset</button>
        </a>
    </form>
        </div>

            <div class="row " id="cardContainer">
            <?php
            $count = 0;
            $index = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $filter_nama_barang = isset($_GET['filter_nama_barang']) ? $_GET['filter_nama_barang'] : '';
                $filter_nama_pasar = isset($_GET['filter_nama_pasar']) ? $_GET['filter_nama_pasar'] : '';

                if (($filter_nama_barang == '' || strtolower($row['nama_barang']) == strtolower($filter_nama_barang)) && ($filter_nama_pasar == '' || strtolower($row['nama_pasar']) == strtolower($filter_nama_pasar))) {
                    if ($count % 12 == 0) {
                        echo '<div class="carousel-item' . ($index == 0 ? ' active' : '') . '">';
                        echo '<div class="row">';
                    }
                    echo '<div class="col-lg-3 col-md-4 col-sm-6 mb-4">';
                    echo '<div class="card">';
                    echo '<img class="card-img-top" src="http://localhost/sembako/uploads/' . $row['foto_produk'] . '" alt="' . $row['nama_barang'] . '">';
                    echo '<div class="card-body">';
                    echo '<p class="card-text">' . $row['tanggal'] . '</p>';
                    echo '<h5 class="card-title">' . $row['nama_barang'] . '</h5>';
                    echo '<p class="card-text">Pasar: ' . $row['nama_pasar'] . '</p>';
                    echo '<p class="card-text">Harga: Rp ' . number_format($row['harga'], 0, ',', '.') . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    if ($count % 12 == 11) {
                        echo '</div>';
                        echo '</div>';
                        $index++;
                    }
                    $count++;
                }
            }
            if ($count % 12 != 0) {
                echo '</div>';
                echo '</div>';
            }
            ?>


        </div>

    </div>
    <ol class="carousel-indicators">
        <?php
        $total_items = mysqli_num_rows($result);
        $total_slides = ceil($total_items / 12);
        for ($i = 0; $i < $total_slides; $i++) {
            echo '<li data-target="#carouselExampleControls" data-slide-to="' . $i . '" ' . ($i == 0 ? 'class="active"' : '') . '>' . ($i + 1) . '</li>';
        }
        ?>
    </ol>
</div>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
function cariBarang() {
    var input, filter, cardContainer, card, i, cardTitle;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    cardContainer = document.getElementById("cardContainer");
    card = cardContainer.getElementsByClassName("col-lg-3");

    for (i = 0; i < card.length; i++) {
        cardTitle = card[i].querySelector(".card-title");
        if (cardTitle.innerText.toUpperCase().indexOf(filter) > -1) {
            card[i].style.display = "block"; 
        } else {
            card[i].style.display = "none"; 
        }
    }
}

document.getElementById("searchInput").addEventListener("keyup", cariBarang);


    document.getElementById("searchInput").addEventListener("keyup", cariBarang);
</script>

    <script>
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
</body>
<?php include'footer.php';?>

</html>