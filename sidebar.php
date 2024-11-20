<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php'; 


$endpoint = 'http://localhost:3030/band1/query'; 

$searchQuery = '';

$sparql = new EasyRdf\Sparql\Client($endpoint);


if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['searchQuery'])) {
    $searchQuery = trim($_POST['searchQuery']);
}

// Menyusun query SPARQL
$asalQuery = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT DISTINCT ?asal ?tipe WHERE {
    ?band uni:asal_band ?asal;
          uni:band_type ?tipe.

    FILTER (regex(?tipe, "Lokal", "i"))
}
  ORDER BY ?asal_band
';

$asalQuery2 = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT DISTINCT ?asal ?tipe WHERE {
    ?band uni:asal_band ?asal;
          uni:band_type ?tipe.

    FILTER (regex(?tipe, "Internasional", "i"))
}
  ORDER BY ?asal_band
';


$genreQuery = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT DISTINCT  ?genre_band WHERE {
    ?band uni:genre ?genre_band.

}
  ORDER BY ?genre_band
';


$resultAsal = $sparql->query($asalQuery);
$resultAsal2 = $sparql->query($asalQuery2);
$resultGenre = $sparql->query($genreQuery);


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

</head>

    <!-- Sidebar -->
    <div class="w-64 bg-gradient-to-r from-[color:#3C4048]/60 to-gray-700/60 text-white shadow-2xl min-h-screen mt-4">
        
        <a href="index.php" class="text-2xl font-bold italic py-4 px-6">
            GigsPedia
        </a>
        <div class="flex justify-center">
            <form method="POST" class="input input-bordered flex items-center gap-2 border-white bg-transparent mb-4 mt-4" action="search.php">
            <input type="text" name="searchQuery" class="grow" placeholder="Search" value="<?php echo htmlspecialchars($searchQuery); ?>" required />
            <button type="submit" class="h-4 w-4 opacity-70">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 16 16"
                    fill="currentColor">
                <path
                    fill-rule="evenodd"
                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                    clip-rule="evenodd" />
                </svg>
            </button>
            </form>
        </div>
        <div class="overflow-y-auto h-full">
            <details class="group">
                <summary class="px-6 py-2 bg-gradient-to-r from-[color:#3C4048]/60 to-gray-700/60 cursor-pointer group-open:bg-gray-700 hover:bg-gray-700">
                    Lokal
                </summary>
                <div class="px-4 py-2">
                    <ul class="space-y-2 ease-in-out duration-300">
                        <?php 
                        foreach($resultAsal as $row) {
                            echo  "<li class='opacity-0 translate-y-[-25px] transition-all duration-1000 ease-in-out group-open:opacity-100 group-open:translate-y-0'>
                                    <form method='POST' action='region.php'>
                                    <input type='hidden' name='region' value='"
                                    .htmlspecialchars($row->asal).
                                    "'>
                                    <button type='submit' class='w-full text-left bg-gradient-to-r from-[color:#3C4048]/60 to-gray-700/60 hover:bg-gray-700 text-white py-1 px-2 rounded'>
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
                <summary class="px-6 py-2 bg-gradient-to-r from-[color:#3C4048]/60 to-gray-700/60-gray-700 cursor-pointer group-open:bg-gray-700 hover:bg-gray-700">
                    Internasional
                </summary>
                <div class="px-4 py-2">
                    <ul class="space-y-2">
                        <?php 
                        foreach($resultAsal2 as $row) {
                            echo  "<li class='opacity-0 translate-y-[-25px] transition-all duration-1000 ease-in-out group-open:opacity-100 group-open:translate-y-0'>
                                    <form method='POST' action='region.php'>
                                    <input type='hidden' name='region' value='"
                                    .htmlspecialchars($row->asal).
                                    "'>
                                    <button type='submit' class='w-full text-left bg-gradient-to-r from-[color:#3C4048]/60 to-gray-700/60 hover:bg-gray-700 text-white py-1 px-2 rounded'>
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
                <summary class="px-6 py-2 bg-gradient-to-r from-[color:#3C4048]/60 to-gray-700/60 cursor-pointer group-open:bg-gray-700 hover:bg-gray-700">
                    Genre
                </summary>
                <div class="px-4 py-2">
                    <ul class="space-y-2">
                        <?php 
                        foreach($resultGenre as $row) {
                            echo  "<li class='opacity-0 translate-y-[-25px] transition-all duration-1000 ease-in-out group-open:opacity-100 group-open:translate-y-0'>
                                    <form method='POST' action='genre.php'>
                                    <input type='hidden' name='genre' value='"
                                    .htmlspecialchars($row->genre_band).
                                    "'>
                                    <button type='submit' class='w-full text-left bg-gradient-to-r from-[color:#3C4048]/60 to-gray-700/60 hover:bg-gray-700 text-white py-1 px-2 rounded'>
                                    " . htmlspecialchars($row->genre_band) . "
                                    </button>
                                    </form>
                                </li>";
                        }
                        ?>
                    </ul>
                </div>
            </details>
                <a href="recommendation.php" class="button px-6 py-2 bg-gradient-to-r from-[color:#3C4048]/60 to-gray-700/60 hover:bg-gray-700 w-full flex justify-start">
                    Recommendation
                </a>
            </details>
        </div>
    </div>