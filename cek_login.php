<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];
$level    = $_POST['level'];

$query = mysqli_query($koneksi,
    "SELECT * FROM users 
     WHERE username='$username'
     AND password='$password'
     AND level='$level'"
);

if (mysqli_num_rows($query) > 0) {
    $_SESSION['username'] = $username;
    $_SESSION['level'] = $level;

    // Arahkan sesuai role
    if ($level == "admin") {
        header("Location: semusim.php"); 
    } else if ($level == "kasir") {
        header("Location: semusim.php"); 
    }
    exit();
} else {
    echo "<script>alert('Login gagal!'); window.location='login.php';</script>";
}
?>
