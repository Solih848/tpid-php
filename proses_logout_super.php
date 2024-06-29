<?php
session_start();

unset($_SESSION['username1']);

header('Location: index.php');
exit();
?>
