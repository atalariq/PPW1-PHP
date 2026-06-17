<?php
$pageTitle = 'Konversi Nilai';

$result = null;
$error  = '';
$nilai  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nilai = is_string($_POST['nilai'] ?? null) ? trim($_POST['nilai']) : '';
    if ($nilai === '' || !is_numeric($nilai)) {
        $error = 'Nilai harus berupa angka.';
    } elseif ($nilai < 0 || $nilai > 100) {
        $error = 'Nilai harus antara 0–100.';
    } else {
        $n = (float)$nilai;
        if ($n >= 80) {
            $result = ['grade' => 'A', 'desc' => 'Sangat Baik', 'bg' => 'success', 'style' => ''];
        } elseif ($n >= 70) {
            $result = ['grade' => 'B', 'desc' => 'Baik', 'bg' => 'primary', 'style' => ''];
        } elseif ($n >= 60) {
            $result = ['grade' => 'C', 'desc' => 'Cukup', 'bg' => 'warning', 'style' => ''];
        } elseif ($n >= 50) {
            $result = ['grade' => 'D', 'desc' => 'Kurang', 'bg' => '', 'style' => 'background-color:#fd7e14'];
        } else {
            $result = ['grade' => 'E', 'desc' => 'Tidak Lulus', 'bg' => 'danger', 'style' => ''];
        }
    }
}

require_once __DIR__ . '/layout/header.php';
?>

<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>Konversi Nilai ke Grade</h5>
        <small class="text-muted">Masukkan nilai angka 0–100 untuk melihat grade huruf.</small>
      </div>
      <div class="card-body">
        <form method="POST" novalidate>
          <div class="mb-3">
            <label class="form-label fw-medium">Nilai (0–100)</label>
            <input type="number" name="nilai" min="0" max="100" step="0.01"
                   class="form-control form-control-lg <?= $error ? 'is-invalid' : '' ?>"
                   placeholder="Contoh: 85"
                   value="<?= htmlspecialchars($nilai) ?>">
            <?php if ($error): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
          </div>
          <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-arrow-right-circle me-1"></i>Konversi
          </button>
        </form>
      </div>
    </div>

    <?php if ($result): ?>
      <?php
        $cardClass = $result['bg'] ? "text-bg-{$result['bg']}" : 'text-white';
        $styleAttr = $result['style'] ? " style=\"{$result['style']}\"" : '';
      ?>
      <div class="card <?= $cardClass ?> shadow text-center"<?= $styleAttr ?>>
        <div class="card-body py-4">
          <div class="display-1 fw-bold"><?= htmlspecialchars($result['grade']) ?></div>
          <div class="fs-4 mt-1"><?= htmlspecialchars($result['desc']) ?></div>
          <div class="opacity-75 mt-2">Nilai: <?= htmlspecialchars($nilai) ?></div>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <div class="col-md-4 d-none d-md-block">
    <div class="card shadow-sm">
      <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-semibold">Tabel Konversi</h6>
      </div>
      <table class="table table-sm mb-0">
        <thead class="table-light"><tr><th>Nilai</th><th>Grade</th><th>Keterangan</th></tr></thead>
        <tbody>
          <tr><td>80–100</td><td><span class="badge bg-success">A</span></td><td>Sangat Baik</td></tr>
          <tr><td>70–79</td><td><span class="badge bg-primary">B</span></td><td>Baik</td></tr>
          <tr><td>60–69</td><td><span class="badge bg-warning text-dark">C</span></td><td>Cukup</td></tr>
          <tr><td>50–59</td><td><span class="badge text-white" style="background-color:#fd7e14">D</span></td><td>Kurang</td></tr>
          <tr><td>0–49</td><td><span class="badge bg-danger">E</span></td><td>Tidak Lulus</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
