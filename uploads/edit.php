<?php
include 'koneksi_sembako.php';

$id = '';
$row = array(
    'judul_produk' => '',
    'sub_judul_produk' => '',
    'nama_pasar' => '',
    'tanggal' => '',
    'satuan' => '',
    'harga_kemaren' => '',
    'harga_sekarang' => ''
);

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $query_select = "SELECT judul_produk, nama_bahan_pokok, nama_pasar, tanggal, satuan, harga_kemarin, harga_sekarang FROM sub_judul_produk WHERE id = :id";
    $stmt_select = $koneksi->prepare($query_select);
    $stmt_select->bindParam(':id', $id);
    $stmt_select->execute();

    if($stmt_select->rowCount() > 0) {
        $row = $stmt_select->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Data tidak ditemukan.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $judul_produk = $_POST['judul_produk'];
    $sub_judul_produk = $_POST['sub_judul_produk'];
    $nama_pasar = $_POST['nama_pasar'];
    $tanggal = $_POST['tanggal'];
    $satuan = $_POST['satuan'];
    $harga_kemaren = $_POST['harga_kemaren'];
    $harga_sekarang = $_POST['harga_sekarang'];

    $query_update = "UPDATE sub_judul_produk SET judul_produk = :judul_produk, nama_bahan_pokok = :sub_judul_produk, nama_pasar = :nama_pasar, tanggal = :tanggal, satuan = :satuan, harga_kemarin = :harga_kemaren, harga_sekarang = :harga_sekarang WHERE id = :id";
    $stmt_update = $koneksi->prepare($query_update);
    $stmt_update->bindParam(':id', $id);
    $stmt_update->bindParam(':judul_produk', $judul_produk);
    $stmt_update->bindParam(':sub_judul_produk', $sub_judul_produk);
    $stmt_update->bindParam(':nama_pasar', $nama_pasar);
    $stmt_update->bindParam(':tanggal', $tanggal);
    $stmt_update->bindParam(':satuan', $satuan);
    $stmt_update->bindParam(':harga_kemaren', $harga_kemaren);
    $stmt_update->bindParam(':harga_sekarang', $harga_sekarang);
    $stmt_update->execute();

    $pesan_sukses = "Data berhasil diperbarui.";

    echo "<script>alert('$pesan_sukses'); window.location='read_sub_judul_admin.php';</script>";

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Sub Judul Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            border: 1px solid #ccc; /* Solid border dengan lebar 1px dan warna #ccc */
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 45px;
            text-align: center;
            color: #333;
        }

        form {
            display: grid;
            grid-gap: 10px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        select {
            width: 100%;
            padding-right: 40px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3E%3Cpath d='M9.293 12.707a1 1 0 0 1-1.414 0l-3-3a1 1 0 1 1 1.414-1.414L8 10.586l2.293-2.293a1 1 0 1 1 1.414 1.414l-3 3z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: -20px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }

        .error {
            color: red;
            margin-top: 5px;
            font-size: 0.8em;
        }

        form label {
    margin-top: 13px; /* Menambahkan jarak 10px antara label dan elemen berikutnya */
    margin-bottom: -1px;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Data Barang</h1>

        <?php if(isset($pesan_sukses)) { ?>
            <div class="success-message"><?php echo $pesan_sukses; ?></div>
        <?php } ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <label for="judul_produk">Judul Produk:</label>
            <select name="judul_produk" id="judul_produk">
                <?php
                include 'koneksi.php';

                $query = "SELECT DISTINCT judul_produk FROM produk";
                $result = mysqli_query($koneksi, $query);

                while ($row_produk = mysqli_fetch_array($result)) {
                    $selected = ($row_produk['judul_produk'] == $row['judul_produk']) ? 'selected' : '';

                    echo "<option value='" . htmlspecialchars($row_produk['judul_produk']) . "' $selected>" . htmlspecialchars($row_produk['judul_produk']) . "</option>";
                }
                ?>
            </select>
                        <!-- Form fields continued... -->
            <label for="sub_judul_produk">Sub Judul Produk:</label>
            <select name="sub_judul_produk" id="sub_judul_produk">
                <!-- Daftar sub judul produk akan di-generate melalui JavaScript -->
            </select>

            <label for="nama_pasar">Nama Pasar:</label>
            <select name="nama_pasar" id="nama_pasar">
                <?php
                $query_pasar = "SELECT id, nama_pasar FROM pasar";
                $result_pasar = mysqli_query($koneksi, $query_pasar);

                while ($row_pasar = mysqli_fetch_array($result_pasar)) {
                    $selected = ($row_pasar['nama_pasar'] == $row['nama_pasar']) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($row_pasar['nama_pasar']) . "' $selected>" . htmlspecialchars($row_pasar['nama_pasar']) . "</option>";
                }
                ?>
            </select>
            <label for="tanggal">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" value="<?php echo isset($row['tanggal']) ? htmlspecialchars($row['tanggal']) : ''; ?>" style="width: calc(100% - 0px);">

            <label for="satuan">Satuan:</label>
            <select name="satuan" id="satuan" style="width: calc(100% - 0px);">
                <?php
                $query_satuan = "SELECT id, satuan FROM satuan";
                $result_satuan = mysqli_query($koneksi, $query_satuan);

                while ($row_satuan = mysqli_fetch_array($result_satuan)) {
                    $selected = ($row_satuan['satuan'] == $row['satuan']) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($row_satuan['satuan']) . "' $selected>" . htmlspecialchars($row_satuan['satuan']) . "</option>";
                }
                ?>
            </select>
            <label for="harga_kemaren">Harga Kemaren:</label>
            <input type="text" id="harga_kemaren" name="harga_kemaren" required readonly value="<?php echo isset($row['harga_kemarin']) ? 'Rp ' . number_format($row['harga_kemarin'], 0, ',', '.') : ''; ?>" style="width: calc(100% - 0px);">

            <label for="harga_sekarang">Harga Sekarang:</label>
            <input type="text" id="harga_sekarang" name="harga_sekarang" value="<?php echo isset($row['harga_sekarang']) ? htmlspecialchars($row['harga_sekarang']) : ''; ?>" style="width: calc(100% - 0px);">
            <br><br>
            <input type="submit" id="submitBtn" value="Simpan Perubahan">
        </form>
    </div>

    <script>
        function tampilkanSubJudul() {
            var judulProduk = document.getElementById("judul_produk").value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("sub_judul_produk").innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", "get_sub_judul.php?judul_produk=" + judulProduk, true);
            xhr.send();
        }

        window.onload = function() {
            tampilkanSubJudul();
            document.getElementById("judul_produk").addEventListener("change", tampilkanSubJudul);
        };

        document.getElementById("submitBtn").addEventListener("click", function(event) {
            event.preventDefault();
            document.querySelector("form").submit();
        });
    </script>
</body>
</html>

       
