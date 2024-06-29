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
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Makro Ekonomi</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="sb-nav-fixed">
    <?php include 'lay/header.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4" style="padding: 100px;">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h2>Tambah Info</h2>
                            </div>
                            <div class="card-body">
                                <form id="add-form">
                                    <label for="title">Title:</label><br>
                                    <input type="text" id="title" name="title" class="form-control"><br>
                                    <label for="description">Description:</label><br>
                                    <textarea id="description" name="description" class="form-control"></textarea><br>
                                    <label for="link">Link:</label><br>
                                    <input type="text" id="link" name="link" class="form-control"><br><br>
                                    <button type="submit" class="btn btn-primary">Tambah Info</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tambahkan Bootstrap JavaScript (dan jQuery jika belum ada) -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

                <script>
                    // Function untuk menambah info baru
                    document.getElementById('add-form').addEventListener('submit', function(event) {
                        event.preventDefault();
                        const formData = new FormData(this);
                        const newInfo = {
                            title: formData.get('title'),
                            description: formData.get('description'),
                            link: formData.get('link')
                        };
                        fetch('add_info.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Data berhasil ditambahkan');
                                    window.location.href = "a_ekonomi.php";
                                } else {
                                    alert('Gagal menambahkan data');
                                }
                            })
                            .catch(error => console.error('Error adding info:', error));
                    });
                </script>
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