<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'uas-st-bayes';

// Membuat koneksi
$koneksi = new mysqli($host, $user, $pass, $dbname);

// Memeriksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
