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
  <title>Edit Logo</title>
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    .card {
      margin-top: 20px;
    }

    @media (max-width: 768px) {
      .form-group {
        margin-bottom: 10px;
        /* Menambahkan jarak antara form group dan tombol di perangkat mobile */
      }

      button {
        width: 100%;
        /* Mengatur lebar tombol menjadi 100% agar mengambil lebar penuh container */
      }
    }
  </style>

  <!-- Skrip JavaScript untuk mengubah favicon -->
  <script>
    function changeFavicon() {
      var link = document.getElementById('favicon');
      link.href = 'icon/Logo.png?v=' + new Date().getTime();
    }

    setInterval(changeFavicon, 5000); // Ganti 5000 menjadi nilai dalam milidetik yang Anda inginkan
  </script>
</head>

<body class="sb-nav-fixed">
  <?php include 'lay/header.php'; ?>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <div class="row justify-content-center">
          <div class="col-md-5">
            <!-- Card untuk pratinjau logo -->
            <div class="card">
              <div class="card-body text-center">
                <h2 class="card-title">Pratinjau Logo</h2>
                <div class="logo-preview">
                  <img id="logo-preview" class="img-fluid" src="icon/Logo.png" alt="Pratinjau Logo" style="width: 50%; height: auto;">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-5">
            <!-- Card untuk form edit logo -->
            <div class="card">
              <div class="card-body">
                <h1 class="card-title">Edit Logo</h1>
                <form id="logo-form" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="logo-file">Pilih file gambar:</label>
                    <input type="file" class="form-control-file" id="logo-file" accept="image/*">
                  </div>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script>
        const logoForm = document.getElementById('logo-form');
        const logoPreviewImage = document.getElementById('logo-preview');
        const logoFileInput = document.getElementById('logo-file');

        document.addEventListener('DOMContentLoaded', function() {
          // Tambahkan query string unik ke URL gambar pratinjau saat halaman dimuat
          logoPreviewImage.src = 'icon/Logo.png?' + new Date().getTime();
        });

        logoForm.addEventListener('submit', function(event) {
          event.preventDefault();

          const file = logoFileInput.files[0];
          if (file) {
            const formData = new FormData();
            formData.append('logo', file);

            fetch('simpan_logo.php', {
                method: 'POST',
                body: formData
              })
              .then(response => {
                if (response.ok) {
                  return response.text();
                }
                throw new Error('Terjadi kesalahan saat menyimpan logo.');
              })
              .then(result => {
                console.log(result);
                // Update src attribute of logo preview image
                logoPreviewImage.src = 'icon/Logo.png?' + new Date().getTime();
                alert('Logo berhasil disimpan!');
              })
              .catch(error => {
                console.error(error.message);
                alert('Terjadi kesalahan saat menyimpan logo.');
              });
          }
        });
      </script>
    </main>
  </div>
  </div>
  </div>
  </div>
  <link id="favicon" rel="icon" href="icon/Logo.png">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="assets/demo/chart-area-demo.js"></script>
  <script src="assets/demo/chart-bar-demo.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
  <script src="js/datatables-simple-demo.js"></script>
</body>

</html>