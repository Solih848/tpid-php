<?php
session_start();

if (!isset($_SESSION['username1'])) {
    header('Location: login_admin.php');
    exit();
}
$username = $_SESSION['username1'];

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
    <title>Read Sub Judul Admin</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

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
            font-family: 'Roboto', Arial, sans-serif;
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
            font-family: Arial, sans-serif;
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
            font-family: Arial, sans-serif;
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
            font-family: Arial, sans-serif;
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
            font-family: 'Roboto', Arial, sans-serif;
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
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?php include 'lay/header.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="container">
                    <div class="welcome-message" id="welcomeMessage">
                    </div>
                    <h1 style="margin-top:20px;">Halaman Edit Data</h1>
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
                                <th>Aksi</th>
                            </tr>
                            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
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
                                    <td>
                                        <!-- Tambahkan ikon edit dan hapus menggunakan Font Awesome -->
                                        <a href="edit.php?id=<?php echo $row['id']; ?>"><i class="fas fa-edit edit-icon"></i></a>
                                        <!-- Tambahkan tombol hapus -->
                                        <form action="" method="post">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash-alt delete-icon"></i>
                                            </button>
                                        </form>
                                    </td>
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
                        var text = "Selamat datang, <?php echo $_SESSION['username1']; ?>!";
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
                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

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