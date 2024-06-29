<?php

session_start();

// Pastikan session 'username' sudah ada sebelum mengaksesnya
if (!isset($_SESSION['username'])) {
    // Redirect atau tindakan lain jika session 'username' belum ada
    echo "Session 'username' belum ada. Silakan login terlebih dahulu.";
    exit;
}

include 'koneksi.php'; // Menggunakan koneksi login

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap nilai yang diinputkan dari formulir
    $judul_produk = $_POST['judul_produk'];
    $sub_judul_produk = $_POST['sub_judul_produk'];
    $nama_pasar = $_POST['nama_pasar'];
    $tanggal = $_POST['tanggal'];
    $satuan = $_POST['satuan'];
    $harga_kemarin = $_POST['harga_kemaren'];
    $harga_sekarang = $_POST['harga_sekarang'];

    // Tetapkan harga kemaren menjadi 0 jika kosong atau tidak valid
    if (empty($harga_kemarin) || $harga_kemarin === "Harga tidak ditemukan") {
        $harga_kemarin = 0; // Tetapkan ke 0
    }

    // Validasi input untuk harga sekarang
    if (empty($harga_sekarang)) {
        echo "<script>alert('Harga sekarang harus diisi.');</script>";
        exit; // Hentikan eksekusi jika kosong
    }

    // Koneksi ke database "sembako_db"
    include 'koneksi_sembako.php';

    // Query SQL untuk memasukkan data ke tabel "sub_judul_produk"
    $query_insert = "INSERT INTO sub_judul_produk (judul_produk, nama_bahan_pokok, nama_pasar, tanggal, satuan, harga_kemarin, harga_sekarang, operator_pasar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Persiapan statement
    $stmt = $koneksi->prepare($query_insert);
    $stmt->bindParam(1, $judul_produk);
    $stmt->bindParam(2, $sub_judul_produk);
    $stmt->bindParam(3, $nama_pasar);
    $stmt->bindParam(4, $tanggal);
    $stmt->bindParam(5, $satuan);
    $stmt->bindParam(6, $harga_kemarin);
    $stmt->bindParam(7, $harga_sekarang);
    $stmt->bindParam(8, $_SESSION['username']); // Simpan nilai dari $_SESSION['username'] ke dalam kolom operator_pasar

    // Eksekusi query
    try {
        if ($stmt->execute()) {
            // Jika penyimpanan berhasil, redirect ke halaman read_sub_judul_produk.php
            header("Location: operator.php");
            exit; // Pastikan tidak ada output sebelum redirect
        } else {
            echo "<script>alert('Gagal menyimpan data.');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            border: 1px solid #ccc; /* Solid border dengan lebar 1px dan warna #ccc */
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 45px;
            text-align: center;
            margin-top: 0;
            color: #333333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 36px;
            letter-spacing: 3px;
            background: linear-gradient(to right, #4CAF50, #4CAF50, #007bff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: color 0.3s ease-in-out;
            cursor: pointer;
        }

        h1:hover {
            color: #4CAF50;
        }

        /* Elemen di luar kotak */
        .additional-content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 20px;
        }

        form {
            display: grid;
            gap: 10px;
        }

        label {
            font-weight: bold;
        }

        select,
        input[type="date"],
        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: background-color 0.3s ease-in-out;
        }

        select:hover,
        input[type="date"]:hover,
        input[type="text"]:hover,
        input[type="submit"]:hover {
            background-color: #f0f0f0;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-title {
            text-align: center;
            color: white;
            padding: 10px 0;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            margin-top: -20px;
            margin-bottom: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 32px;
            background: linear-gradient(to right, #007bff, #1A73E8);
            letter-spacing: 5px;
        }

        input[type="text"],
        select,
        input[type="date"] {
            padding: 12px;
            margin-bottom: 15px;
        }

        input[type="submit"] {
            padding: 12px 20px;
        }

        input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }       
    </style>
