<?php

// Buat fungsi hitungIMT(Sberat, Stinggi) yang menghitung Indeks Massa Tubuh dan
// mengembalikan kategorinya ('Kurus', 'Normal', 'Gemuk', 'Obesitas'). Tampilkan
// hasilnya di halaman HTML.

function getBMI($weightInKg, $heightInMeter)
{
    $bmi = $weightInKg / ($heightInMeter * $heightInMeter);
    $bmi = round($bmi, 1);
    return $bmi;
}

function getBMICategory($bmi)
{
    if ($bmi < 18.5) {
        return 'Underweight';
    } elseif ($bmi < 25.0) {
        return 'Normal weight';
    } elseif ($bmi < 30.0) {
        return 'Overweight';
    } else {
        return 'Obese';
    }
}

function getIdealWeightInsight($weightKg, $heightInMeter)
{
    $heightSq = $heightInMeter * $heightInMeter;
    $idealMin = round(18.5 * $heightSq, 1);
    $idealMax = round(24.9 * $heightSq, 1);

    if (($weightKg / $heightSq) < 18.5) {
        $gain = round($idealMin - $weightKg, 1);
        return [
            'range' => "{$idealMin} kg - {$idealMax} kg",
            'message' => "You need to gain {$gain} kg to reach the normal range.",
        ];
    } elseif (($weightKg / $heightSq) <= 24.9) {
        return [
            'range' => "{$idealMin} kg - {$idealMax} kg",
            'message' => 'You are already within the normal range. Keep it up!',
        ];
    } else {
        $lose = round($weightKg - $idealMax, 1);
        return [
            'range' => "{$idealMin} kg - {$idealMax} kg",
            'message' => "You need to lose {$lose} kg to reach the normal range.",
        ];
    }
}

// --- Process form submission ---

$error = '';
$bmi = '';
$bmiCategory = '';
$insight = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
    $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);

    if ($weight === false || $height === false) {
        $error = 'Please enter valid numbers for weight and height.';
    } elseif ($weight <= 0 || $height <= 0) {
        $error = 'Weight and height must be positive numbers.';
    } else {
        $heightInMeter = $height / 100;
        $bmi = getBMI($weight, $heightInMeter);
        $bmiCategory = getBMICategory($bmi);
        $insight = getIdealWeightInsight($weight, $heightInMeter);
    }
}

$weightValue = htmlspecialchars($_POST['weight'] ?? '');
$heightValue = htmlspecialchars($_POST['height'] ?? '');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Body Mass Index Calculator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
  </head>
  <body>
    <main style="text-align: center; max-width: 800px; margin-inline: auto;">
      <h2>BMI Calculator</h2>

      <form method="POST" action="">
        <label for="weight">Weight (kg):</label>
        <input type="number" step="0.1" name="weight" id="weight" placeholder="50"
          value="<?= $weightValue ?>" required>
        <br>
        <label for="height">Height (cm):</label>
        <input type="number" step="1" name="height" id="height" placeholder="165"
          value="<?= $heightValue ?>" required>
        <br>
        <button type="submit" name="calculate">Calculate BMI</button>
      </form>

      <?php if ($error !== ''): ?>
      <p class="error"><?= $error ?></p>
      <?php endif; ?>

      <?php if ($bmi !== ''): ?>
      <h3>Result</h3>
      <table style="text-align: left; margin-inline: auto;">
        <tr>
          <th>Body Mass Index</th>
          <td><?= $bmi ?></td>
        </tr>
        <tr>
          <th>Category</th>
          <td><?= $bmiCategory ?></td>
        </tr>
        <tr>
          <th>Ideal Weight Range</th>
          <td><?= $insight['range'] ?></td>
        </tr>
        <tr>
          <th>Insight</th>
          <td><?= $insight['message'] ?></td>
        </tr>
      </table>
      <?php endif; ?>
    </main>
  </body>
</html>
