<?php
function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit();
    }
}

function check_guest() {
    if (isset($_SESSION['user_id'])) {
        header('Location: home.php');
        exit();
    }
}

function logout() {
    session_start();
    session_destroy();
    header('Location: index.php');
    exit();
}
