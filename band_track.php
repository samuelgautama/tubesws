<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php'; // Pastikan autoload diinclude

// Mengatur endpoint SPARQL
$endpoint = 'http://localhost:3030/gigspedia/query'; // Ganti dengan URL endpoint SPARQL Anda

// Membuat klien SPARQL
$sparql = new EasyRdf\Sparql\Client($endpoint);

$band_name = isset($_POST['band_name']) ? $_POST['band_name'] : '';

// Menyusun query SPARQL
$query = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT  ?band_name ?id_spotify ?link WHERE {
        ?band uni:nama_band ?band_name;
                uni:hasTrack ?track;
                uni:link_gambar ?link.

        ?track uni:id_track ?id_spotify.
    
    FILTER (regex(?band_name, "' . htmlspecialchars($band_name) . '", "i"))
}
';

$query2 = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT DISTINCT  ?band_name ?link ?tipe ?asal ?about ?genre_band WHERE {
        ?band uni:nama_band ?band_name;
                uni:link_gambar ?link;
                uni:band_type ?tipe;
                uni:asal_band ?asal;
                uni:about_band ?about;
                uni:genre ?genre_band.

    
    FILTER (regex(?band_name, "' . htmlspecialchars($band_name) . '", "i"))
}
';


$result = $sparql->query($query);
$result2 = $sparql->query($query2);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RockSearch</title>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gradient-to-r from-[color:#3C4048] to-gray-700 flex min-h-screen">

<?php include 'sidebar.php';?>



<div class="flex justify-center min-w-screen ml-6">
    <div class="container mt-5">
        <div class="flex justify-center">
        <?php foreach($result2 as $row){
               echo"<div class='hero bg-base-200  rounded-lg mb-6 ml-8 mr-8'>
                <div class='hero-content flex-col lg:flex-row'>
                  <img
                    src='".htmlspecialchars($row->link)."'
                    class='max-w-sm rounded-lg shadow-2xl' />
                  <div>
                    <h1 class='text-5xl font-bold mb-4'>".htmlspecialchars($row->band_name)."</h1>
                    <p>Genre: ".htmlspecialchars($row->genre_band)."</p>
                    <p>Tipe: ".htmlspecialchars($row->tipe)."</p>
                    <p>Asal: ".htmlspecialchars($row->asal)."</p>
                    <p class='mt-4'>
                      ".htmlspecialchars($row->about)."
                    </p>
                  </div>
                </div>
              </div>";
        }?>
        </div>
        <div class="grid gap-16 grid-cols-4 grid-rows-6 ">
                <?php
                // Menampilkan hasil dalam tabel
                foreach ($result as $row) {
                    echo "<td>" .
                    '<iframe
                     style="border-radius:12px" src="https://open.spotify.com/embed/track/' . htmlspecialchars($row->id_spotify) . '?utm_source=generator" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>' .
                    "</td>";
                echo "</tr>";
                }
                ?>
        </div>
    </div>
</div>
</body>
</html>