</head>
<body>
    <div class="container">
        <h1>FORM INPUT KOMODITAS</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm(event)">
    <label for="judul_produk">Komoditas :</label>
    <select name="judul_produk" id="judul_produk" required>
        <option value="" disabled selected>Pilih Komoditas</option>
        <?php
        // Koneksi ke database
        include 'koneksi_coba.php';

        // Ambil daftar judul produk dari tabel produk dalam database uji_coba
        $query = "SELECT DISTINCT judul_produk FROM produk";
        $result = mysqli_query($koneksi, $query);

        // Tampilkan daftar judul produk sebagai pilihan pada list box
        while ($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row['judul_produk'] . "'>" . $row['judul_produk'] . "</option>";
        }
        ?>
    </select>
    <label for="sub_judul_produk">Kualitas :</label>
    <select name="sub_judul_produk" id="sub_judul_produk" required>
        <option value="" disabled selected>Masukkan Kualitas Terlebih Dahuluk</option>
        <!-- Daftar sub judul produk akan di-generate melalui JavaScript -->
    </select>
    <label for="nama_pasar">Nama Pasar:</label>
    <select name="nama_pasar" id="nama_pasar" required>
        <option value="" disabled selected>Pilih Pasar</option>
        <?php
        // Query untuk mengambil data pasar dari tabel pasar
        $query_pasar = "SELECT id, nama_pasar FROM pasar";
        $result_pasar = mysqli_query($koneksi, $query_pasar);

        // Tampilkan daftar pasar sebagai pilihan pada list box
        while ($row_pasar = mysqli_fetch_array($result_pasar)) {
            echo "<option value='" . $row_pasar['nama_pasar'] . "'>" . $row_pasar['nama_pasar'] . "</option>";
        }
        ?>
    </select>
    <label for="tanggal">Tanggal:</label>
    <input type="date" id="tanggal" name="tanggal" required>
    <label for="satuan">Satuan:</label>
    <select name="satuan" id="satuan" required>
        <option value="" disabled selected>Pilih Satuan</option>
        <?php
        // Query untuk mengambil data satuan dari tabel satuan
        $query_satuan = "SELECT id, satuan FROM satuan";
        $result_satuan = mysqli_query($koneksi, $query_satuan);

        while ($row_satuan = mysqli_fetch_array($result_satuan)) {
            echo "<option value='" . $row_satuan['satuan'] . "'>" . $row_satuan['satuan'] . "</option>";
        }
        ?>
    </select>
    <label for="harga_kemaren">Harga Kemaren:</label>
    <input type="text" id="harga_kemaren" name="harga_kemaren" required readonly>
    <label for="harga_sekarang">Harga Sekarang:</label>
    <input type="text" id="harga_sekarang" name="harga_sekarang" onkeypress="return isNumber(event)" placeholder="Masukkan Harga Sekarang" required>
    <input type="submit" value="Submit">
</form>

    </div>

     <div class="additional-content">
        <h2>Informasi Tambahan</h2>
        <p>Ini adalah informasi tambahan yang bisa ditampilkan di luar kotak form. Anda dapat menambahkan apapun yang ingin ditampilkan di sini.</p>
    </div>

<script>
    // Fungsi untuk memeriksa apakah data sudah ada di database
    function checkDataExists(callback) {
        var formData = new FormData(document.querySelector('form'));

        // Kirim data form ke server untuk pengecekan
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "check_data_exists.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                callback(xhr.responseText === "exists");
            }
        };
        xhr.send(formData);
    }

    // Modifikasi fungsi validateForm untuk memeriksa data sebelum submit
    function validateForm(event) {
        event.preventDefault(); // Mencegah form submit secara default

        checkDataExists(function(exists) {
            if (exists) {
                // Jika data sudah ada, tampilkan konfirmasi
                var confirmSave = confirm("Data sudah ada. Apakah Anda ingin melanjutkan?");
                if (confirmSave) {
                    // Jika pengguna memilih OK, lanjutkan untuk menyimpan data
                    document.querySelector('form').submit();
                }
            } else {
                // Jika data tidak ada, langsung submit form
                document.querySelector('form').submit();
            }
        });

        // Return false untuk mencegah form submit sebelum pengecekan selesai
        return false;
    }

    // Attach validateForm function to the form's submit event
    document.querySelector('form').addEventListener('submit', validateForm);
</script>



    <script>

// Fungsi untuk memperbarui harga kemaren berdasarkan nama bahan pokok dan nama pasar
function updateHargaKemaren() {
    var subJudulProduk = document.getElementById("sub_judul_produk").value;
    var namaPasar = document.getElementById("nama_pasar").value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var hargaKemarenInput = document.getElementById("harga_kemaren");
            if (xhr.responseText === "Harga tidak ditemukan") {
                hargaKemarenInput.value = 0; // Tetapkan 0 jika tidak ditemukan
            } else {
                hargaKemarenInput.value = xhr.responseText; // Tetapkan harga yang ditemukan
            }
        }
    };
    xhr.open("GET", "get_harga_kemaren.php?nama_bahan_pokok=" + subJudulProduk + "&nama_pasar=" + namaPasar, true);
    xhr.send();
}

