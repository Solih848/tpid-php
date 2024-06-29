<?php
session_start();

if (!isset($_SESSION['username2'])) {
    header('Location: login_inflasi.php');
    exit();
}
$username = $_SESSION['username2'];

$host = 'localhost';
$dbname = 'sem';
$dbusername = 'root';
$password = '';

try {
    $koneksi = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $password);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi ke database gagal: " . $e->getMessage();
    exit();
}

$sql = "SELECT id, tanggal, inflasi, inflasi_tahun_kalender, inflasi_tahun_ke_tahun FROM data_inflasi order by tanggal desc";
try {
    $stmt = $koneksi->query($sql);
    $data_inflasi = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Inflasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css" rel="stylesheet">
    <link rel="website icon" href="icon/Logo.png?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" />


    <style>
        * {
            font-family: Poppins, sans-serif;
        }

        .btn {
            padding: 6px 12px;
        }

        .tombol {
            display: flex;
            align-items: center;
            height: 10vh;
        }

        .teks {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 30px;
            position: relative;
        }

        @keyframes underlineExpand {
            from {
                width: 0;
            }

            to {
                width: 20%;
            }
        }

        .teks::after {
            content: '';
            display: block;
            height: 2px;
            background: black;
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            animation: underlineExpand 1s ease-in-out forwards;
        }

        @media (max-width: 100px) {
            @keyframes underlineExpand {
                from {
                    width: 0;
                }

                to {
                    width: 43%;
                }
            }
        }

        .mb-3 {
            margin-bottom: 3rem !important;
        }

        @media (max-width: 576px) {
            .btn-action {
                margin-top: 0.5rem;
            }
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        <h1 class="teks" style="text-align: center; margin-top: 40px; margin-bottom: 30px; font-weight: 750;">DATA INFLASI</h1>

        <h6>
            Edit text di halaman Info Inflasi
            <a href="edit_text_inflasi.php">Klik Disini</a>
        </h6>

        <!-- Form to Add New Data -->
        <form method="post" action="proses_tambah_inflasi.php" class="mb-3">
            <div class="container">
                <div class="row g-2">
                    <div class="col-12 col-md-3">
                        <select name="bulan" class="form-select" required>
                            <option value="">Pilih Bulan</option>
                            <?php
                            $bulan_indonesia = [
                                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                            ];
                            foreach ($bulan_indonesia as $num => $bulan) {
                                echo "<option value='$num'>$bulan</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="tahun" class="form-select" required>
                            <option value="">Pilih Tahun</option>
                            <?php
                            $tahun_sekarang = date("Y");
                            for ($i = $tahun_sekarang - 5; $i <= $tahun_sekarang + 5; $i++) {
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <input type="number" step="0.01" name="inflasi" class="form-control" placeholder="Inflasi Bulan ke Bulan" required>
                    </div>
                    <div class="col-12 col-md-2">
                        <input type="number" step="0.01" name="inflasi_tahun_ke_tahun" class="form-control" placeholder="Inflasi Tahun ke Tahun" required>
                    </div>
                    <div class="col-12 col-md-2">
                        <input type="number" step="0.01" name="inflasi_tahun_kalender" class="form-control" placeholder="Inflasi Tahun Kalender" required>
                    </div>
                    <div class="col-12 col-md-2">
                        <button type="submit" class="btn btn-success w-100"><i class="fa-solid fa-plus"></i> Tambah Data</button>
                    </div>
                </div>
            </div>
        </form>

        <table class="table table-success table-striped-columns" style="margin-top:10px;" id="coba">
            <thead>
                <tr>
                    <th style="text-align: center; vertical-align: middle;">Periode</th>
                    <th style="text-align: center; vertical-align: middle;">Inflasi Bulan Ke Bulan</th>
                    <th style="text-align: center; vertical-align: middle;">Inflasi Tahun ke Tahun</th>
                    <th style="text-align: center; vertical-align: middle;">Inflasi Tahun Kalender</th>

                    <th style="text-align: center; vertical-align: middle;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_inflasi as $data) :
                    $tanggal = date('F Y', strtotime($data['tanggal']));
                    $bulan = $bulan_indonesia[date('n', strtotime($data['tanggal']))];
                    $tahun = date('Y', strtotime($data['tanggal']));
                    $tanggal_bulan_tahun = $bulan . ' ' . $tahun;
                ?>
                    <tr>
                        <td style="text-align: center; vertical-align: middle;"><?php echo $tanggal_bulan_tahun; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?php echo $data['inflasi']; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?php echo $data['inflasi_tahun_ke_tahun']; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?php echo $data['inflasi_tahun_kalender']; ?></td>
                        <td style="text-align: center; vertical-align: middle;">
                            <a href="update_inflasi2.php?id=<?php echo $data['id']; ?>" class="btn btn-primary btn-action"><i class="fa-regular fa-pen-to-square"></i></a>
                            <button onclick="confirmDeletion(<?php echo $data['id']; ?>)" class="btn btn-danger btn-action"><i class="fa-regular fa-trash-can"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <form method="post" action="proses_logout_inflasi.php" class="mt-3 mb-4">
            <div class="container">
                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-power-off"></i> Logout</button>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"></script>

    <script>
        $(document).ready(function() {
            $('#coba').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                }

            });

            function confirmDeletion(id) {
                swal({
                        title: "Anda yakin ingin menghapus data ini?",
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location.href = "delete_inflasi2.php?id=" + id;
                        }
                    });
            }
        });
    </script>
</body>

</html>