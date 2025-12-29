<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role']!='admin') {
    header("Location: ../auth/login.php"); exit;
}

if (isset($_GET['hapus'])) {
    mysqli_query($conn,"DELETE FROM laporan_warga WHERE id=".$_GET['hapus']);
}

$data = mysqli_query($conn,"
    SELECT l.*, u.nama 
    FROM laporan_warga l
    JOIN users u ON l.user_id=u.id
    ORDER BY l.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin | Laporan</title>
<style>
body{font-family:Arial;background:#f4f6f9;padding:20px}
.card{background:#fff;padding:20px;border-radius:12px}
h2{color:#dc3545}
table{width:100%;border-collapse:collapse}
th,td{padding:12px;border-bottom:1px solid #eee}
th{background:#dc3545;color:#fff}
img{max-width:80px;border-radius:6px}
a{color:red;text-decoration:none}
</style>
</head>
<body>

<h2>📢 Laporan Warga</h2>
<div class="card">
<table>
<tr><th>Nama</th><th>Judul</th><th>Isi</th><th>Foto</th><th>Aksi</th></tr>
<?php while($l=mysqli_fetch_assoc($data)){ ?>
<tr>
<td><?=$l['nama']?></td>
<td><?=$l['judul']?></td>
<td><?=$l['isi_laporan']?></td>
<td>
<?php if($l['foto']){ ?>
<img src="../uploads/laporan/<?=$l['foto']?>">
<?php } ?>
</td>
<td><a href="?hapus=<?=$l['id']?>">Hapus</a></td>
</tr>
<?php } ?>
</table>
</div>

</body>
</html>
