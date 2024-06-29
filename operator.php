<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include 'koneksi.php'; // Menggunakan koneksi login

$username = $_SESSION['username'];

include 'koneksi_sembako.php'; // Menggunakan koneksi database Sembako

// Fungsi pencarian berdasarkan tanggal dan nama pasar
if (isset($_POST['cari'])) {
    $tanggal = $_POST['tanggal'];
    $nama_pasar = $_POST['nama_pasar'];
    $query = "SELECT * FROM sub_judul_produk WHERE tanggal='$tanggal' AND nama_pasar='$nama_pasar' ORDER BY tanggal DESC"; // Query pencarian
} else if (isset($_POST['tampilkan_semua'])) {
    $query = "SELECT * FROM sub_judul_produk ORDER BY tanggal DESC"; // Query tampilkan semua data
} else if (isset($_POST['hapus'])) {
    $id = $_POST['id']; // Ambil ID data yang akan dihapus
    $query_delete = "DELETE FROM sub_judul_produk WHERE id = '$id'";
    $result_delete = $koneksi->query($query_delete);
    if ($result_delete) {
        // Redirect kembali ke halaman ini setelah penghapusan berhasil
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        echo "Gagal menghapus data: " . $koneksi->error;
    }
} else {
    $query = "SELECT * FROM sub_judul_produk ORDER BY tanggal DESC"; // Query tampilkan semua data (default)
}

