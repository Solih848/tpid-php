<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Operator Inflasi</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->
        <style type="text/css">
        .password-input-container {
            position: relative;
        }

        .password-toggle-icon {
            position: absolute;
            right: 10px; /* Adjust this value as needed to position the icon */
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .form-control {
            padding-right: 30px; /* Adjust this value to leave space for the icon */
        }

        </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Edit Operator Inflasi</h1>
            </div>
            <div class="card-body">
                <?php
                include 'koneksi.php';
                $username = $_GET['username2'];
                $query = "SELECT * FROM inflasi WHERE username2='$username'";
                $result = mysqli_query($koneksi, $query);
                $row = mysqli_fetch_assoc($result);
                ?>
                <form method="post" action="proses_edit_inflasi.php">
                    <div class="form-group">
                        <label for="username2">Nama Operator:</label><br>
                        <input type="text" class="form-control" name="username2" value="<?php echo $username; ?>" readonly><br>
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
                        <div class="password-input-container">
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $row['password']; ?>" required>
                            <span class="password-toggle-icon" onclick="togglePasswordVisibility()"><i class="fas fa-eye-slash"></i></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
        <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var toggleIcon = document.querySelector('.password-toggle-icon i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }
    </script>

</body>

</html>