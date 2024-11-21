<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php'; // Pastikan autoload diinclude

// Mengatur endpoint SPARQL
$endpoint = 'http://localhost:3030/gigspedia/query'; // Ganti dengan URL endpoint SPARQL Anda

// Membuat klien SPARQL
$sparql = new EasyRdf\Sparql\Client($endpoint);

$genre = isset($_POST['genre']) ? $_POST['genre'] : '';

// Menyusun query SPARQL
$query = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT  ?band_name ?genre_band ?about ?genre_band ?asal ?link WHERE {
        ?band uni:nama_band ?band_name;
          uni:genre ?genre_band;
          uni:about_band ?about;
          uni:link_gambar ?link;
          uni:asal_band ?asal.
    
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
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="flex">

<script>
  AOS.init();
</script>

<?php include 'sidebar.php';?>
<div class=" ml-4 flex justify-center">
    <div class="container mt-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan hasil dalam tabel
                foreach ($result as $row) {
                    echo "<div class='card lg:card-side bg-base-100 shadow-xl mb-6 ml-8 mr-8'>
                    <div class='card-body'>
                    <img class='min-w-32 min-h-48 w-48 rounded-lg' src='"
                      .htmlspecialchars($row->link).
                      "'/>
                      <h2 class='card-title'>".htmlspecialchars($row->band_name)."</h2>
                      <p>Genre: ".htmlspecialchars($row->genre_band)."</p>
                      <p>Asal: ".htmlspecialchars($row->asal)."</p>
                      <p>".htmlspecialchars($row->about)."</p>
                      <div class='card-actions justify-end'>
                        <form method='POST' action='band_track.php'>
                                <input type='hidden' name='band_name' value='" . htmlspecialchars($row->band_name) . "'>
                                     <button class='text-red font-bold hover:before:bg-redborder-red-500 relative h-[46px] w-36 overflow-hidden border border-red-500 backdrop-blur-sm bg-dark-900 px-3 text-red-500 shadow-2xl transition-all before:absolute before:bottom-0 before:left-0 before:top-0 before:z-0 before:h-full before:w-0 before:bg-red-500 before:transition-all before:duration-500 hover:text-white hover:shadow-red-500 hover:before:left-0 hover:before:w-full'><span class='relative z-10'>Listen</span></button>
                        </form>
                      </div>
                    </div>
                  </div>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>