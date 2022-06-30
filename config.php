<?php
//koneksi ke db

$server = "localhost";
$user = "root";
$pass = "";
$db = "nio_furniture";

$conn = mysqli_connect($server, $user, $pass, $db);

if (!$conn) {
    die("<script>alert('Gagal tersambung dengan database.')</script>");
}

//Function Format Rupiah
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
?>