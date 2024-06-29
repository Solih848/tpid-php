<?php
session_start();

if (!isset($_SESSION['username1'])) {
    header('Location: login_admin.php');
    exit();
}
$username = $_SESSION['username1'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Operator</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="sb-nav-fixed">
    <?php include 'lay/header.php'; ?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="card" style="margin-top:20px">
                    <div class="card-header">
                        <h1 class="card-title">Tambah Operator Inflasi</h1>
                    </div>
                    <div class="card-body">
                        <form method="post" action="proses_tambah_operatorinflasi.php">
                            <div class="form-group">
                                <label for="username2">Nama Operator:</label>
                                <input type="text" class="form-control" id="username2" name="username2" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label for="nip">NIP:</label>
                                <input type="text" class="form-control" id="nip" name="nip" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label for="jabatan">Jabatan:</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label for="opd">OPD:</label>
                                <input type="text" class="form-control" id="opd" name="opd" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label for="whatsapp">Nomor WhatsApp:</label>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" autocomplete="off" required>
                            </div>

                            <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Tambah Operator Inflasi</button>
                        </form>
                    </div>
                </div>

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