<?php
if(isset($_POST['tambah'])) include 'create.php';
if(isset($_POST['update'])) include 'update.php';
if(isset($_GET['hapus'])) include 'delete.php';
include 'read.php';
?>

<!-- Form Create -->
<form method="POST">
    <input type="text" name="nama" placeholder="Nama Dosen">
    <input type="text" name="nip" placeholder="NIP">
    <textarea name="alamat" placeholder="Alamat"></textarea>
    <button type="submit" name="tambah">Tambah</button>
</form>

<!-- Tampilkan Data -->
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>NIP</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>
    <?php foreach($data_dosen as $dosen): ?>
    <tr>
        <td><?= $dosen['id'] ?></td>
        <td><?= $dosen['nama_petugas'] ?></td>
        <td><?= $dosen['no_regis'] ?></td>
        <td><?= $dosen['alamat_petugas'] ?></td>
        <td>
            <a href="?edit=<?= $dosen['id'] ?>">Edit</a>
            <a href="?hapus=<?= $dosen['id'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<!-- Form Update -->
<?php if(isset($_GET['edit'])): 
    $id = $_GET['edit'];
    include 'koneksi.php';
    $sql = "SELECT * FROM dosen WHERE id=$id";
    $dosen = $conn->query($sql)->fetch_assoc();
?>
<form method="POST">
    <input type="hidden" name="id" value="<?= $dosen['id'] ?>">
    <input type="text" name="nama" value="<?= $dosen['nama_dosen'] ?>">
    <input type="text" name="nip" value="<?= $dosen['nip'] ?>">
    <textarea name="alamat"><?= $dosen['alamat'] ?></textarea>
    <button type="submit" name="update">Update</button>
</form>
<?php endif; ?>