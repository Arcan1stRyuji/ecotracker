<?php
session_start();
require_once "../config/database.php";

if (isset($_POST['login'])) {

    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($query) === 1) {

        $user = mysqli_fetch_assoc($query);

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama']    = $user['nama'];
            $_SESSION['role']    = $user['role'];

            // 🔀 REDIRECT SESUAI ROLE
            if ($user['role'] === 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../warga/dashboard.php");
            }
            exit;
        } else {
            echo "<script>alert('Password salah');location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Email tidak ditemukan');location.href='login.php';</script>";
    }
}
