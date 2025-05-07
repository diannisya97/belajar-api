<?php
include_once 'koneksi.php';
$sql = "SELECT * FROM petugas";
$result = $conn->query($sql);
$data_dosen = $result->fetch_all(MYSQLI_ASSOC);
?> 