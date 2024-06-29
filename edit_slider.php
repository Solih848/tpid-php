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
    <title>Edit Slider</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-top: 50px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        select,
        input[type="file"],
        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #0069D9;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0050A0;
        }

        /* Optional: Style for the alert popup */
        .alert {
            padding: 20px;
            background-color: #4caf50;
            color: white;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
        }

        /* Optional: Style for responsive design */
        @media only screen and (max-width: 600px) {
            form {
                padding: 10px;
            }
        }
    </style>
    <script>
        function showPopup() {
            alert("Gambar slider telah diperbarui.");
        }
    </script>
</head>

<body class="sb-nav-fixed">
    <?php include 'lay/header.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1>Edit Slider</h1>

                <?php
                $sliderFolder = 'slider/';
                $files = scandir($sliderFolder);
                $files = array_diff($files, array('.', '..'));

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['update'])) {
                        $selectedImage = $_POST['selected_image'];
                        $newImageName = $_FILES['new_image']['name']; // Menggunakan nama baru dari file yang diunggah

                        // After the line: $newImageName = $_FILES['new_image']['name'];
                        $error = '';

                        // Check for errors during file upload
                        if ($_FILES['new_image']['error'] !== UPLOAD_ERR_OK) {
                            $error = 'Terjadi kesalahan saat mengunggah gambar: ' . $_FILES['new_image']['error'];
                        }

                        // Check if a file with the same name already exists
                        if (file_exists($sliderFolder . $newImageName)) {
                            $error = 'File dengan nama yang sama sudah ada dalam folder slider.';
                        }

                        // Output error message, if any
                        if (!empty($error)) {
                            echo $error;
                            exit; // Terminate the script to prevent further execution
                        }


                        if ($_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
                            $newImage = $_FILES['new_image']['tmp_name'];

                            // Memindahkan file yang diunggah ke folder slider dengan nama baru
                            if (move_uploaded_file($newImage, $sliderFolder . $newImageName)) {
                                // Hanya menghapus file lama jika file baru berhasil diunggah
                                if ($newImageName != $selectedImage) {
                                    unlink($sliderFolder . $selectedImage);
                                }
                                echo "<script>showPopup();</script>";
                            } else {
                                echo "Gagal mengunggah gambar baru.";
                            }
                        } else {
                            echo "Terjadi kesalahan saat mengunggah gambar baru.";
                        }
                    }
                }

                if (count($files) > 0) {
                    echo "<form action='' method='post' enctype='multipart/form-data'>";
                    echo "<select name='selected_image'>";

                    foreach ($files as $file) {
                        // Hanya menambahkan opsi dropdown jika itu adalah file gambar
                        if (exif_imagetype($sliderFolder . $file)) {
                            echo "<option value='$file'>$file</option>";
                        }
                    }

                    echo "</select>";
                    echo "<input type='file' name='new_image' accept='image/*' placeholder='Pilih file foto..'>";
                    echo "<input type='submit' name='update' value='Update'>";
                    echo "</form>";
                } else {
                    echo "Tidak ada gambar dalam slider.";
                }
                ?>
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