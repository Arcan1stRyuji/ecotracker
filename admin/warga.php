<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role']!='admin') {
    header("Location: ../auth/login.php"); exit;
}

if(isset($_GET['hapus'])){
    mysqli_query($conn,"DELETE FROM users WHERE id=".$_GET['hapus']." AND role='warga'");
}

$data = mysqli_query($conn,"SELECT * FROM users WHERE role='warga'");
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin | Warga</title>
<style>
body{font-family:Arial;background:#f4f6f9;padding:20px}
.card{background:#fff;padding:20px;border-radius:12px}
table{width:100%;border-collapse:collapse}
th,td{padding:12px;border-bottom:1px solid #eee}
th{background:#0d6efd;color:#fff}
a{color:red;text-decoration:none}
</style>
</head>
<body>

<h2>👥 Data Warga</h2>
<div class="card">
<table>
<tr><th>Nama</th><th>Email</th><th>No HP</th><th>Aksi</th></tr>
<?php while($w=mysqli_fetch_assoc($data)){ ?>
<tr>
<td><?=$w['nama']?></td>
<td><?=$w['email']?></td>
<td><?=$w['no_wa']?></td>
<td><a href="?hapus=<?=$w['id']?>">Hapus</a></td>
</tr>
<?php } ?>
</table>
</div>

</body>
</html>
