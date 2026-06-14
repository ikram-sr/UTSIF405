<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nama     = trim($_POST['nama'] ?? '');
$instansi = trim($_POST['instansi'] ?? '');
$tujuan   = trim($_POST['tujuan'] ?? '');

if ($nama === '' || $instansi === '' || $tujuan === '') {
    $msg = urlencode('Semua field wajib diisi.');
    header("Location: index.php?status=error&message={$msg}");
    exit;
}

$tanggal = date('Y-m-d');
$waktu   = date('H:i:s');

$stmt = $koneksi->prepare("INSERT INTO buku_tamu (nama, instansi, tujuan, tanggal, waktu) VALUES (?, ?, ?, ?, ?)");

if (!$stmt) {
    $msg = urlencode('Query database tidak dapat diproses.');
    header("Location: index.php?status=error&message={$msg}");
    exit;
}

$stmt->bind_param("sssss", $nama, $instansi, $tujuan, $tanggal, $waktu);

if ($stmt->execute()) {
    header("Location: index.php?status=success");
    exit;
}

$msg = urlencode('Data gagal disimpan ke database.');
header("Location: index.php?status=error&message={$msg}");
exit;
?>
