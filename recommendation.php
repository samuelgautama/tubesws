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
<?php include 'sidebar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GigsPedia</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="flex min-h-screen relative"> <!-- Add relative to the body -->
<div class="absolute top-5 right-5 z-50">
    <a href="javascript:void(0);" class="button" onclick="refreshPage()">
        <img id="refresh-icon" src="media/refresh-page-option.png" alt="Refresh" class="w-6 h-6 transition-transform duration-1000 ease-in">
    </a>
</div>

<script>
    function refreshPage() {
        const refreshIcon = document.getElementById('refresh-icon');
        
        // Add the spinning animation for 1 second
        refreshIcon.classList.add('animate-spin');
        
        // Reload the page after 1 second
        setTimeout(() => {
            window.location.reload();
        }, 1000);
        
        // Optionally, remove the spinning effect after 1 second
        setTimeout(() => {
            refreshIcon.classList.remove('animate-spin');
        }, 1000);
    }
</script>




    <div class="mt-12">
        <h class="text-5xl font-bold flex justify-center mb-12 text-zinc-50">From GigsPedia To You</h>
        <div class="grid gap-14 grid-cols-4 grid-rows-2 ml-6">
            <?php foreach($result as $row) {
                echo "<form method='POST' action='band_track.php'>
                <input type='hidden' name='band_name' value='" . htmlspecialchars($row->band_name) . "'>
                <button type='submit' class='card backdrop-blur-sm bg-gray-900 bg-opacity-40 w-64 h-64 shadow-2xl mb-4 rounded-lg'>
                    <figure>
                        <img class='min-w-32 min-h-48' src='".htmlspecialchars($row->link)."'/>
                    </figure>
                    <div class='card-body'>
                        <h2 class='card-title'>".htmlspecialchars(strlen($row->band_name) > 15 ? substr($row->band_name, 0, 15) . '...' : $row->band_name)."</h2>
                    </div>
                </button>
                </form>";
            }?>
        </div>
    </div>
</body>
</html>