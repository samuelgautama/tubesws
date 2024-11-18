<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php'; 


$endpoint = 'http://localhost:3030/rocksearch/query'; 

$searchQuery = '';

$sparql = new EasyRdf\Sparql\Client($endpoint);


if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['searchQuery'])) {
    $searchQuery = trim($_POST['searchQuery']);
}

// Menyusun query SPARQL
$asalQuery = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT DISTINCT ?asal  WHERE {
    ?band uni:asal_band ?asal.

}
';

$genreQuery = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT DISTINCT  ?genre_band WHERE {
    ?band uni:genre ?genre_band.

}
';


$resultAsal = $sparql->query($asalQuery);
$resultGenre = $sparql->query($genreQuery);


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
<body class="h-screen bg-gradient-to-r from-[color:#3C4048] to-gray-700 flex">

    <!-- Sidebar -->
    <div class="w-64 bg-gradient-to-r from-[color:#3C4048] to-gray-700 text-white shadow-lg h-full">
        <div class="text-xl font-bold italic py-4 px-6 border-b border-gray-700">
            GigsPedia
        </div>
        <div class="overflow-y-auto h-[calc(100%-4rem)]">
            <details class="group">
                <summary class="px-6 py-2 bg-gray-700 cursor-pointer group-open:bg-gray-600 hover:bg-gray-600">
                    Region
                </summary>
                <div class="px-4 py-2">
                    <ul class="space-y-2">
                        <?php 
                        foreach($resultAsal as $row) {
                            echo  "<li>
                                    <form method='POST' action='region.php'>
                                    <input type='hidden' name='region' value='"
                                    .htmlspecialchars($row->asal).
                                    "'>
                                    <button type='submit' class='w-full text-left bg-gray-500 hover:bg-gray-400 text-white py-1 px-2 rounded'>
                                    " . htmlspecialchars($row->asal) . "
                                    </button>
                                    </form>
                                </li>";
                        }
                        ?>
                    </ul>
                </div>
            </details>
            <details class="group">
                <summary class="px-6 py-2 bg-gray-700 cursor-pointer group-open:bg-gray-600 hover:bg-gray-600">
                    Genre
                </summary>
                <div class="px-4 py-2">
                    <ul class="space-y-2">
                        <?php 
                        foreach($resultGenre as $row) {
                            echo  "<li>
                                    <form method='POST' action='genre.php'>
                                    <input type='hidden' name='genre' value='"
                                    .htmlspecialchars($row->genre_band).
                                    "'>
                                    <button type='submit' class='w-full text-left bg-gray-500 hover:bg-gray-400 text-white py-1 px-2 rounded'>
                                    " . htmlspecialchars($row->genre_band) . "
                                    </button>
                                    </form>
                                </li>";
                        }
                        ?>
                    </ul>
                </div>
            </details>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow">
        <div class="hero min-h-screen">
            <div class="hero-content flex-col lg:flex-row">
                <img src="media/gigs2.png" class="max-w-sm rounded-lg shadow-2xl" />
                <div>
                    <h1 class="text-5xl font-bold text-white">GigsPedia</h1>
                    <p class="py-6 text-gray-300">
                        Ready to Rock? Maintain to Metal? Hype to Hardcore? Find your precious music style here!
                        <br>Also recognize your local bands and listen to them!
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
