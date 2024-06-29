<?php
session_start();

unset($_SESSION['username2']);

header('Location: index.php');
exit();
?>
