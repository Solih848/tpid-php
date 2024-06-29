<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $tanggal = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-01';
    $inflasi = $_POST['inflasi'];
    $inflasiTahunKalender = $_POST['inflasiTahunKalender'];
    $inflasiTahunKeTahun = $_POST['inflasiTahunKeTahun'];

    $sql = "UPDATE data_inflasi SET tanggal=:tanggal, inflasi=:inflasi, inflasi_tahun_kalender=:inflasi_tahun_kalender, inflasi_tahun_ke_tahun=:inflasi_tahun_ke_tahun WHERE id=:id";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':tanggal', $tanggal);
    $stmt->bindParam(':inflasi', $inflasi);
    $stmt->bindParam(':inflasi_tahun_kalender', $inflasiTahunKalender);
    $stmt->bindParam(':inflasi_tahun_ke_tahun', $inflasiTahunKeTahun);
    $stmt->bindParam(':id', $id);

    try {
        $stmt->execute();
        header("Location: edit_inflasi.php?id=$id");
        exit();
    } catch (PDOException $e) {
        echo "Terjadi kesalahan saat mengupdate data inflasi: " . $e->getMessage();
    }
}

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id === null) {
    echo "ID tidak ditemukan.";
    exit();
}

$sql = "SELECT * FROM data_inflasi WHERE id=:id";
$stmt = $koneksi->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

$bulan_sekarang = date("m", strtotime($data['tanggal']));
$tahun_sekarang = date("Y", strtotime($data['tanggal']));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 40%;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="number"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Edit Data Inflasi</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            <div class="form-group">
                <label for="bulan">Bulan:</label>
                <select id="bulan" name="bulan" class="form-select" required>
                    <option value="">Pilih Bulan</option>
                    <?php
                    for ($i = 1; $i <= 12; $i++) {
                        $bulan = date("F", mktime(0, 0, 0, $i, 1));
                        $selected = ($i == $bulan_sekarang) ? 'selected' : '';
                        echo "<option value='$i' $selected>$bulan</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tahun">Tahun:</label>
                <select id="tahun" name="tahun" class="form-select" required>
                    <option value="">Pilih Tahun</option>
                    <?php
                    $tahun_ini = date("Y");
                    for ($i = $tahun_ini - 5; $i <= $tahun_ini + 5; $i++) {
                        $selected = ($i == $tahun_sekarang) ? 'selected' : '';
                        echo "<option value='$i' $selected>$i</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="inflasi">Inflasi:</label>
                <input type="number" id="inflasi" name="inflasi" step="0.01" value="<?php echo $data['inflasi']; ?>">
            </div>
            <div class="form-group">
                <label for="inflasiTahunKalender">Inflasi Tahun Kalender:</label>
                <input type="number" id="inflasiTahunKalender" name="inflasiTahunKalender" step="0.01" value="<?php echo $data['inflasi_tahun_kalender']; ?>">
            </div>
            <div class="form-group">
                <label for="inflasiTahunKeTahun">Inflasi Tahun ke Tahun:</label>
                <input type="number" id="inflasiTahunKeTahun" name="inflasiTahunKeTahun" step="0.01" value="<?php echo $data['inflasi_tahun_ke_tahun']; ?>">
            </div>
            <div class="form-group">
                <button type="submit">Update</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</body>

</html>