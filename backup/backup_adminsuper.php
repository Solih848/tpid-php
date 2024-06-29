<?php
session_start();

if (!isset($_SESSION['username1'])) {
    header('Location: login_admin.php');
    exit();
}
$username = $_SESSION['username1']; 

include 'koneksi.php';

$query = "SELECT * FROM operator";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Halaman Admin Super</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
    <h1>Halaman Admin Super</h1>
    <p>Selamat datang, <?php echo $username; ?>!</p>
    <!-- Tabel Admin -->
    <h2>Operator Pasar</h2>
    <br>
    <a href="tambah_operator.php"><button type="button" class="btn btn-primary">Tambah Operator</button></a><br><br>

    <table class="table table-striped">
        <tr>
            <th>Username</th>
            <th>NIP</th>
            <th>Jabatan</th>
            <th>OPD</th>
            <th>Nomor WhatsApp</th>
            <th>Email</th>
            <th>Password</th>
            <th>Aksi</th>
        </tr>
        <?php
        include 'koneksi.php';
        $query_operator = "SELECT * FROM operator";
        $result_operator = mysqli_query($koneksi, $query_operator);
        while ($row = mysqli_fetch_assoc($result_operator)) {
            echo "<tr>";
            echo "<td>".$row['username']."</td>";
            echo "<td>".$row['nip']."</td>";
            echo "<td>".$row['jabatan']."</td>";
            echo "<td>".$row['opd']."</td>";
            echo "<td>".$row['whatsapp']."</td>";
            echo "<td>".$row['email']."</td>";
            echo "<td>".$row['password']."</td>";
            echo "<td><a href='edit_operator.php?username=".$row['username']."'>
      <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
        <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
        <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z'/>
      </svg></a> 
      |
       <a href='hapus_operator.php?username=".$row['username']."'>
      <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z'/>
        <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z'/>
      </svg></a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <br>

        <h2>Operator Inflasi</h2>
    <a href="halaman_inflasi.php"><button type="button" class="btn btn-primary">Halaman Operator Inflasi</button></a><br><br>
    <br>

<!--         <a href="ubah_username_operator.php"><button>Ubah Username Operator</button></a><br>
        <a href="ubah_password_operator.php"><button>Ubah Password Operator</button></a><br> -->
        <!-- <a href="edit_foto_barang.php"><button>Edit Foto</button></a><br> -->

        <h1>Ubah Username dan Password</h1><br>
    <div class="menu">
        <a href="ubah_username_super.php"><button class="btn btn-primary">Ubah Username Admin</button></a><br><br>
        <a href="ubah_password_super.php"><button class="btn btn-primary">Ubah Password Admin</button></a>
    </div>
    <br>
    <h2>Daftar Barang</h2>
    <a href="pasar.php"><button type="button" class="btn btn-primary">Tambah Pasar</button></a>
    <a href="produk.php"><button type="button" class="btn btn-primary">Tambah Produk</button></a>
    <a href="satuan.php"><button type="button" class="btn btn-primary">Tambah Satuan</button></a>
    <a href="read_sub_judul_admin.php"><button type="button" class="btn btn-primary">Edit Data Barang</button></a><br><br>
    <br>




    <form method="post" action="proses_logout_super.php">
    <button type="submit" class="btn btn-danger">Logout</button>
</form>
</div>

</body>

</html>
