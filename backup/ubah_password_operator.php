<?php
session_start();

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];

    $query = "UPDATE users SET password = '$new_password' WHERE username = '$username'";
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
    <title>Ubah Password Operator</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Ubah Password Operator</h1>
            </div>
            <div class="card-body">
                <?php if (isset($error_message)) : ?>
                    <p class="text-danger"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <form method="post">
                    <div class="form-group">
                        <label for="username">Username:</label><br>
                        <input type="text" class="form-control" id="username" name="username" required><br>
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
</body>

</html>
