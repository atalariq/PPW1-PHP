<?php

// Buat file PHP yang menampilkan profil dirimu (nama, NIM, prodi, asal kota) dalam
// tabel HTML yang rapi menggunakan variabel PHP.

$nama = 'Atalariq Barra Hadinugraha';
$nim = '25/557554/SV/26192';
$prodi = 'D4 Teknologi Rekayasa Perangkat Lunak';
$asal_kota = 'Boyolali';
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <title>Profil Saya</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
  </head>
  <body>
    <main style="text-align: center; max-width: 800px; margin-inline: auto;">
      <h1>Profile Mahasiswa</h1>
      <table style="text-align: left; margin-inline: auto;">
        <tr>
          <th>Nama</th>
          <td><?= $nama ?></td>
        </tr>
        <tr>
          <th>NIM</th>
          <td><?= $nim ?></td>
        </tr>
        <tr>
          <th>Program Studi</th>
          <td><?= $prodi ?></td>
        </tr>
        <tr>
          <th>Asal Kota</th>
          <td><?= $asal_kota ?></td>
        </tr>
      </table>
    </main>
  </body>
</html>
