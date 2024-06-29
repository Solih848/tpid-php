<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_barang = $_POST['nama_barang'];

    if ($_FILES['foto_baru']['error'] === UPLOAD_ERR_OK) {
        $query_nama_file_lama = "SELECT foto_produk FROM barang WHERE nama_barang = '$nama_barang'";
        $result_nama_file_lama = mysqli_query($koneksi, $query_nama_file_lama);
        $row_nama_file_lama = mysqli_fetch_assoc($result_nama_file_lama);
        $nama_file_lama = $row_nama_file_lama['foto_produk'];

        $nama_file_baru = $nama_file_lama; // Menggunakan nama file lama sebagai nama file baru

        $file_path = 'uploads/' . $nama_file_baru;

        move_uploaded_file($_FILES['foto_baru']['tmp_name'], $file_path);

        $query_update_foto = "UPDATE barang SET foto_produk = '$nama_file_baru' WHERE nama_barang = '$nama_barang'";
        mysqli_query($koneksi, $query_update_foto);

        $path_gambar_lama = 'http://localhost/sembako/uploads/' . $nama_file_lama;
        if (file_exists($path_gambar_lama)) {
            unlink($path_gambar_lama);
        }
    } else {
        // Handle jika tidak ada gambar baru yang diunggah
    }
}



$query_daftar_barang = "SELECT * FROM barang";
$result_daftar_barang = mysqli_query($koneksi, $query_daftar_barang);

$daftar_barang = array();

while ($row = mysqli_fetch_assoc($result_daftar_barang)) {
    $daftar_barang[$row['nama_barang']] = $row['foto_produk'];

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Foto Barang</title>
</head>

<body>
    <h1>Edit Foto Barang</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="nama_barang">Pilih Nama Barang:</label><br>
        <select id="nama_barang" name="nama_barang">
            <option value="" selected disabled>Pilih Barang</option>
            <?php foreach ($daftar_barang as $barang => $foto) : ?>
                <option value="<?php echo $barang; ?>"><?php echo $barang; ?></option>
            <?php endforeach; ?>
        </select><br>
        <img id="preview" src="#" alt="Pratinjau Foto" style="max-width: 200px; max-height: 200px;"><br>
        <label for="foto_baru">Unggah Foto Baru:</label><br>
        <input type="file" id="foto_baru" name="foto_baru" onchange="previewImage(this);"><br><br>
        <button type="submit">Simpan Foto</button>
    </form>

                <a href="admin_super.php">Kembali</a><br>


    <?php if (isset($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>

    <script>
        function previewImage(input) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
</body>

</html>
