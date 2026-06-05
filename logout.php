<?php
session_start();
session_destroy(); // Menghapus memori login kamu
header("Location: index.php"); // Melempar kamu balik ke halaman Login
exit;
?>