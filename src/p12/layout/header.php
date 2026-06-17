<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($pageTitle ?? 'SiMawa') ?> &mdash; SiMawa</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body { background-color: #f8f9fa; }
    .navbar-brand .subtitle { font-size: .75rem; opacity: .6; font-weight: 400; }
    .stat-card { border: none; border-radius: .75rem; }
    .table th { white-space: nowrap; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
  <div class="container">
    <a class="navbar-brand d-flex flex-column lh-1 py-1" href="/p12/index.php">
      <span class="fw-bold fs-5">SiMawa</span>
      <span class="subtitle">Sistem Informasi Mahasiswa</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav me-auto gap-1">
        <li class="nav-item">
          <a class="nav-link" href="/p12/index.php">
            <i class="bi bi-people-fill me-1"></i>Data Mahasiswa
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/p12/create.php">
            <i class="bi bi-person-plus-fill me-1"></i>Tambah Mahasiswa
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/p12/grade.php">
            <i class="bi bi-bar-chart-fill me-1"></i>Konversi Nilai
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<main class="container pb-5">
