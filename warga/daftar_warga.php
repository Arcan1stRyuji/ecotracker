<?php
session_start();
require_once "../config/database.php";

/* keamanan */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

/* fungsi format WA */
function formatWA($no){
    $no = preg_replace('/[^0-9]/', '', $no);
    if(substr($no, 0, 1) === '0'){
        $no = '62' . substr($no, 1);
    }
    return $no;
}

/* search */
$keyword = $_GET['search'] ?? '';

$query = mysqli_query($conn, "
    SELECT nama, alamat, no_wa, foto
    FROM users
    WHERE role = 'warga'
    AND nama LIKE '%$keyword%'
    ORDER BY nama ASC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Warga RT 18</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f9;
}

.container {
    max-width: 1000px;
    margin: 40px auto;
}

h1 {
    margin-bottom: 15px;
    color: #0d6efd;
}

.card {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,.08);
}

.back {
    display: inline-block;
    margin-bottom: 15px;
    text-decoration: none;
    color: #0d6efd;
    font-weight: bold;
}

/* search */
.search-box {
    margin-bottom: 15px;
}

.search-box input {
    width: 100%;
    padding: 10px 14px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

/* table */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    text-align: left;
}

th {
    background: #f1f3f5;
}

tr:hover {
    background: #fafafa;
}

/* foto */
.avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
}

/* wa */
.wa-link {
    color: #198754;
    font-weight: bold;
    text-decoration: none;
}
</style>
</head>

<body>

<a href="dashboard.php" class="back">← Kembali</a>
    </div>

    <h1>Daftar Warga RT 18</h1>

    <div class="card">

        <!-- SEARCH -->
        <form class="search-box" method="get">
            <input 
                type="text" 
                name="search" 
                placeholder="Cari nama warga..."
                value="<?= htmlspecialchars($keyword); ?>"
            >
        </form>

        <?php if(mysqli_num_rows($query) == 0){ ?>
            <p>Data tidak ditemukan.</p>
        <?php } else { ?>
            <table>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No WhatsApp</th>
                </tr>

                <?php while($w = mysqli_fetch_assoc($query)) { 
                    $foto = $w['foto'] 
                        ? "../uploads/profile/".$w['foto'] 
                        : "../uploads/profile/default.png";
                    $wa = formatWA($w['no_wa']);
                ?>
                <tr>
                    <td>
                        <img src="<?= $foto ?>" class="avatar">
                    </td>
                    <td><?= htmlspecialchars($w['nama']); ?></td>
                    <td><?= htmlspecialchars($w['alamat']); ?></td>
                    <td>
                        <a href="https://wa.me/<?= $wa ?>" target="_blank" class="wa-link">
                            <?= htmlspecialchars($w['no_wa']); ?>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        <?php } ?>

    </div>
</div>

</body>
</html>
