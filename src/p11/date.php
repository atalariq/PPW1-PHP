<?php

// Buat halaman yang menampilkan nama bulan sekarang dan berapa hari tersisa di
// bulan ini menggunakan fungsi date().
//
// Referensi:
// - https://www.php.net/manual/en/function.date.php
// - https://www.php.net/manual/en/datetime.format.php

$month = date('n'); // format: `n` dipilih karena tidak menampilkan leading zero
$day = date('j'); // format: `j` dipilih karena tidak menampilkan leading zero
$maxDays = date('t');
$remainDays = $maxDays - $day;
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Days Remainder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
  </head>
  <body>
    <main style="max-width: 800px; margin-inline: auto;">
      <h1>Bulan ke-<?= $month ?>, Hari ke-<?= $day ?></h1>
      <h2>Tersisa <?= $remainDays ?> hari lagi</h2>
    </main>
  </body>
</html>
