<?php
session_start();
require_once "../config/database.php";

if (isset($_POST['register'])) {

    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $email  = mysqli_real_escape_string($conn, $_POST['email']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_wa  = mysqli_real_escape_string($conn, $_POST['no_wa']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // cek email sudah ada atau belum
    $cek = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>
            alert('Email sudah terdaftar');
            window.location='register.php';
        </script>";
        exit;
    }

    // insert warga
    $query = mysqli_query($conn, "
        INSERT INTO users (nama, email, alamat, no_wa, password, role)
        VALUES ('$nama','$email','$alamat','$no_wa','$password','warga')
    ");

    if ($query) {
        echo "<script>
            alert('Registrasi berhasil, silakan login');
            window.location='login.php';
        </script>";
    } else {
        echo "Gagal daftar: " . mysqli_error($conn);
    }
}
