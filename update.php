<?php
include_once 'koneksi.php';
$id = $_POST['id'];
$nama = $_POST['nama'];
$nip = $_POST['nip'];
$alamat = $_POST['alamat'];
$sql = "UPDATE dosen SET nama_dosen='$nama', nip='$nip', alamat='$alamat' WHERE id=$id";
$conn->query($sql);
?> 