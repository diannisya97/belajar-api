<?php
include_once 'koneksi.php';
$id = $_GET['hapus'];
$sql = "DELETE FROM dosen WHERE id=$id";
$conn->query($sql);
?> 