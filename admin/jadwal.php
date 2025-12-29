<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

/* TAMBAH JADWAL */
if (isset($_POST['tambah'])) {
    $tanggal = $_POST['tanggal'];
    $ket     = $_POST['keterangan'];
    $admin   = $_SESSION['user_id'];

    mysqli_query($conn, "
        INSERT INTO jadwal_ronda (tanggal, keterangan, created_by)
        VALUES ('$tanggal','$ket','$admin')
    ");
}

/* HAPUS */
if (isset($_GET['hapus'])) {
    mysqli_query($conn, "DELETE FROM jadwal_ronda WHERE id=".$_GET['hapus']);
}

$data = mysqli_query($conn, "
    SELECT j.*, u.nama 
    FROM jadwal_ronda j 
    JOIN users u ON j.created_by=u.id
    ORDER BY tanggal DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin | Jadwal Ronda</title>
<style>
body{font-family:Arial;background:#f4f6f9;padding:20px}
.card{background:#fff;padding:20px;border-radius:12px;box-shadow:0 5px 12px rgba(0,0,0,.08)}
h2{color:#0d6efd}
input,textarea,button{padding:10px;border-radius:8px;border:1px solid #ccc;width:100%}
button{background:#0d6efd;color:#fff;border:none;margin-top:10px}
table{width:100%;border-collapse:collapse;margin-top:20px}
th,td{padding:12px;border-bottom:1px solid #eee}
th{background:#0d6efd;color:#fff}
a.hapus{color:red;text-decoration:none}
</style>
</head>
<body>

<h2>📅 Kelola Jadwal Ronda</h2>

<div class="card">
<form method="POST">
    <input type="date" name="tanggal" required>
    <textarea name="keterangan" placeholder="Keterangan ronda" required></textarea>
    <button name="tambah">Tambah Jadwal</button>
</form>

<table>
<tr><th>Tanggal</th><th>Keterangan</th><th>Dibuat</th><th>Aksi</th></tr>
<?php while($r=mysqli_fetch_assoc($data)){ ?>
<tr>
<td><?=date('d-m-Y',strtotime($r['tanggal']))?></td>
<td><?=$r['keterangan']?></td>
<td><?=$r['nama']?></td>
<td><a class="hapus" href="?hapus=<?=$r['id']?>">Hapus</a></td>
</tr>
<?php } ?>
</table>
</div>

</body>
</html>
