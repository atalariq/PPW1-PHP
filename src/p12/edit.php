<?php
session_start();
require_once __DIR__ . '/../shared/db.php';
require_once __DIR__ . '/../shared/csrf.php';

$pageTitle = 'Edit Mahasiswa';
$db = getDB();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $db->prepare('SELECT * FROM mahasiswa WHERE id = ?');
$stmt->execute([$id]);
$mhs = $stmt->fetch();
if (!$mhs) {
    header('Location: index.php');
    exit;
}

$prodi = $db->query('SELECT id, nama FROM prodi ORDER BY nama')->fetchAll();
$validProdiIds = array_column($prodi, 'id');
$errors = [];
$input = [
    'nama'     => $mhs['nama'],
    'nim'      => $mhs['nim'],
    'prodi_id' => $mhs['prodi_id'],
    'ipk'      => $mhs['ipk'],
    'semester' => $mhs['semester'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $input['nama']     = is_string($_POST['nama'] ?? null)     ? trim($_POST['nama'])     : '';
    $input['nim']      = is_string($_POST['nim'] ?? null)      ? trim($_POST['nim'])      : '';
    $input['prodi_id'] = is_string($_POST['prodi_id'] ?? null) ? trim($_POST['prodi_id']) : '';
    $input['ipk']      = is_string($_POST['ipk'] ?? null)      ? trim($_POST['ipk'])      : '';
    $input['semester'] = is_string($_POST['semester'] ?? null) ? trim($_POST['semester']) : '';

    if ($input['nama'] === '') {
        $errors['nama'] = 'Nama wajib diisi.';
    } elseif (strlen($input['nama']) > 100) {
        $errors['nama'] = 'Nama maksimal 100 karakter.';
    }
    if ($input['nim'] === '') {
        $errors['nim'] = 'NIM wajib diisi.';
    } elseif (strlen($input['nim']) > 20) {
        $errors['nim'] = 'NIM maksimal 20 karakter.';
    } else {
        $chk = $db->prepare('SELECT id FROM mahasiswa WHERE nim = ? AND id != ?');
        $chk->execute([$input['nim'], $id]);
        if ($chk->fetch()) $errors['nim'] = 'NIM sudah digunakan mahasiswa lain.';
    }
    if ($input['prodi_id'] === '') {
        $errors['prodi_id'] = 'Prodi wajib dipilih.';
    } elseif (!ctype_digit($input['prodi_id']) || !in_array($input['prodi_id'], $validProdiIds)) {
        $errors['prodi_id'] = 'Prodi tidak valid.';
    }
    if ($input['ipk'] === '') {
        $errors['ipk'] = 'IPK wajib diisi.';
    } elseif (!is_numeric($input['ipk']) || $input['ipk'] < 0 || $input['ipk'] > 4) {
        $errors['ipk'] = 'IPK harus antara 0.00–4.00.';
    }
    if ($input['semester'] === '') {
        $errors['semester'] = 'Semester wajib diisi.';
    } elseif (!ctype_digit($input['semester']) || (int)$input['semester'] < 1 || (int)$input['semester'] > 14) {
        $errors['semester'] = 'Semester harus antara 1–14.';
    }

    if (empty($errors)) {
        try {
            $upd = $db->prepare(
                'UPDATE mahasiswa SET nama=?, nim=?, prodi_id=?, ipk=?, semester=? WHERE id=?'
            );
            $upd->execute([
                $input['nama'],
                $input['nim'],
                (int)$input['prodi_id'],
                (float)$input['ipk'],
                (int)$input['semester'],
                $id,
            ]);
            $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Data mahasiswa berhasil diperbarui.'];
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $errors['nim'] = 'NIM sudah digunakan mahasiswa lain (terdeteksi saat penyimpanan).';
            } else {
                throw $e;
            }
        }
    }
}

require_once __DIR__ . '/layout/header.php';
?>

<div class="row justify-content-center">
  <div class="col-md-7">
    <div class="card shadow-sm">
      <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold"><i class="bi bi-pencil-fill me-2 text-warning"></i>Edit Mahasiswa</h5>
        <small class="text-muted">Perbarui data mahasiswa yang sudah tersimpan.</small>
      </div>
      <div class="card-body">
        <form method="POST" novalidate>
          <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

          <div class="mb-3">
            <label class="form-label fw-medium">Nama</label>
            <input type="text" name="nama" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>"
                   value="<?= htmlspecialchars($input['nama']) ?>">
            <?php if (isset($errors['nama'])): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['nama']) ?></div>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label class="form-label fw-medium">NIM</label>
            <input type="text" name="nim" class="form-control <?= isset($errors['nim']) ? 'is-invalid' : '' ?>"
                   value="<?= htmlspecialchars($input['nim']) ?>">
            <?php if (isset($errors['nim'])): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['nim']) ?></div>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label class="form-label fw-medium">Program Studi</label>
            <select name="prodi_id" class="form-select <?= isset($errors['prodi_id']) ? 'is-invalid' : '' ?>">
              <option value="">-- Pilih Prodi --</option>
              <?php foreach ($prodi as $p): ?>
                <option value="<?= $p['id'] ?>" <?= $input['prodi_id'] == $p['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($p['nama']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?php if (isset($errors['prodi_id'])): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['prodi_id']) ?></div>
            <?php endif; ?>
          </div>

          <div class="row g-3 mb-3">
            <div class="col">
              <label class="form-label fw-medium">IPK</label>
              <input type="number" name="ipk" step="0.01" min="0" max="4"
                     class="form-control <?= isset($errors['ipk']) ? 'is-invalid' : '' ?>"
                     value="<?= htmlspecialchars($input['ipk']) ?>">
              <?php if (isset($errors['ipk'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['ipk']) ?></div>
              <?php endif; ?>
            </div>
            <div class="col">
              <label class="form-label fw-medium">Semester</label>
              <input type="number" name="semester" min="1" max="14"
                     class="form-control <?= isset($errors['semester']) ? 'is-invalid' : '' ?>"
                     value="<?= htmlspecialchars($input['semester']) ?>">
              <?php if (isset($errors['semester'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['semester']) ?></div>
              <?php endif; ?>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning">
              <i class="bi bi-save me-1"></i>Perbarui
            </button>
            <a href="index.php" class="btn btn-outline-secondary">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
