<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php'; 

$endpoint = 'http://localhost:3030/gigspedia/query'; 

$sparql = new EasyRdf\Sparql\Client($endpoint);

$genre = isset($_POST['genre']) ? $_POST['genre'] : '';

$random = "
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT ?id_spotify ?genre_band
WHERE {
    ?band uni:hasTrack ?track;
          uni:genre ?genre_band.

    ?track uni:id_track ?id_spotify.

    FILTER(?genre_band = '" . $genre . "')
}
ORDER BY RAND()
LIMIT 16
";

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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen relative"> <!-- Add relative to the body -->
<div class="absolute top-14 right-24 z-50">
    <a href="javascript:void(0);" class="button" onclick="refreshPage()">
        <img id="refresh-icon" src="media/refresh2.png" alt="Refresh" class="w-10 h-10 transition-transform duration-1000 ease-in">
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
        <h class="text-5xl font-bold flex justify-center mb-12 text-zinc-50">Daftar Track</h>
        <div class="grid gap-16 grid-cols-4 grid-rows-6 ml-8 mr-8">
                <?php
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
</body>
</html>