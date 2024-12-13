<?php
    session_start();
    // Hapus semua data sesi
    session_unset();
    // Hancurkan sesi
    session_destroy();

    // Mengarahkan pengguna ke halaman "loginUser.php"
    header("Location: index.php?page=loginUser");
    exit;
?>