<?php
require_once "../config/database.php";
session_start();

/* CEK ADMIN */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

/* ======================
   PROSES TAMBAH / EDIT
====================== */
if (isset($_POST['simpan'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi   = mysqli_real_escape_string($conn, $_POST['isi']);
    $id    = $_POST['id'] ?? '';

    $foto = $_POST['foto_lama'] ?? '';

    // Cek apakah ada file yang diunggah
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "../uploads/informasi/";

        // Buat folder jika belum ada
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $nama_file_baru = uniqid() . '.' . $ext;

        // Validasi format gambar
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($ext, $allowed)) {
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $nama_file_baru)) {
                // Hapus foto lama jika sedang edit
                if ($id != '' && !empty($_POST['foto_lama']) && file_exists($target_dir . $_POST['foto_lama'])) {
                    unlink($target_dir . $_POST['foto_lama']);
                }
                $foto = $nama_file_baru;
            }
        }
    }

    if ($id == '') {
        mysqli_query($conn, "INSERT INTO informasi_rt (judul, isi, foto) VALUES ('$judul', '$isi', '$foto')");
    } else {
        mysqli_query($conn, "UPDATE informasi_rt SET judul='$judul', isi='$isi', foto='$foto' WHERE id='$id'");
    }

    header("Location: dashboard.php");
    exit;
}

/* ======================
   HAPUS DATA
====================== */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM informasi_rt WHERE id='$id'");
    header("Location: dashboard.php");
}

/* ======================
   DATA INFORMASI
====================== */
$informasi = mysqli_query($conn, "SELECT * FROM informasi_rt ORDER BY created_at DESC");

/* EDIT MODE */
$edit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT * FROM informasi_rt WHERE id='$id'")
    );
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | EcoTrack RT 18</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        /* NAVBAR */
        nav {
            background: #0d6efd;
            padding: 15px 25px;
            color: white;
        }

        nav a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 20px;
        }

        /* FORM */
        .form-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .form-box h3 {
            margin-bottom: 15px;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
        }

        button {
            padding: 10px 18px;
            background: #0d6efd;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #0b5ed7;
        }

        /* CARD INFO */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .08);
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card .content {
            padding: 15px;
        }

        .card h4 {
            margin: 0 0 10px;
        }

        .card p {
            font-size: 14px;
            color: #555;
        }

        .card a {
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
            color: #0d6efd;
        }

        .card a.hapus {
            color: red;
        }

        footer {
            text-align: center;
            padding: 15px;
            margin-top: 40px;
            background: #e9ecef;
        }
    </style>
</head>

<body>

    <nav>
        🛠️ Admin EcoTrack RT 18
        <a href="dashboard.php">Dashboard</a>
        <a href="../auth/logout.php" style="float:right;">Logout</a>
    </nav>

    <div class="container">

        <!-- FORM TAMBAH / EDIT -->
        <div class="form-box">
            <h3><?= $edit ? "Edit Informasi" : "Tambah Informasi RT"; ?></h3>

            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $edit['id'] ?? ''; ?>">
                <input type="hidden" name="foto_lama" value="<?= $edit['foto'] ?? ''; ?>">

                <input type="text" name="judul" placeholder="Judul Informasi"
                    value="<?= $edit['judul'] ?? ''; ?>" required>

                <textarea name="isi" rows="4" placeholder="Isi Informasi" required><?= $edit['isi'] ?? ''; ?></textarea>

                <input type="file" name="foto">

                <button type="submit" name="simpan">
                    <?= $edit ? "Update" : "Simpan"; ?>
                </button>
            </form>
        </div>

        <!-- LIST INFORMASI -->
        <div class="grid">
            <?php while ($i = mysqli_fetch_assoc($informasi)) { ?>
                <div class="card">
                    <?php if ($i['foto']) { ?>
                        <img src="../uploads/informasi/<?= $i['foto']; ?>">
                    <?php } ?>

                    <div class="content">
                        <h4><?= htmlspecialchars($i['judul']); ?></h4>
                        <p><?= nl2br(htmlspecialchars($i['isi'])); ?></p>

                        <a href="?edit=<?= $i['id']; ?>">✏️ Edit</a>
                        <a href="?hapus=<?= $i['id']; ?>" class="hapus"
                            onclick="return confirm('Hapus data ini?')">🗑️ Hapus</a>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>

    <footer>
        © <?= date('Y'); ?> EcoTrack RT 18 — Admin Panel
    </footer>

</body>

</html>