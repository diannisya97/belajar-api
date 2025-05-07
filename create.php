<?php
include_once 'koneksi.php';
$nama = $_POST['nama'];
$nip = $_POST['nip'];
$alamat = $_POST['alamat'];
$sql = "INSERT INTO dosen (nama_dosen, nip, alamat) VALUES ('$nama', '$nip', '$alamat')";
$conn->query($sql);
?> 