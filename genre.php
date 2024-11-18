<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php'; // Pastikan autoload diinclude

// Mengatur endpoint SPARQL
$endpoint = 'http://localhost:3030/rocksearch/query'; // Ganti dengan URL endpoint SPARQL Anda

// Membuat klien SPARQL
$sparql = new EasyRdf\Sparql\Client($endpoint);

$genre = isset($_POST['genre']) ? $_POST['genre'] : '';

// Menyusun query SPARQL
$query = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT  ?band_name ?genre_band ?about ?link WHERE {
        ?band uni:nama_band ?band_name;
          uni:genre ?genre_band;
          uni:about_band ?about;
          uni:link_gambar ?link.
    
    FILTER (regex(?genre_band, "' . htmlspecialchars($genre) . '", "i"))
}
';

// Menjalankan query
$result = $sparql->query($query);


// Mulai tampilan HTML
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GigsPedia</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body class="bg-base-50">

<script>
  AOS.init();
</script>

<div class="navbar bg-base-100">
  <div class="flex-1">
    <a class="btn" href="index.php">GigsPedia</a>
  </div>
</div>

    <div class="container mt-5">
        <h1>Daftar Band</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan hasil dalam tabel
                foreach ($result as $row) {
                    echo "<div data-aos='fade-right' data-aos-duration='1000' class='card lg:card-side bg-base-50 shadow-xl mb-4'>
                    <div class='card-body'>
                    <img class='w-32 h-48 w-48 rounded-lg' src='"
                      .htmlspecialchars($row->link).
                      "'/>
                      <h2 class='card-title'>".htmlspecialchars($row->band_name)."</h2>
                      <p>".htmlspecialchars($row->about)."</p>
                      <div class='card-actions justify-end'>
                        <form method='POST' action='band_track.php'>
                                <input type='hidden' name='band_name' value='" . htmlspecialchars($row->band_name) . "'>
                                 <button class='btn btn-primary'>Listen</button>
                        </form>
                      </div>
                    </div>
                  </div>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>