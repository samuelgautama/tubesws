<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php'; 


$endpoint = 'http://localhost:3030/gig/query'; 


$sparql = new EasyRdf\Sparql\Client($endpoint);

$searchQuery = '';


if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['searchQuery'])) {
    $searchQuery = trim($_POST['searchQuery']);
}

// Menyusun query SPARQL
$query = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT DISTINCT ?band_name ?asal ?about ?link WHERE {
    ?band uni:nama_band ?band_name;
          uni:hasTrack ?track;
          uni:asal_band ?asal;
          uni:about_band ?about;
          uni:genre ?genre_band;
          uni:link_gambar ?link.

    ?track uni:nama_track ?track_name.
    
    FILTER (
        regex(?track_name, "' . htmlspecialchars($searchQuery) . '", "i") ||
        regex(?band_name, "' . htmlspecialchars($searchQuery) . '", "i") ||
        regex(?asal, "' . htmlspecialchars($searchQuery) . '", "i")||
        regex(?genre_band, "' . htmlspecialchars($searchQuery) . '", "i")
    )
}
';

$result = $sparql->query($query);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lagu</title>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-[color:#3C4048] to-gray-700 flex min-h-screen">

<?php include 'sidebar.php';?>

</div>
    <div class="container mt-5">
        <h1 class="font-bold text-3xl flex justify-center mb-4">Hasil Pencarian Band dari: 
        <?php
        echo $searchQuery ;
        ?>
        </h1>
         
        <table class="table table-bordered">
            <thead>
                <tr>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan hasil dalam tabel
                foreach ($result as $row) {
                    echo "<div class='card lg:card-side bg-base-100 shadow-xl flex ml-24'>
                    <div class='card-body'>
                      <img class='w-32 h-32' src='"
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