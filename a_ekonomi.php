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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Makro Ekonomi</title>
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
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .table-responsive {
        padding-top: 10px;
    }


    @media screen and (max-width: 900px) {
        h1 {
            display: none;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table th,
        .table td {
            text-align: center;
            white-space: nowrap;
            /* Mencegah teks dalam sel tabel untuk pindah baris */
        }

        .table a {
            padding: 5px;
            font-size: 14px;
        }

        .btn {
            margin-top: 10px;
            border: 1px solid #ccc;
            /* Sesuaikan dengan warna dan ketebalan yang Anda inginkan */
            border-radius: 5px;
            /* Untuk memberikan sudut yang lebih lembut */
            padding: 5px;
            /* Atur jarak antara border dan konten di dalamnya */
        }

        .table th.description,
        .table td.description {
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .btn-container {
            display: flex;
            /* Menggunakan flexbox */
            justify-content: center;
            /* Pusatkan konten secara horizontal */
            margin-bottom: 20px;
            /* Jarak bawah dari tombol ke konten berikutnya */
        }

    }
</style>

<body class="sb-nav-fixed">
    <?php include 'lay/header.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4" style="padding: 20px;">
                <h2 class="text-center">Edit Halaman Makro Ekonomi</h2>
                <div class="btn-container">
                    <button onclick="goToAddForm()" class="btn btn-primary"><i class="fas fa-plus"></i> Form Tambah Data</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Judul</th>
                                <th class="text-center description">Deskripsi</th>
                                <th class="text-center">Tautan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="info-list">
                        </tbody>
                    </table>
                </div>

                <script>
                    function goToAddForm() {
                        window.location.href = "t_ekonomi.php";
                    }

                    document.addEventListener("DOMContentLoaded", function() {
                        const infoList = document.getElementById('info-list');

                        // Function untuk menampilkan list info
                        function displayInfoList() {
                            fetch('ekonomi.json')
                                .then(response => response.json())
                                .then(data => {
                                    infoList.innerHTML = '';
                                    data.forEach((item, index) => {
                                        const infoItem = document.createElement('tr');
                                        // Menambahkan atribut id ke elemen judul, deskripsi, dan tautan
                                        infoItem.innerHTML = `
                                <td id="title_${index}">${item.title}</td>
                                <td class="text-center description" id="description_${index}">${item.description}</td>
                                <td><a id="link_${index}" href="${item.link}" target="_blank">${item.link}</a></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button onclick="editInfo(${index})" class="btn btn-info mr-2"><i class="fas fa-pen"></i></button>
                                        <button onclick="deleteInfo(${index})" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>

                            `;
                                        infoList.appendChild(infoItem);
                                    });
                                });
                        }

                        displayInfoList();


                        // Function untuk mengedit info
                        window.editInfo = function(index) {
                            const formData = new FormData();
                            formData.append('index', index);

                            // Meminta pengguna untuk memasukkan nilai baru atau mempertahankan nilai yang lama jika tidak ada input baru
                            const newTitle = prompt('Masukkan judul baru:') || document.getElementById(`title_${index}`).innerText;
                            const newDescription = prompt('Masukkan deskripsi baru:') || document.getElementById(`description_${index}`).innerText;
                            const newLink = prompt('Masukkan link baru:') || document.getElementById(`link_${index}`).getAttribute('href');

                            formData.append('title', newTitle);
                            formData.append('description', newDescription);
                            formData.append('link', newLink);

                            fetch('edit_info.php', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log(data.message); // Log pesan dari server
                                    displayInfoList(); // Tampilkan kembali list info setelah pengeditan
                                })
                                .catch(error => console.error('Error editing info:', error));
                        };

                        // Function untuk menghapus info
                        window.deleteInfo = function(index) {
                            const confirmation = confirm('Apakah Anda yakin ingin menghapus info ini?');
                            if (confirmation) {
                                const formData = new FormData();
                                formData.append('index', index);
                                fetch('delete_info.php', {
                                        method: 'POST',
                                        body: formData
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        console.log(data.message); // Log pesan dari server
                                        displayInfoList(); // Tampilkan kembali list info setelah penghapusan
                                    })
                                    .catch(error => console.error('Error deleting info:', error));
                            }
                        };
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