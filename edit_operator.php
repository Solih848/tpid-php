<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Operator</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Edit Operator</h1>
            </div>
            <div class="card-body">
                <?php
                include 'koneksi.php';
                $username = $_GET['username'];
                $query = "SELECT * FROM operator WHERE username='$username'";
                $result = mysqli_query($koneksi, $query);
                $row = mysqli_fetch_assoc($result);
                ?>
                <form method="post" action="proses_edit_operator.php">
                    <div class="form-group">
                        <label for="username">Nama Operator:</label><br>
                        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" readonly><br>
                    </div>
                    <div class="form-group">
                        <label for="nip">NIP:</label><br>
                        <input type="text" class="form-control" id="nip" name="nip" value="<?php echo $row['nip']; ?>" required><br>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan:</label><br>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo $row['jabatan']; ?>" required><br>
                    </div>
                    <div class="form-group">
                        <label for="opd">OPD:</label><br>
                        <input type="text" class="form-control" id="opd" name="opd" value="<?php echo $row['opd']; ?>" required><br>
                    </div>
                    <div class="form-group">
                        <label for="whatsapp">Nomor WhatsApp:</label><br>
                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="<?php echo $row['whatsapp']; ?>" required><br>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label><br>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required><br>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label><br>
                        <input type="password" class="form-control" id="password" name="password" value="<?php echo $row['password']; ?>" required><br>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
