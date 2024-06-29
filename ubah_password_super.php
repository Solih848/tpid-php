<?php
session_start();

if (!isset($_SESSION['username1'])) {
    header('Location: login_admin.php');
    exit();
}
$username = $_SESSION['username1'];


include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $new_password = $_POST['new_password'];

    $query = "UPDATE admin SET password = '$new_password' WHERE password = '$password'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header('Location: admin_super.php');
        exit();
    } else {
        $error_message = 'Gagal mengubah password. Silakan coba lagi.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ubah Password Admin</title>
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
</head>

<body class="sb-nav-fixed">
    <?php include 'lay/header.php'; ?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="card" style="margin-top:70px">
                    <div class="card-header">
                        <h1 class="card-title">Ubah Password Admin</h1>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error_message)) : ?>
                            <p class="text-danger"><?php echo $error_message; ?></p>
                        <?php endif; ?>
                        <form method="post">
                            <div class="form-group">
                                <label for="password">Password Lama:</label><br>
                                <input type="text" class="form-control" id="password" name="password" required><br>
                            </div>
                            <div class="form-group">
                                <label for="new_password">Password Baru:</label><br>
                                <input type="password" class="form-control" id="new_password" name="new_password" required><br>
                            </div>
                            <button type="submit" class="btn btn-primary">Ubah Password</button>
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