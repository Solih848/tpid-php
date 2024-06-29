<?php
session_start();

if (!isset($_SESSION['username2'])) {
    header('Location: login_inflasi.php');
    exit();
}

$host = 'localhost';
$dbname = 'sem';
$username = 'root';
$password = '';

try {
    $koneksi = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi ke database gagal: " . $e->getMessage();
    exit();
}

$updateSuccess = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $tanggal = $tahun . '-' . $bulan . '-01'; // Set the day to 1
    $inflasi = $_POST['inflasi'];
    $inflasi_tahun_kalender = $_POST['inflasi_tahun_kalender'];
    $inflasi_tahun_ke_tahun = $_POST['inflasi_tahun_ke_tahun'];

    $sql = "UPDATE data_inflasi SET tanggal = :tanggal, inflasi = :inflasi, inflasi_tahun_kalender = :inflasi_tahun_kalender, inflasi_tahun_ke_tahun = :inflasi_tahun_ke_tahun WHERE id = :id";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':tanggal', $tanggal);
    $stmt->bindParam(':inflasi', $inflasi);
    $stmt->bindParam(':inflasi_tahun_kalender', $inflasi_tahun_kalender);
    $stmt->bindParam(':inflasi_tahun_ke_tahun', $inflasi_tahun_ke_tahun);

    if ($stmt->execute()) {
        $updateSuccess = true;
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM data_inflasi WHERE id = :id";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $bulan = date('n', strtotime($data['tanggal']));
    $tahun = date('Y', strtotime($data['tanggal']));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data Inflasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="website icon" href="icon/Logo.png?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <h1 class="mb-2 text-center">Update Data Inflasi</h1>
            </div>
            <div class="card-body">
                <form method="post" action="update_inflasi2.php">
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    <div class="mb-3">
                        <label for="bulan" class="form-label">Bulan</label>
                        <select id="bulan" name="bulan" class="form-select" required>
                            <option value="">Pilih Bulan</option>
                            <?php
                            $bulan_indonesia = [
                                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                            ];
                            foreach ($bulan_indonesia as $num => $bulan_nama) {
                                $selected = $num == $bulan ? 'selected' : '';
                                echo "<option value='$num' $selected>$bulan_nama</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <select id="tahun" name="tahun" class="form-select" required>
                            <option value="">Pilih Tahun</option>
                            <?php
                            $tahun_sekarang = date("Y");
                            for ($i = $tahun_sekarang - 5; $i <= $tahun_sekarang + 5; $i++) {
                                $selected = $i == $tahun ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="inflasi" class="form-label">Inflasi Bulan Ke Bulan</label>
                        <input type="number" step="0.01" id="inflasi" name="inflasi" class="form-control" value="<?php echo $data['inflasi']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="inflasi_tahun_ke_tahun" class="form-label">Inflasi Tahun ke Tahun</label>
                        <input type="number" step="0.01" id="inflasi_tahun_ke_tahun" name="inflasi_tahun_ke_tahun" class="form-control" value="<?php echo $data['inflasi_tahun_ke_tahun']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="inflasi_tahun_kalender" class="form-label">Inflasi Tahun Kalender</label>
                        <input type="number" step="0.01" id="inflasi_tahun_kalender" name="inflasi_tahun_kalender" class="form-control" value="<?php echo $data['inflasi_tahun_kalender']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="edit_inflasi.php" class="btn btn-danger">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <?php if ($updateSuccess) : ?>
        <script>
            Swal.fire({
                title: 'Success!',
                text: 'Data inflasi berhasil diupdate!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'edit_inflasi.php';
                }
            });
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>