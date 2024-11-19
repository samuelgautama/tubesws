<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php'; 


$endpoint = 'http://localhost:3030/gig/query'; 


$sparql = new EasyRdf\Sparql\Client($endpoint);

// Menyusun query SPARQL
$random = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT ?band_name ?link WHERE {
    ?band uni:link_gambar ?link;
        uni:nama_band ?band_name.
}
ORDER BY RAND()
LIMIT 10

';


$result = $sparql->query($random);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gigspedia</title>
</head>
<body class="min-h-screen bg-gradient-to-r from-[color:#3C4048] to-gray-700 flex">

        <?php include 'sidebar.php';?>

        <!-- Main Content -->
        <div class="flex-grow">
        <div class="hero mb-24 mt-56">
            <div class="hero-content flex-col lg:flex-row">
                <img src="media/gigs2.png" class="max-w-sm rounded-lg shadow-2xl" />
                <div>
                    <h1 class="text-5xl font-bold text-white">GigsPedia</h1>
                    <p class="py-6 text-gray-300 text-1xl">
                        Ready to Rock? Maintain to Metal? Hype to Hardcore? Find your precious music style here!
                        <br>Also recognize your local bands and listen to them!
                    </p>
                </div>
            </div>
        </div>

        <h class="text-5xl font-bold flex justify-center mb-12 text-zinc-50">Recommendation For You</h>
        <div class="grid gap-2 grid-cols-5 grid-rows-2 ml-6">
        <?php foreach($result as $row){
            echo " <form method='POST' action='band_track.php'>
            <input type='hidden' name='band_name' value='" . htmlspecialchars($row->band_name) . "'>
            <button type='submit' class='card bg-base-100 max-w-72 max-h-72 shadow-xl mb-4'>
            <figure>
              <img class='min-w-32 min-h-48' src='".htmlspecialchars($row->link)."'/>
           </figure>
            <div class='card-body'>
            <h2 class='card-title'>".htmlspecialchars($row->band_name)."</h2>
            </div>
          </button>
        </form>";
        }?>
    </div>
    </div>
    
</body>
</html>




