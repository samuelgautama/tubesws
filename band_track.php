<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php'; // Pastikan autoload diinclude

// Mengatur endpoint SPARQL
$endpoint = 'http://localhost:3030/rocksearch/query'; // Ganti dengan URL endpoint SPARQL Anda

// Membuat klien SPARQL
$sparql = new EasyRdf\Sparql\Client($endpoint);

$band_name = isset($_POST['band_name']) ? $_POST['band_name'] : '';

// Menyusun query SPARQL
$query = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT  ?band_name ?id_spotify WHERE {
        ?band uni:nama_band ?band_name;
                uni:hasTrack ?track.

        ?track uni:id_track ?id_spotify.
    
    FILTER (regex(?band_name, "' . htmlspecialchars($band_name) . '", "i"))
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
    <title>RockSearch</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body>

<div class="navbar bg-base-100">
  <div class="flex-1">
    <a class="btn" href="index.php">RockSearch</a>
  </div>
</div>

    <div class="container mt-5">
        <h1>Daftar Track</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan hasil dalam tabel
                foreach ($result as $row) {
                    echo "<td>" .
                    '<iframe style="border-radius:12px" src="https://open.spotify.com/embed/track/' . htmlspecialchars($row->id_spotify) . '?utm_source=generator" width="100%" height="152" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>' .
                    "</td>";
                echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>