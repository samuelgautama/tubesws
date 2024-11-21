<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php'; 


$endpoint = 'http://localhost:3030/gigspedia/query'; 


$sparql = new EasyRdf\Sparql\Client($endpoint);

// Menyusun query SPARQL
$random = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT ?band_name ?link WHERE {
    ?band uni:link_gambar ?link;
        uni:nama_band ?band_name.
}
ORDER BY RAND()
LIMIT 8

';


$result = $sparql->query($random);

?>
 <?php include 'sidebar.php';?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GigsPedia</title>
    <link rel="stylesheet" href="styles.css">
 </head>
 <body class="flex min-h-screen">

    <div class="mt-12">
            <h class="text-5xl font-bold flex justify-center mb-12 text-zinc-50">From GigsPedia To You</h>
            <div class="grid gap-14 grid-cols-4 grid-rows-2 ml-6">
            <?php foreach($result as $row){
            echo " <form method='POST' action='band_track.php'>
            <input type='hidden' name='band_name' value='" . htmlspecialchars($row->band_name) . "'>
            <button type='submit' class='card backdrop-blur-sm bg-gray-900 bg-opacity-40 w-64 h-64 shadow-2xl mb-4 rounded-lg'>
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
 </body>
 </html>



