<?php
require_once "../config/database.php";
session_start();

if (isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email'");

    if (mysqli_num_rows($query) == 1) {
        $admin = mysqli_fetch_assoc($query);

        if (password_verify($password, $admin['password'])) {

            // 🔑 SESSION ADMIN (WAJIB INI)
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['nama']     = $admin['nama'];
            $_SESSION['role']     = 'admin';

            header("Location: dashboard.php");
            exit;
        } else {
            echo "<script>alert('Password salah');</script>";
        }
    } else {
        echo "<script>alert('Email admin tidak ditemukan');</script>";
    }
}