// Jalankan query hanya jika kondisi bukan untuk penghapusan data
if (!isset($_POST['hapus'])) {
    $result = $koneksi->query($query);
    $nomor = 1; // Inisialisasi nomor awal
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Sub Judul Produk</title>
    <!-- Include Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Include Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        /* Style for page title */
        h1 {
            text-align: center;
            color: #3498db;
            /* Warna biru elegan */
            /* Font family keren */
            margin-bottom: 45px;
            /* Menambah jarak ke bawah */
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Style for form elements */
        label {
            font-weight: bold;
            display: inline-block;
            width: 100px;
            /* Adjust the width as needed */
            color: #333;
            /* Font color */
            /* Font family */
        }

        input[type="date"],
        select,
        button {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin: 5px;
            width: 200px;
            /* Adjust the width as needed */
        }

        /* Style for buttons */
        button {
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
            padding: 10px 20px;
            /* Padding horizontal 20px, padding vertikal 10px */
            margin: 5px 10px;
            /* Margin 5px atas/bawah, 10px kiri/kanan */
        }

        /* Style untuk tombol "Tampilkan Semua" */
        button[name="tampilkan_semua"] {
            width: 150px;
            /* Lebar tetap 150px */
        }

        /* Lebar khusus untuk tombol "Cari" */
        button[type="submit"] {
            width: 100px;
            /* Sesuaikan dengan kebutuhan */
        }

        /* Style untuk tombol "Tambah" */
        button[type="button"] {
            width: auto;
            /* Lebar otomatis */
            padding: 10px 15px;
            /* Padding horizontal 15px, padding vertikal 10px */
            margin: 5px 10px;
            /* Margin 5px atas/bawah, 10px kiri/kanan */
        }

        /* Style untuk tombol hapus */
        button[type="submit"][name="hapus"] {
            background-color: transparent;
            /* Jadikan latar belakang transparan */
            border: none;
            /* Hapus border */
            padding: 0;
            /* Hapus padding */
        }

        button:hover {
            background-color: #2980b9;
        }

        /* Style for table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 70px;
            /* Increase the margin top */
        }

        /* Style for table headers */
        th,
        td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
            /* Reduce font size */
            color: #333;
            /* Font color */
            /* Font family */
        }

        th {
            background-color: #f2f2f2;
        }

        /* Hover effect for table rows */
        tr:hover {
            background-color: #f5f5f5;
        }

        /* Alternate row color for table */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Increase width for specific columns */
        td:nth-child(3)

        /* Nama Bahan Pokok */
            {
            min-width: 150px;
        }

        td:nth-child(10)

        /* Tanggal */
            {
            /* Operator Pasar */
            min-width: 80px;
        }

        td:nth-child(11) {
            /* Operator Pasar */
            min-width: 70px;
        }

        /* Style for table cells */
        td {
            padding: 10px;
            /* Atur padding untuk mengontrol jarak antar baris */
            text-align: center;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
            /* Reduce font size */
            color: #333;
            /* Font color */
            /* Font family */
            position: relative;
            /* Tambahkan properti position */
        }

        /* Style for Edit and Delete icons */
        .edit-icon,
        .delete-icon {
            width: 20px;
            height: 20px;
            background-size: cover;
            display: inline-block;
            position: absolute;
            /* Tambahkan properti position */
            top: 50%;
            /* Geser ke tengah vertikal */
            transform: translateY(-50%);
            /* Atur posisi vertikal */
        }

        .delete-icon {
            left: 38px;
            color: red;
        }

        .edit-icon {
            right: 40px;
            color: #3498db;
        }

        /* Style untuk pesan selamat datang */
        .container {
            border: 1px solid #ccc;
            /* Solid border dengan lebar 1px dan warna #ccc */
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1200px;
            margin: 20px auto 0;
            /* Center the container */
            position: relative;
            top: 50px
        }

        .welcome-message {
            position: absolute;
            top: -35px;
            /* Menggeser ke bawah 80px dari bagian atas */
            right: 0;
            /* Membuat elemen berada di sisi kanan container */
            left: 0;
            width: auto;
            /* Sesuaikan dengan panjang teks */
            padding: 20px;
            text-align: center;
            font-size: 24px;
            color: #fff;
            /* Warna teks putih */
            /* Font family keren */
            border-top-left-radius: 10px;
            /* Penyesuaian border radius */
            border-top-right-radius: 10px;
            /* Penyesuaian border radius */
            background: linear-gradient(to right, #3498db, #2ecc71);
            /* Gradient background */
        }

        .table-wrapper {
            overflow-x: auto;
            margin-top: 20px;
            /* Atur margin top sesuai kebutuhan */
        }

        * {
            font-family: Poppins, sans-serif;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="welcome-message" id="welcomeMessage">
        </div>
        <h1>Halaman Edit Data</h1>
        <form action="" method="post">
            <label for="tanggal">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal">
            <label for="nama_pasar">Nama Pasar:</label>
            <select name="nama_pasar" id="nama_pasar">
                <option value="">Pilih Pasar</option>
                <?php
                // Koneksi ke database
                include 'koneksi_coba.php';

                // Query untuk mengambil data pasar dari tabel 'pasar'
                $query_pasar = "SELECT * FROM pasar";
                $result_pasar = mysqli_query($koneksi, $query_pasar);

                // Periksa apakah query berhasil dieksekusi
                if ($result_pasar) {
                    // Iterasi untuk setiap baris hasil query
                    while ($row_pasar = mysqli_fetch_assoc($result_pasar)) {
                        echo "<option value='{$row_pasar['nama_pasar']}'>{$row_pasar['nama_pasar']}</option>";
                    }
                } else {
                    echo "Gagal menjalankan query: " . mysqli_error($koneksi);
                }

                // Tutup koneksi database
                mysqli_close($koneksi);
                ?>
            </select>
            <button type="submit" name="cari">Cari</button>
            <button type="submit" name="tampilkan_semua">Tampilkan</button> <!-- Tombol Tampilkan Semua -->
            <button type="button" onclick="window.location.href='tambah_barang.php'"><i class="fas fa-plus"></i> Tambah</button>
            <h4>
                Edit text di tabel halaman komoditi
                <a href="edit_text_komoditi.php">Klik Disini</a>
            </h4>
        </form>


        <div class="table-wrapper">
            <table>
                <tr>
                    <th>No</th>
                    <th>Judul Produk</th>
                    <th>Nama Bahan Pokok</th>
                    <th>Satuan</th>
                    <th>Harga Kemarin</th>
                    <th>Harga Sekarang</th>
                    <th>Perubahan (Rp)</th>
                    <th>Perubahan (%)</th>
                    <th>Nama Pasar</th>
                    <th>Tanggal</th>
                    <th>Operator Pasar</th>
                    <?php if (isset($_SESSION['is_jufriyadi']) && $_SESSION['is_jufriyadi'] === true) : ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
                <?php $nomor = 1;
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <td><?php echo $nomor++; ?></td> <!-- Menampilkan nomor berurutan -->
                        <td><?php echo $row['judul_produk']; ?></td>
                        <td><?php echo $row['nama_bahan_pokok']; ?></td>
                        <td><?php echo $row['satuan']; ?></td>
                        <td><?php echo number_format($row['harga_kemarin'], 0, ',', '.'); ?></td>
                        <td><?php echo number_format($row['harga_sekarang'], 0, ',', '.'); ?></td>

                        <!-- Penambahan kode untuk perhitungan perubahan harga -->
                        <?php
                        $perubahan_rp = $row['harga_sekarang'] - $row['harga_kemarin'];
                        $perubahan_persen = ($row['harga_sekarang'] - $row['harga_kemarin']) / $row['harga_sekarang'] * 100;
                        ?>
                        <td><?php echo number_format($perubahan_rp, 0, ',', '.'); ?></td>
                        <td><?php echo number_format($perubahan_persen, 2, ',', '.') . '%'; ?></td>

                        <!-- Sisanya tetap sama -->
                        <td><?php echo $row['nama_pasar']; ?></td>
                        <td><?php echo $row['tanggal']; ?></td>
                        <td><?php echo $row['operator_pasar']; ?></td>
                        <?php if (isset($_SESSION['is_jufriyadi']) && $_SESSION['is_jufriyadi'] === true) : ?>
                            <td><a href="edit.php?id=<?php echo $row['id']; ?>"><i class="fas fa-edit"></i></a></td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
            </table>

        </div>
    </div>

    <div style="height: 80px;"></div> <!-- Penambahan elemen untuk memperpanjang halaman -->

    <script>
        // JavaScript code to animate typing effect
        document.addEventListener('DOMContentLoaded', function() {
            var welcomeMessage = document.getElementById('welcomeMessage');
            var text = "Selamat datang, <?php echo $_SESSION['username']; ?>!";
            var index = 0;

            function typeWriter() {
                if (index < text.length) {
                    welcomeMessage.innerHTML += text.charAt(index);
                    index++;
                    setTimeout(typeWriter, 50); // Adjust the typing speed here (milliseconds)
                }
            }

            typeWriter();
        });
    </script>
    <form method="post" action="proses_logout_operator.php">
        <button type="submit">Logout</button>
    </form>
</body>

</html>