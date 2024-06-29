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
    // Periksa apakah input nama_pasar sudah tersedia
    if (isset($_POST["satuan"])) {
        // Ambil nilai nama_pasar dari permintaan POST
        $namaPasar = $_POST["satuan"];

        // Persiapkan statement SQL untuk memasukkan data ke database
        $sql = "INSERT INTO satuan (satuan) VALUES ('$namaPasar')";

        // Jalankan statement SQL
        if (mysqli_query($koneksi, $sql)) {
            // Redirect pengguna kembali ke halaman ini setelah data ditambahkan
            header("Location: satuan.php");
            exit(); // Pastikan kode setelah redirect tidak dijalankan
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
        }
    } else {
        echo "Nama pasar tidak ditemukan dalam permintaan POST.";
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Edit Satuan</title>
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
            filter: brightness(10%);
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
            <div class="container-fluid px-4" style="margin-top:20px;">
                <h2>Halaman Edit Satuan</h2>
                <div class="btn-container">
                    <button class="btn btn-tambah" onclick="showForm()">Tambah</button>
                </div>

                <!-- Form tambah -->
                <div class="input-container"> <!-- Tambahkan div ini sebelum form tambah -->
                    <div class="form-tambah" id="formTambah" style="display: none;">
                        <form id="formTambahPasar" method="post" onsubmit="return validateForm()">
                            <input type="text" name="satuan" id="nama_pasar" class="input-tambah" placeholder="Nama Satuan">
                            <button type="submit" class="btn btn-tambah">Simpan</button>
                        </form>
                    </div>
                </div>


                <div class="table-container">
                    <table id="pasarTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="text-align: left;">Nama Pasar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'koneksi_coba.php';
                            $sql = "SELECT * FROM satuan";
                            $result = mysqli_query($koneksi, $sql);
                            $no = 1;
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr id='row-" . $row['id'] . "'>";
                                    echo "<td>" . $no . "</td>";
                                    echo "<td style='text-align: left;'>" . $row['satuan'] . "</td>";
                                    echo "<td style='text-align: center;'>";
                                    echo "<button class='btn btn-update' onclick='showUpdateForm(" . $row['id'] . ", \"" . $row['satuan'] . "\")'>Update</button>";
                                    echo "<button class='btn btn-delete' onclick='deletePasar(" . $row['id'] . ")'>Delete</button>";
                                    echo "</td>";
                                    echo "</tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='3'>Tidak ada data.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Form update -->
                <div class="form-update" id="formUpdatePasar">
                    <form onsubmit="return submitForm()" id="formUpdatePasarForm">
                        <input type="hidden" name="id" id="update_id_pasar">
                        <input type="text" name="nama_pasar" id="update_nama_pasar" class="input-update" placeholder="Nama Satuan">
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





                    function deletePasar(id) {
                        if (confirm('Apakah Anda yakin ingin menghapus satuan ini?')) {
                            var xhr = new XMLHttpRequest();
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                    if (xhr.status === 200) {
                                        var rowToDelete = document.getElementById("row-" + id);
                                        if (rowToDelete) {
                                            rowToDelete.parentNode.removeChild(rowToDelete);

                                            // Perbarui nomor urut setiap baris yang tersisa
                                            var rows = document.querySelectorAll("#pasarTable tbody tr");
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
                                        alert('Terjadi kesalahan saat menghapus satuan.');
                                    }
                                }
                            };
                            xhr.open("POST", "hapus_satuan.php", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.send("id=" + id);
                        }
                    }


                    function validateForm() {
                        var namaPasar = document.getElementById("satuan").value;
                        if (namaPasar == "") {
                            alert("Nama satuan tidak boleh kosong.");
                            return false;
                        }
                        return true;
                    }

                    function validateUpdateForm() {
                        var namaPasar = document.getElementById("update_nama_pasar").value;
                        if (namaPasar == "") {
                            alert("Nama satuan tidak boleh kosong.");
                            return false;
                        }
                        return true;
                    }

                    function showUpdateForm(id, namaPasar) {
                        var form = document.getElementById("formUpdatePasar");
                        var inputId = document.getElementById("update_id_pasar");
                        var inputNamaPasar = document.getElementById("update_nama_pasar");

                        inputId.value = id;
                        inputNamaPasar.value = namaPasar;

                        // Temukan baris tabel yang akan diupdate
                        var rowToUpdate = document.getElementById("row-" + id);

                        // Buat form update muncul tepat di samping baris yang sesuai
                        form.style.position = "absolute";
                        form.style.top = rowToUpdate.offsetTop + 160 + "px"; // Ubah nilai 40 sesuai kebutuhan vertikal
                        form.style.left = rowToUpdate.offsetWidth + 350 + "px"; // Ubah nilai 20 sesuai kebutuhan horizontal
                        form.style.display = "block";
                        document.querySelector('.table-container').classList.add('shifted'); // Add class to animate table shift

                        // Menggeser tabel ke kiri
                        var tableContainer = document.querySelector('.table-container');
                        tableContainer.style.transform = "translateX(-18%)";
                    }


                    function cancelUpdate() {
                        var form = document.getElementById("formUpdatePasar");
                        var tableContainer = document.querySelector('.table-container');

                        form.style.display = "none";
                        tableContainer.classList.remove('shifted'); // Remove class to reset table position
                        // Mengembalikan tabel ke posisi semula
                        tableContainer.style.transform = "translateX(0)";
                    }

                    function submitForm() {
                        var id = document.getElementById("update_id_pasar").value; // Mengambil id dari input yang benar
                        var namaPasar = document.getElementById("update_nama_pasar").value; // Mengambil nilai nama pasar dari input yang benar

                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    // Handle response
                                    window.location.reload(); // Reload halaman setelah berhasil memperbarui
                                } else {
                                    // Handle error
                                    alert('Terjadi kesalahan saat memperbarui pasar.');
                                }
                            }
                        };
                        xhr.open("POST", "update_satuan.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.send("id=" + id + "&satuan=" + encodeURIComponent(namaPasar));

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