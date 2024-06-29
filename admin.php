<?php

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
$username = $_SESSION['username']; 

include 'koneksi.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $nama_pasar = $_POST['nama_pasar'];
    $harga = $_POST['harga'];
    $tanggal = $_POST['tanggal'];
    $foto_produk = $_FILES['foto_produk']['name'];
    $file_tmp = $_FILES['foto_produk']['tmp_name'];
    $file_path = 'uploads/' . $foto_produk;
    move_uploaded_file($file_tmp, $file_path);
    $query = "INSERT INTO barang (nama_barang, nama_pasar, harga, tanggal, foto_produk) VALUES ('$nama_barang', '$nama_pasar', '$harga','$tanggal', '$foto_produk')";
    mysqli_query($koneksi, $query);
}

$where_clause = '';

if (isset($_GET['filter_nama_barang']) && !empty($_GET['filter_nama_barang'])) {
    $filter_nama_barang = $_GET['filter_nama_barang'];
    $where_clause .= " AND nama_barang LIKE '%$filter_nama_barang%'";
}

if (isset($_GET['filter_nama_pasar']) && !empty($_GET['filter_nama_pasar'])) {
    $filter_nama_pasar = $_GET['filter_nama_pasar'];
    $where_clause .= " AND nama_pasar LIKE '%$filter_nama_pasar%'";
}

if (isset($_GET['filter_tanggal']) && !empty($_GET['filter_tanggal'])) {
    $filter_tanggal = $_GET['filter_tanggal'];
    $where_clause .= " AND tanggal = '$filter_tanggal'";
}

// Kueri SQL untuk menampilkan data barang sesuai dengan filter
$query = "SELECT * FROM barang WHERE 1 $where_clause ORDER BY tanggal DESC";
$result = mysqli_query($koneksi, $query);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Halaman Operator</title>
</head>

<body>
    <h1>Halaman Operator</h1>
    <p>Selamat datang, <?php echo $username; ?>!</p>

        <!-- Formulir Filter -->
    <form method="get">
        <label for="filter_nama_barang">Nama Barang:</label>
        <select id="filter_nama_barang" name="filter_nama_barang">
            <option value="">Pilih Barang</option>
            <option value="beras">Beras</option>
            <option value="gula">Gula</option>
            <option value="minyak goreng">Minyak Goreng</option>
        </select>

        <label for="filter_nama_pasar">Nama Pasar:</label>
        <select id="filter_nama_pasar" name="filter_nama_pasar">
            <option value="">Pilih Pasar</option>
            <option value="Pasar A">Pasar A</option>
            <option value="Pasar B">Pasar B</option>
        </select>


        <label for="filter_tanggal">Tanggal:</label>
        <input type="date" id="filter_tanggal" name="filter_tanggal">

        <button type="submit">Filter</button>
        <a href="admin.php">
          <button>Reset</button>
        </a>

    </form>

    <!-- tabel -->
<h2>Daftar Barang</h2>
<a href="tambah.php">Tambah Barang</a><br><br>
<table border="1">
    <tr>
        <th>Tanggal</th>
        <th>Operator</th>
        <th>Nama Barang</th>
        <th>Nama Pasar</th>
        <th>Harga</th>
        <th>Foto Produk</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?php echo $row['tanggal']; ?></td>
            <td><?php echo $row['operator']; ?></td>
            <td><?php echo $row['nama_barang']; ?></td>
            <td><?php echo $row['nama_pasar']; ?></td>
            <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
            <td><img src="http://localhost/sembako/uploads/<?php echo $row['foto_produk']; ?>" width="100" height="100"></td>
        </tr>
    <?php endwhile; ?>
</table>
<form method="post" action="proses_logout_operator.php">
    <button type="submit">Logout</button>
</form>

</body>

</html>

