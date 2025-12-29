<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role']!='admin') {
    header("Location: ../auth/login.php"); exit;
}

if(isset($_POST['tambah'])){
    mysqli_query($conn,"
        INSERT INTO agenda_rt (judul,tanggal,kategori)
        VALUES ('$_POST[judul]','$_POST[tanggal]','$_POST[kategori]')
    ");
}

if(isset($_GET['hapus'])){
    mysqli_query($conn,"DELETE FROM agenda_rt WHERE id=".$_GET['hapus']);
}

$data = mysqli_query($conn,"SELECT * FROM agenda_rt ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin | Agenda</title>
<style>
body{font-family:Arial;background:#f4f6f9;padding:20px}
.card{background:#fff;padding:20px;border-radius:12px}
input,select,button{padding:10px;border-radius:8px;border:1px solid #ccc;width:100%}
button{background:#198754;color:#fff;border:none;margin-top:10px}
table{width:100%;margin-top:20px;border-collapse:collapse}
th,td{padding:12px;border-bottom:1px solid #eee}
th{background:#198754;color:#fff}
</style>
</head>
<body>

<h2>🗓️ Agenda RT</h2>
<div class="card">
<form method="POST">
<input name="judul" placeholder="Judul" required>
<input type="date" name="tanggal" required>
<select name="kategori">
<option>Rutin</option>
<option>Kesehatan</option>
<option>Keagamaan</option>
<option>Karang Taruna</option>
</select>
<button name="tambah">Tambah</button>
</form>

<table>
<tr><th>Judul</th><th>Tanggal</th><th>Kategori</th><th>Aksi</th></tr>
<?php while($a=mysqli_fetch_assoc($data)){ ?>
<tr>
<td><?=$a['judul']?></td>
<td><?=date('d-m-Y',strtotime($a['tanggal']))?></td>
<td><?=$a['kategori']?></td>
<td><a href="?hapus=<?=$a['id']?>">Hapus</a></td>
</tr>
<?php } ?>
</table>
</div>

</body>
</html>
