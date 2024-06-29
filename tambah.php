<?php
session_start();
$username = $_SESSION['username']; 

include 'koneksi.php';


$daftar_barang = array(
    "Beras" => "beras.png",
    "Gula" => "gula.png",
    "Minyak Goreng" => "minyak.png"
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $nama_pasar = $_POST['nama_pasar'];
    $harga = $_POST['harga'];
    $tanggal = $_POST['tanggal'];
    $username = $_POST['operator']; 

    $foto_produk = $daftar_barang[$nama_barang];

    $query = "INSERT INTO barang (nama_barang, nama_pasar, harga, tanggal, foto_produk, operator) VALUES ('$nama_barang', '$nama_pasar', '$harga','$tanggal', '$foto_produk', '$username')";
    mysqli_query($koneksi, $query);

    // Perbarui array $daftar_barang dengan nama gambar baru
    $daftar_barang[$nama_barang] = $foto_produk;

    header('Location: admin.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
</head>

<body>
    <h1>Tambah Barang</h1>
    <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="operator" value="<?php echo $username; ?>">
    <label for="nama_barang">Nama Barang:</label><br>
    <select id="nama_barang" name="nama_barang">
        <option value="" selected disabled>Pilih Barang</option>
        <?php foreach ($daftar_barang as $barang => $gambar) : ?>
            <option value="<?php echo $barang; ?>"><?php echo $barang; ?></option>
        <?php endforeach; ?>
    </select><br>
        <label for="nama_pasar">Nama Pasar:</label><br>
        <select id="nama_pasar" name="nama_pasar">
            <option value="" selected disabled>Pilih Pasar</option> <!-- Tambahkan opsi ini sebagai default -->
            <option value="Pasar A">Pasar A</option>
            <option value="Pasar B">Pasar B</option>
        </select><br>
        <label for="harga">Harga:</label><br>
        <input type="number" id="harga" name="harga" autocomplete="off"><br>
        <label for="preview">Pratinjau Gambar:</label><br>
        <img id="preview" src="#" alt="Pratinjau Gambar" style="max-width: 200px; max-height: 200px;"><br>
        <label for="tanggal">Tanggal:</label><br>
        <input type="date" id="tanggal" name="tanggal"><br>
        <button type="submit">Tambah Barang</button>
    </form>

    <script>
        document.getElementById('nama_barang').addEventListener('change', function() {
            var selectedBarang = this.value;
            var daftarBarang = <?php echo json_encode($daftar_barang); ?>;
            document.getElementById('preview').src = 'uploads/' + daftarBarang[selectedBarang];
        });
    </script>


</body>

</html>
