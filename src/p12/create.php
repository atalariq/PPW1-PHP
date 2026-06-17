<?php
session_start();
require_once __DIR__ . '/../shared/db.php';
require_once __DIR__ . '/../shared/csrf.php';

$pageTitle = 'Tambah Mahasiswa';
$errors  = [];
$input   = ['nama' => '', 'nim' => '', 'prodi_id' => '', 'ipk' => '', 'semester' => ''];
$saved   = false;
$predikat = '';

$db = getDB();
$prodi = $db->query('SELECT id, nama FROM prodi ORDER BY nama')->fetchAll();
$validProdiIds = array_column($prodi, 'id');
$prodiMap = array_column($prodi, 'nama', 'id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $input['nama']     = is_string($_POST['nama'] ?? null)     ? trim($_POST['nama'])     : '';
    $input['nim']      = is_string($_POST['nim'] ?? null)      ? trim($_POST['nim'])      : '';
    $input['prodi_id'] = is_string($_POST['prodi_id'] ?? null) ? trim($_POST['prodi_id']) : '';
    $input['ipk']      = is_string($_POST['ipk'] ?? null)      ? trim($_POST['ipk'])      : '';
    $input['semester'] = is_string($_POST['semester'] ?? null) ? trim($_POST['semester']) : '';

    if ($input['nama'] === '') $errors['nama'] = 'Nama wajib diisi.';
    if ($input['nim'] === '') {
        $errors['nim'] = 'NIM wajib diisi.';
    } else {
        $chk = $db->prepare('SELECT id FROM mahasiswa WHERE nim = ?');
        $chk->execute([$input['nim']]);
        if ($chk->fetch()) $errors['nim'] = 'NIM sudah terdaftar.';
    }
    if ($input['prodi_id'] === '') {
        $errors['prodi_id'] = 'Prodi wajib dipilih.';
    } elseif (!in_array($input['prodi_id'], $validProdiIds)) {
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
        $stmt = $db->prepare(
            'INSERT INTO mahasiswa (nama, nim, prodi_id, ipk, semester) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $input['nama'],
            $input['nim'],
            (int)$input['prodi_id'],
            (float)$input['ipk'],
            (int)$input['semester'],
        ]);

        $ipk = (float)$input['ipk'];
        if ($ipk >= 3.51)      $predikat = 'Cumlaude';
        elseif ($ipk >= 3.01)  $predikat = 'Sangat Memuaskan';
        elseif ($ipk >= 2.76)  $predikat = 'Memuaskan';
        elseif ($ipk >= 2.00)  $predikat = 'Cukup';
        else                   $predikat = 'Tidak Lulus';

        $saved = true;
    }
}

require_once __DIR__ . '/layout/header.php';
?>

<?php if ($saved): ?>

  <div class="row justify-content-center">
    <div class="col-md-7">
      <div class="alert alert-success d-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill fs-5"></i>
        <span>Data mahasiswa berhasil disimpan.</span>
      </div>
      <div class="card shadow-sm">
        <div class="card-header fw-semibold bg-white">Ringkasan Data</div>
        <div class="card-body p-0">
          <table class="table mb-0">
            <tr><th class="ps-3 w-25">Nama</th><td><?= htmlspecialchars($input['nama']) ?></td></tr>
            <tr><th class="ps-3">NIM</th><td><code><?= htmlspecialchars($input['nim']) ?></code></td></tr>
            <tr><th class="ps-3">Program Studi</th><td><?= htmlspecialchars($prodiMap[$input['prodi_id']] ?? '-') ?></td></tr>
            <tr><th class="ps-3">IPK</th><td><?= number_format((float)$input['ipk'], 2) ?></td></tr>
            <tr><th class="ps-3">Semester</th><td><?= htmlspecialchars($input['semester']) ?></td></tr>
            <tr>
              <th class="ps-3">Predikat</th>
              <td>
                <?php
                  $badgeClass = match($predikat) {
                      'Cumlaude'         => 'bg-warning text-dark',
                      'Sangat Memuaskan' => 'bg-success',
                      'Memuaskan'        => 'bg-primary',
                      'Cukup'            => 'bg-secondary',
                      default            => 'bg-danger',
                  };
                ?>
                <span class="badge <?= $badgeClass ?> fs-6"><?= htmlspecialchars($predikat) ?></span>
              </td>
            </tr>
          </table>
        </div>
        <div class="card-footer bg-white d-flex gap-2">
          <a href="create.php" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Lagi
          </a>
          <a href="index.php" class="btn btn-outline-secondary">
            <i class="bi bi-list-ul me-1"></i>Lihat Semua
          </a>
        </div>
      </div>
    </div>
  </div>

<?php else: ?>

  <div class="row justify-content-center">
    <div class="col-md-7">
      <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
          <h5 class="mb-0 fw-semibold"><i class="bi bi-person-plus-fill me-2 text-primary"></i>Tambah Mahasiswa</h5>
          <small class="text-muted">Data akan disimpan ke database dan menampilkan predikat IPK.</small>
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
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i>Simpan
              </button>
              <a href="index.php" class="btn btn-outline-secondary">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
