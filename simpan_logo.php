<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0) {
    $target_dir = "icon/";
    $target_file = $target_dir . "Logo.png"; 
    $imageFileType = strtolower(pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["logo"]["tmp_name"]);
    if ($check !== false) {
      if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg"
        || $imageFileType == "gif") {
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
          echo "Logo berhasil disimpan di " . $target_file;
        } else {
          echo "Maaf, terjadi kesalahan saat menyimpan logo.";
        }
      } else {
        echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
      }
    } else {
      echo "File yang Anda unggah bukan gambar.";
    }
  } else {
    echo "Maaf, terjadi kesalahan saat mengunggah logo.";
  }
} else {
  header("HTTP/1.1 405 Method Not Allowed");
  echo "Metode request tidak diizinkan.";
}
?>
