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
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex min-h-screen relative"> 
    <div class="absolute top-14 right-24 z-50">
        <a href="javascript:void(0);" class="button" onclick="refreshPage()">
            <img id="refresh-icon" src="media/refresh.png" alt="Refresh" class="w-10 h-10 transition-transform duration-1000 ease-in">
        </a>
    </div>

    <script>
        function refreshPage() {
            const refreshIcon = document.getElementById('refresh-icon');

            refreshIcon.classList.add('animate-spin');

            setTimeout(() => {
                window.location.reload();
            }, 1000);

            setTimeout(() => {
                refreshIcon.classList.remove('animate-spin');
            }, 1000);
        }
    </script>

    <div class="mt-12">
        <h class="text-5xl font-bold flex justify-center mb-12 text-zinc-50">From GigsPedia To You</h>
        <div class="grid gap-14 grid-cols-4 grid-rows-2 ml-6">
            <?php foreach ($result as $row) {
                echo "<form method='POST' action='band_track.php' class='relative group block'>
                    <input type='hidden' name='band_name' value='" . ($row->band_name) . "'>
                        <button class='relative overflow-hidden bg-gray-900 bg-opacity-40 w-64 h-64 mb-4 rounded-lg transition-all duration-500 hover:scale-110 hover:shadow-md'>
            
            <!-- Image -->
            <figure>
                <img class='min-w-32 min-h-48 w-full h-full object-cover rounded-lg' src='" . ($row->link) . "'/>
            </figure>
            
            <!-- Playback Button -->
            <div class='absolute bottom-4 right-4 transform translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500'>
                <div 
                    class='flex items-center justify-center w-12 h-12 rounded-full border border-black transition-all' 
                    style='background-color: #3CAEA3;'>
                    <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-white' viewBox='0 0 24 24' fill='currentColor'>
                        <path d='M4 3v18l17-9L4 3z' />
                    </svg>
                </div>
            </div>

            <!-- Band Name -->
            <div class='absolute bottom-2 left-2 text-white text-sm font-bold bg-gray-800 bg-opacity-70 rounded px-2 py-1'>
                " . (strlen($row->band_name) > 20 ? substr($row->band_name, 0, 20) . '...' : $row->band_name) . "
            </div>
                </button>
            </form>";
            } ?>
        </div>
    </div>

</body>

</html>