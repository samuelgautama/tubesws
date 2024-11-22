<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php';

$endpoint = 'http://localhost:3030/gigspedia/query';

$sparql = new EasyRdf\Sparql\Client($endpoint);


$random = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT ?id_spotify ?link WHERE {
    {
        SELECT DISTINCT ?id_spotify ?link WHERE {
            ?band uni:hasTrack ?track.
            ?track uni:id_track ?id_spotify.
        }
        ORDER BY RAND()
        LIMIT 95
    }
}
ORDER BY RAND()
LIMIT 1

';


$result = $sparql->query($random);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gigspedia</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex">

    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-grow">
        <div class="hero mt-44">

            <div class="hero-content flex-col lg:flex-row">
                <img src="media/gigs2.png"
                    class="max-w-sm rounded-lg shadow-2xl transform transition duration-300 hover:brightness-125" />

                <div>
                    <h1 class="text-5xl font-bold text-white">GigsPedia</h1>
                    <p class="py-6 text-gray-300 text-1xl">
                        Ready to Rock? Maintain to Metal? Hype to Hardcore? Find your precious music style here!
                        <br>Also recognize your local bands and listen to them!
                    </p>
                </div>
            </div>
        </div>
        <div id="popup-player" class="fixed bottom-4 -right-96 opacity-0 transform transition-all duration-500">
            <!-- Text Label -->
            <div class="flex justify-center items-center bg-gray-800 text-white text-sm font-semibold py-2 px-4 rounded-t-lg">
                Special Picks for You
            </div>

            <!-- Spotify Players -->
            <?php
            foreach ($result as $row) {
                echo "<div class='flex items-center space-x-4 p-2 backdrop-blur-sm bg-gray-900 bg-opacity-40 rounded-b-lg'>" .
                    '<iframe
              style="border-radius:14px" 
              src="https://open.spotify.com/embed/track/' . ($row->id_spotify) . '?utm_source=generator&theme=0&autoplay=1" 
              width="350" 
              height="80" 
              frameBorder="0" 
              allowfullscreen="" 
              allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" 
              loading="lazy">
              </iframe>' .
                    "</div>";
            }
            ?>
        </div>

        <script>
            // Show the popup after a delay
            window.addEventListener('DOMContentLoaded', () => {
                const player = document.getElementById('popup-player');
                setTimeout(() => {
                    player.classList.remove('-right-96', 'opacity-0'); // Slide it into view
                    player.classList.add('right-4', 'opacity-100'); // Make it fully visible
                }, 2000); // Delay in milliseconds (1 second)
            });
        </script>


    </div>

</body>

</html>