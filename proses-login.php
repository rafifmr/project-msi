<?php
session_start();
include('config/koneksi.php');

$user     = $_POST['username_user'];
$password = $_POST['password_user'];

$hash_pass = md5($password);

// ambil data
$username_user = htmlspecialchars($user);
$password_user = htmlspecialchars($hash_pass);

// periksa username dan password
$query = "SELECT * FROM user WHERE username_user = '$username_user' and password_user = '$password_user'";
$hasil = mysqli_query($db, $query);
$data_user = mysqli_fetch_assoc($hasil);

// cek
if ($data_user != null) {
  // jika user dan password cocok
  $_SESSION['user'] = $data_user;
  header('Location: http://localhost/si_alumni/home.php');
} else {
  // jika user dan password tidak cocok
  echo "<script>window.alert('Username atau password salah'); window.location.href='index.html'</script>";
}
