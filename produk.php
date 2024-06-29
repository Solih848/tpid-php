<?php
session_start();

if (!isset($_SESSION['username1'])) {
    header('Location: login_admin.php');
    exit();
}
$username = $_SESSION['username1'];

// Sertakan file koneksi
include 'koneksi_coba.php';

// Periksa jika metode permintaan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah input judul_produk sudah tersedia
    if (isset($_POST["judul_produk"])) {
        // Ambil nilai judul_produk dari permintaan POST
        $judulProduk = $_POST["judul_produk"];
        $subJudulProduk = $_POST["sub_judul_produk"];

        // Persiapkan statement SQL untuk memasukkan data ke database
        $sql = "INSERT INTO produk (judul_produk, sub_judul_produk) VALUES ('$judulProduk', '$subJudulProduk')";

        // Jalankan statement SQL
        if (mysqli_query($koneksi, $sql)) {
            // Redirect pengguna kembali ke halaman ini setelah data ditambahkan
            header("Location: produk.php");
            exit(); // Pastikan kode setelah redirect tidak dijalankan
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
        }
    } else {
        echo "Judul produk tidak ditemukan dalam permintaan POST.";
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }


        h2 {
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            font-size: 32px;
            letter-spacing: 2px;
            font-family: 'Roboto', sans-serif;
            color: transparent;
            background: linear-gradient(to right, #64b5f6, #1976d2);
            -webkit-background-clip: text;
            background-clip: text;
        }

        table {
            width: 50%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
            width: 20%;
        }

        table th:last-child {
            width: 15%;
            text-align: center;
        }

        .btn-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-tambah {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            color: #fff;
            background-color: #007bff;
        }

        .btn-tambah:hover {
            background-color: #0056b3;
            filter: brightness(1.0);
        }

        .btn-update {
            background-color: #007bff;
            /* Warna biru untuk tombol Update */
            color: white;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        .btn-update,
        .btn-delete {
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .btn-update:hover,
        .btn-delete:hover {
            filter: brightness(1.0);
        }

        .form-update {
            display: none;
            text-align: center;
            position: absolute;
            width: 30%;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: slideLeft 0.5s ease;
        }

        @keyframes slideLeft {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Animasi untuk menggeser tabel ke kiri saat form update muncul */
        .table-container {
            overflow-x: hidden;
            position: relative;
            transition: transform 0.5s ease;
            /* Animasi transisi untuk penggeseran tabel */
        }

        .table-container.shifted {
            transform: translateX(-18%);
            /* Menggeser tabel ke kiri sejauh lebar form update */
        }

        /* CSS untuk form input tambah */
        .input-tambah {
            width: 66%;
            /* Sesuaikan lebar input dengan kebutuhan */
            padding: 5px;
            /* Sesuaikan padding input dengan kebutuhan */
            margin-bottom: 5px;
            /* Sesuaikan margin bawah input dengan kebutuhan */
            font-size: 14px;
            /* Sesuaikan ukuran font input teks dengan kebutuhan */
        }

        .input-tambah::placeholder {
            color: #ccc;
            /* Ubah warna placeholder sesuai kebutuhan */
            font-size: 14px;
            /* Sesuaikan ukuran font placeholder dengan kebutuhan */
        }

        /* CSS untuk form input update */
        .input-update {
            width: 50%;
            /* Sesuaikan lebar input dengan kebutuhan */
            padding: 6px;
            /* Sesuaikan padding input dengan kebutuhan */
            margin-bottom: 6px;
            /* Sesuaikan margin bawah input dengan kebutuhan */
            font-size: 12px;
            /* Sesuaikan ukuran font input teks dengan kebutuhan */
        }

        .input-update::placeholder {
            color: #999;
            /* Ubah warna placeholder sesuai kebutuhan */
            font-size: 12px;
            /* Sesuaikan ukuran font placeholder dengan kebutuhan */
        }

        .form-tambah {
            text-align: center;
            /* Hapus gaya position, top, dan left */
            margin-top: 20px;
            /* Atur margin-top agar form muncul di bawah tombol "Tambah" */
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease, margin-top 0.5s ease;
            /* Menambahkan animasi untuk muncul */
        }


        .form-tambah.show {
            opacity: 1;
            margin-top: 10px;
            /* Mengubah margin atas untuk penampilan yang lebih baik */
        }

        .input-container {
            padding: 10px;
            /* Tambahkan padding untuk memberikan jarak antara border dengan elemen di dalamnya */
            display: flex;
            justify-content: center;
        }

        @media screen and (max-width: 1285px) {

            /* Jarak antara tombol pada tampilan mobile */
            .btn-update,
            .btn-delete {
                display: block;
                /* Membuat tombol tampil dalam satu baris */
                width: 100%;
                /* Lebar tombol mengikuti lebar kontainer */
                margin-bottom: 5px;
                /* Memberikan jarak antara tombol */
            }

            /* Tombol Update di atas tombol Delete */
            .btn-update {
                margin-bottom: 10px;
                /* Berikan jarak lebih besar di antara tombol */
            }
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?php include 'lay/header.php'; ?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h2>Halaman Edit Produk</h2>
                <div class="btn-container">
                    <button class="btn btn-tambah" id="buo" onclick="showForm()">Tambah</button>
                </div>

                <!-- Menggunakan CSS Flexbox -->
                <div class="input-container" style="display: flex; justify-content: center;">
                    <div class="form-tambah" id="formTambah" style="display: none;">
                        <form id="formTambahProduk" method="post" onsubmit="return validateForm()">
                            <input type="text" name="judul_produk" id="judul_produk" class="input-tambah" placeholder="Judul Produk">
                            <input type="text" name="sub_judul_produk" id="sub_judul_produk" class="input-tambah" placeholder="Sub Judul Produk">
                            <button type="submit" class="btn btn-tambah">Simpan</button>
                        </form>
                    </div>
                </div>

                <div class="table-container">
                    <table id="produkTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="text-align: left;">Judul Produk</th>
                                <th style="text-align: left;">Sub Judul Produk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'koneksi_coba.php';
                            $sql = "SELECT * FROM produk";
                            $result = mysqli_query($koneksi, $sql);
                            $no = 1;
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr id='row-" . $row['id'] . "'>";
                                    echo "<td>" . $no . "</td>";
                                    echo "<td style='text-align: left;'>" . $row['judul_produk'] . "</td>";
                                    echo "<td style='text-align: left;'>" . $row['sub_judul_produk'] . "</td>";
                                    echo "<td style='text-align: center;'>";
                                    echo "<button class='btn btn-update' onclick='showUpdateForm(" . $row['id'] . ", \"" . $row['judul_produk'] . "\", \"" . $row['sub_judul_produk'] . "\")'>Update</button>";
                                    echo "<button class='btn btn-delete' onclick='deleteProduk(" . $row['id'] . ")'>Delete</button>";
                                    echo "</td>";
                                    echo "</tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='4'>Tidak ada data.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Form update -->
                <div class="form-update" id="formUpdateProduk">
                    <form onsubmit="return submitForm()" id="formUpdateProdukForm">
                        <input type="hidden" name="id" id="update_id_produk">
                        <!-- Atur posisi form update ke atas atau bawah -->
                        <div class="input-wrapper">
                            <input type="text" name="judul_produk" id="update_judul_produk" class="input-update" placeholder="Judul Produk">
                        </div>
                        <div class="input-wrapper">
                            <input type="text" name="sub_judul_produk" id="update_sub_judul_produk" class="input-update" placeholder="Sub Judul Produk">
                        </div>
                        <button type="submit" class="btn btn-update">Simpan</button>
                        <button type="button" class="btn btn-delete" onclick="cancelUpdate()">Batal</button>
                    </form>
                </div>


                <div style="height: 40px;"></div> <!-- Penambahan elemen untuk memperpanjang halaman -->


                <script>
                    function showForm() {
                        var form = document.getElementById("formTambah");
                        var tableContainer = document.querySelector('.table-container');
                        if (form.classList.contains("show")) {
                            form.classList.remove("show");
                            setTimeout(function() {
                                form.style.display = "none"; // Menyembunyikan form setelah animasi selesai
                            }, 500); // Waktu animasi
                            tableContainer.classList.remove('shifted');
                            // Mengembalikan tabel ke posisi semula
                            tableContainer.style.transform = "translateY(0)";
                        } else {
                            form.style.display = "block"; // Menampilkan form sebelum animasi dimulai
                            form.classList.add("show"); // Menambah kelas show untuk menampilkan form dengan animasi
                            tableContainer.classList.add('shifted');
                            // Menggeser tabel ke bawah
                            tableContainer.style.transform = "translateY(" + form.clientHeight + "px)";
                        }
                    }

                    function deleteProduk(id) {
                        if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                            var xhr = new XMLHttpRequest();
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                    if (xhr.status === 200) {
                                        var rowToDelete = document.getElementById("row-" + id);
                                        if (rowToDelete) {
                                            rowToDelete.parentNode.removeChild(rowToDelete);

                                            // Perbarui nomor urut setiap baris yang tersisa
                                            var rows = document.querySelectorAll("#produkTable tbody tr");
                                            rows.forEach(function(row, index) {
                                                var cell = row.querySelector("td:first-child");
                                                if (cell) {
                                                    cell.textContent = index + 1;
                                                }
                                            });
                                        } else {
                                            alert('Baris tabel tidak ditemukan.');
                                        }
                                    } else {
                                        alert('Terjadi kesalahan saat menghapus produk.');
                                    }
                                }
                            };
                            xhr.open("POST", "hapus_produk.php", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.send("id=" + id);
                        }
                    }

                    function validateForm() {
                        var judulProduk = document.getElementById("judul_produk").value;
                        if (judulProduk == "") {
                            alert("Judul produk tidak boleh kosong.");
                            return false;
                        }
                        return true;
                    }

                    function validateUpdateForm() {
                        var judulProduk = document.getElementById("update_judul_produk").value;
                        if (judulProduk == "") {
                            alert("Judul produk tidak boleh kosong.");
                            return false;
                        }
                        return true;
                    }

                    function showUpdateForm(id, judulProduk, subJudulProduk) {
                        var form = document.getElementById("formUpdateProduk");
                        var inputId = document.getElementById("update_id_produk");
                        var inputJudulProduk = document.getElementById("update_judul_produk");
                        var inputSubJudulProduk = document.getElementById("update_sub_judul_produk");

                        inputId.value = id;
                        inputJudulProduk.value = judulProduk;
                        inputSubJudulProduk.value = subJudulProduk;

                        // Temukan baris tabel yang akan diupdate
                        var rowToUpdate = document.getElementById("row-" + id);

                        // Buat form update muncul tepat di samping baris yang sesuai
                        form.style.position = "absolute";
                        form.style.top = rowToUpdate.offsetTop + 110 + "px"; // Ubah nilai 40 sesuai kebutuhan vertikal
                        form.style.left = rowToUpdate.offsetWidth + 430 + "px"; // Ubah nilai 20 sesuai kebutuhan horizontal
                        form.style.display = "block";
                        document.querySelector('.table-container').classList.add('shifted'); // Add class to animate table shift

                        // Menggeser tabel ke kiri
                        var tableContainer = document.querySelector('.table-container');
                        tableContainer.style.transform = "translateX(-12%)";
                    }

                    function cancelUpdate() {
                        var form = document.getElementById("formUpdateProduk");
                        var tableContainer = document.querySelector('.table-container');

                        form.style.display = "none";
                        tableContainer.classList.remove('shifted'); // Remove class to reset table position
                        // Mengembalikan tabel ke posisi semula
                        tableContainer.style.transform = "translateX(0)";
                    }

                    function submitForm() {
                        var id = document.getElementById("update_id_produk").value; // Mengambil id dari input yang benar
                        var judulProduk = document.getElementById("update_judul_produk").value; // Mengambil nilai judul produk dari input yang benar
                        var subJudulProduk = document.getElementById("update_sub_judul_produk").value; // Mengambil nilai sub judul produk dari input yang benar

                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    // Handle response
                                    window.location.reload(); // Reload halaman setelah berhasil memperbarui
                                } else {
                                    // Handle error
                                    alert('Terjadi kesalahan saat memperbarui produk.');
                                }
                            }
                        };
                        xhr.open("POST", "update_produk.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send("id=" + id + "&judul_produk=" + encodeURIComponent(judulProduk) + "&sub_judul_produk=" + encodeURIComponent(subJudulProduk));

                        return false; // Mencegah form melakukan submit tradisional
                    }
                </script>
            </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    </div>
    </main>
    </div>
    </div>
</body>

</html>