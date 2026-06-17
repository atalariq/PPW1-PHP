<?php
session_start();
require_once __DIR__ . '/../shared/db.php';
require_once __DIR__ . '/../shared/csrf.php';

$pageTitle = 'Data Mahasiswa';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$db = getDB();

$stats = $db->query(
    'SELECT COUNT(*) AS total, IFNULL(AVG(ipk), 0) AS avg_ipk FROM mahasiswa'
)->fetch();

$stmt = $db->query(
    'SELECT m.id, m.nama, m.nim, p.nama AS prodi, m.ipk, m.semester
     FROM mahasiswa m
     LEFT JOIN prodi p ON p.id = m.prodi_id
     ORDER BY m.id DESC'
);
$rows = $stmt->fetchAll();

require_once __DIR__ . '/layout/header.php';
?>

<?php if ($flash): ?>
  <div class="alert alert-<?= htmlspecialchars($flash['type']) ?> alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($flash['msg']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-md-4">
    <div class="card stat-card bg-primary text-white shadow-sm">
      <div class="card-body d-flex align-items-center gap-3">
        <i class="bi bi-people-fill fs-2 opacity-75"></i>
        <div>
          <div class="fs-3 fw-bold lh-1"><?= $stats['total'] ?></div>
          <div class="small opacity-75">Total Mahasiswa</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="card stat-card bg-success text-white shadow-sm">
      <div class="card-body d-flex align-items-center gap-3">
        <i class="bi bi-award-fill fs-2 opacity-75"></i>
        <div>
          <div class="fs-3 fw-bold lh-1"><?= number_format((float)$stats['avg_ipk'], 2) ?></div>
          <div class="small opacity-75">Rata-rata IPK</div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
    <h5 class="mb-0 fw-semibold">Daftar Mahasiswa</h5>
    <a href="create.php" class="btn btn-primary btn-sm">
      <i class="bi bi-plus-lg me-1"></i>Tambah
    </a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0 align-middle">
        <thead class="table-dark">
          <tr>
            <th class="ps-3">No</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Prodi</th>
            <th>IPK</th>
            <th>Semester</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($rows)): ?>
            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data mahasiswa.</td></tr>
          <?php else: ?>
            <?php foreach ($rows as $i => $row): ?>
              <tr>
                <td class="ps-3 text-muted"><?= $i + 1 ?></td>
                <td class="fw-semibold"><?= htmlspecialchars($row['nama']) ?></td>
                <td><code><?= htmlspecialchars($row['nim']) ?></code></td>
                <td><?= htmlspecialchars($row['prodi'] ?? 'Tidak diketahui') ?></td>
                <td>
                  <span class="badge <?= (float)$row['ipk'] >= 3.0 ? 'bg-success' : ((float)$row['ipk'] >= 2.0 ? 'bg-warning text-dark' : 'bg-danger') ?>">
                    <?= number_format((float)$row['ipk'], 2) ?>
                  </span>
                </td>
                <td><?= htmlspecialchars($row['semester']) ?></td>
                <td class="text-center">
                  <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-warning">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form method="POST" action="delete.php" class="d-inline"
                        onsubmit="return confirm(<?= htmlspecialchars(json_encode('Hapus mahasiswa ' . $row['nama'] . '?'), ENT_QUOTES, 'UTF-8') ?>)">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