// Panggil fungsi saat kedua input diisi
document.getElementById("sub_judul_produk").addEventListener("change", updateHargaKemaren);
document.getElementById("nama_pasar").addEventListener("change", updateHargaKemaren);




        // Fungsi untuk mengambil dan menampilkan sub judul produk yang sesuai
        function tampilkanSubJudul() {
            var judulProduk = document.getElementById("judul_produk").value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Periksa apakah judul produk dipilih
                    if (judulProduk !== "") {
                        // Jika dipilih, isi opsi dropdown sub_judul_produk
                        document.getElementById("sub_judul_produk").innerHTML = xhr.responseText;
                    } else {
                        // Jika tidak dipilih, kembalikan opsi default
                        document.getElementById("sub_judul_produk").innerHTML = "<option value='' disabled selected>Masukkan Judul Produk Terlebih Dahulu</option>";
                    }
                }
            };
            xhr.open("GET", "get_sub_judul.php?judul_produk=" + judulProduk, true);
            xhr.send();
        }

        // Fungsi untuk validasi inputan pada form harga
      function isNumber(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;

    // Allow '.' (titik) as a valid character, but not as the first character
    if (charCode == 46) {
        // Ensure that only one decimal point is present and it's not the first character
        if (evt.target.value.indexOf('.') !== -1 || evt.target.value.length === 0) {
            alert("Hanya satu titik (.) yang diperbolehkan dan tidak boleh di awal.");
            return false;
        }
        return true;
    }

    // Allow numeric characters
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        alert("Harga harus berupa angka.");
        return false;
    }

    return true;
    }

    // Fungsi untuk menonaktifkan tombol submit jika terdapat titik di input harga
    function disableSubmitIfDot() {
        var hargaKemaren = document.getElementById("harga_kemaren").value;
        var hargaSekarang = document.getElementById("harga_sekarang").value;

        // Jika terdapat titik di input harga, nonaktifkan tombol submit
        if (hargaKemaren.indexOf('.') !== -1 || hargaSekarang.indexOf('.') !== -1) {
            document.querySelector('input[type="submit"]').disabled = true;
        } else {
            document.querySelector('input[type="submit"]').disabled = false;
        }
    }

    // Panggil fungsi saat nilai input berubah
    document.getElementById("harga_kemaren").addEventListener("input", disableSubmitIfDot);
    document.getElementById("harga_sekarang").addEventListener("input", disableSubmitIfDot);

    // Fungsi untuk validasi form sebelum submit
    function validateForm() {
        var hargaSekarang = document.getElementById("harga_sekarang").value;

        // Cek apakah harga kemaren dan harga sekarang tidak kosong
        if (hargaKemaren.trim() === "" || hargaSekarang.trim() === "") {
            alert("Harga kemaren dan harga sekarang harus diisi.");
            return false;
        }

        return true;
    }

    // Panggil fungsi saat halaman dimuat
    window.onload = function() {
        tampilkanSubJudul();

        // Panggil fungsi saat pilihan judul produk berubah
        document.getElementById("judul_produk").addEventListener("change", tampilkanSubJudul);
    };
    </script>

    <script>
    // Fungsi untuk mengambil dan menetapkan nilai "Harga Kemaren" secara otomatis
    function setHargaKemarenAutomatically() {
        var subJudulProduk = document.getElementById("sub_judul_produk").value;
        var namaPasar = document.getElementById("nama_pasar").value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var hargaKemarenInput = document.getElementById("harga_kemaren");
                hargaKemarenInput.value = xhr.responseText;
            }
        };
        xhr.open("GET", "get_harga_kemaren.php?nama_bahan_pokok=" + subJudulProduk + "&nama_pasar=" + namaPasar, true);
        xhr.send();
    }

    // Panggil fungsi saat kedua input diisi
    document.getElementById("sub_judul_produk").addEventListener("change", setHargaKemarenAutomatically);
    document.getElementById("nama_pasar").addEventListener("change", setHargaKemarenAutomatically);
</script>

</body>
</html>