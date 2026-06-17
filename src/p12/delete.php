<?php
session_start();
require_once __DIR__ . '/../shared/db.php';
require_once __DIR__ . '/../shared/csrf.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

csrf_verify();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($id) {
    $db = getDB();
    $stmt = $db->prepare('DELETE FROM mahasiswa WHERE id = ?');
    $stmt->execute([$id]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Mahasiswa berhasil dihapus.'];
    } else {
        $_SESSION['flash'] = ['type' => 'warning', 'msg' => 'Mahasiswa tidak ditemukan.'];
    }
}

header('Location: index.php');
exit;
