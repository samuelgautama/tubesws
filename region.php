<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php'; 

$endpoint = 'http://localhost:3030/gigspedia/query'; 

$sparql = new EasyRdf\Sparql\Client($endpoint);

$region = isset($_POST['region']) ? $_POST['region'] : '';

$query = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT ?band_name ?asal ?about ?link ?genre_band ?tipe WHERE {
        ?band uni:nama_band ?band_name;
          uni:asal_band ?asal;
          uni:about_band ?about;
          uni:link_gambar ?link;
          uni:genre ?genre_band;
          uni:band_type ?tipe.
    
          FILTER (regex(?asal, "' . ($region) . '", "i"))
          }
          ORDER BY ?band_name
          ';
          
$result = $sparql->query($query);
?>

<?php include 'sidebar.php';?>

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
<body class="flex min-h-screen">

<script>
  AOS.init();
</script>

<div class="flex justify-center">
    <div class="container mt-5">
        <h class="flex justify-center text-3xl font-bold mb-4 text-zinc-50">Daftar Band</h>
        <table class="table table-bordered">
            <thead>
                <tr>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($result as $row) {
                    echo "<div class='card lg:card-side backdrop-blur-sm bg-gray-900 bg-opacity-40 shadow-2xl mb-6 ml-8 mr-8'>
                    <div class='card-body'>
                    <img class='min-w-32 min-h-48 w-48 rounded-lg' src='"
                      .($row->link).
                      "'/>
                      <h2 class='card-title'>".($row->band_name)."</h2>
                      <p>Genre: ".($row->genre_band)."</p>
                      <p>Tipe: ".($row->tipe)."</p>
                      <p>Asal: ".($row->asal)."</p>
                      <p>".($row->about)."</p>
                      <div class='card-actions justify-end'>
                        <form method='POST' action='band_track.php'>
                          <input type='hidden' name='band_name' value='" . ($row->band_name) . "'>
                              <button class='text-red font-bold hover:before:bg-[#3CAEA3] relative h-[46px] w-36 overflow-hidden border border-[#3CAEA3] backdrop-blur-sm bg-dark-900 px-3 text-[#3CAEA3] shadow-2xl transition-all before:absolute before:bottom-0 before:left-0 before:top-0 before:z-0 before:h-full before:w-0 before:bg-[#3CAEA3] before:transition-all before:duration-500 hover:text-white hover:shadow-[#3CAEA3] hover:before:left-0 hover:before:w-full'>
                                <span class='relative z-10'>Listen</span>
                              </button>
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