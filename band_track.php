<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php';

$endpoint = 'http://localhost:3030/gigspedia/query';

$sparql = new EasyRdf\Sparql\Client($endpoint);

$band_name = isset($_POST['band_name']) ? $_POST['band_name'] : '';

$query = ' 
PREFIX band: <http://www.semanticweb.org/nitro/ontologies/2024/10/band#>

SELECT  ?band_name ?id_spotify ?link WHERE {
        ?band band:nama_band ?band_name;
                band:hasTrack ?track;
                band:link_gambar ?link.

        ?track band:id_track ?id_spotify.
    
    FILTER (regex(?band_name, "' . ($band_name) . '", "i"))
}
';

$query2 = '
PREFIX band: <http://www.semanticweb.org/nitro/ontologies/2024/10/band#>

SELECT DISTINCT  ?band_name ?link ?tipe ?asal ?about ?genre_band WHERE {
        ?band band:nama_band ?band_name;
                band:link_gambar ?link;
                band:band_type ?tipe;
                band:asal_band ?asal;
                band:about_band ?about;
                band:genre ?genre_band
    
    FILTER (regex(?band_name, "' . ($band_name) . '", "i"))
}
';

$result = $sparql->query($query);
$result2 = $sparql->query($query2);

$locations = [
  'United States' => ['lat' => 37.0902, 'lon' => -95.7129],
  'Indonesia' => ['lat' => -0.7893, 'lon' => 113.9213],
  'United Kingdom' => ['lat' => 55.378052, 'lon' => -3.435973],
  'Bali' => ['lat' => -8.340539, 'lon' => 115.091949],
  'Bandung' => ['lat' => -6.917464, 'lon' => 107.619125],
  'Medan' => ['lat' => 3.5950, 'lon' => 98.6740],
  'Palangkaraya' => ['lat' => -2.2112, 'lon' => 113.9213],
  'Pematangsiantar' => ['lat' => 2.9546, 'lon' => 99.0615],
  'Semarang' => ['lat' => -6.9663, 'lon' => 110.4194],
  'Surabaya' => ['lat' => -7.2504, 'lon' => 112.7688],
  'Yogyakarta' => ['lat' => -7.7956, 'lon' => 110.3695],
  'Jakarta' => ['lat' => -6.175110, 'lon' => 106.865036],
  'Brazil' => ['lat' => -14.2350, 'lon' => -51.9253],
  'Canada' => ['lat' => 56.1304, 'lon' => -106.3468],
  'France' => ['lat' => 46.6034, 'lon' => 1.8883],
  'Italy' => ['lat' => 41.8719, 'lon' => 12.5674],
  'Japan' => ['lat' => 36.2048, 'lon' => 138.2529],
  'Russia' => ['lat' => 55.7558, 'lon' => 37.6173],
  'Swedia' => ['lat' => 60.1282, 'lon' => 18.6435],
  'Australia' => ['lat' => -33.8688, 'lon' => 151.2093],
];
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $band_name ? ($band_name) . ' - Gigspedia' : 'Gigspedia'; ?></title>
  <?php
  $ogp_band_name = '';
  $ogp_about = '';
  $ogp_image = '';
  $ogp_spotify_url = '';

  if (!empty($result2)) {
    foreach ($result2 as $row) {
      $ogp_band_name = $row->band_name;
      $ogp_about = $row->about;
      $ogp_image = $row->link;
      break;
    }
  }

  if (!empty($result)) {
    foreach ($result as $row) {
      $ogp_spotify_url = 'https://open.spotify.com/track/' . $row->id_spotify;
      break;
    }
  }?>
  <meta property="og:title" content="<?php echo $ogp_band_name; ?>" />
  <meta property="og:description" content="<?php echo $ogp_about; ?>" />
  <meta property="og:image" content="<?php echo $ogp_image; ?>" />
  <meta property="og:url" content="<?php echo $ogp_spotify_url; ?>" />
  <meta property="og:type" content="music.song" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <link rel="stylesheet" href="styles.css">
</head>

<?php include 'sidebar.php'; ?>

<body class="flex min-h-screen">

  <div class="flex justify-center min-w-screen ml-6">
    <div class="container mt-5">
      <div class="flex justify-center">
        <?php foreach ($result2 as $row) {
          echo "<div class='hero backdrop-blur-sm bg-gray-900 bg-opacity-40 rounded-lg mb-8 ml-8 mr-8'>
                <div class='hero-content flex-col lg:flex-row'>
                  <img
                    src='" . ($row->link) . "'
                    class='max-w-sm rounded-lg shadow-2xl' />
                  <div>
                    <h1 class='text-5xl font-bold mb-4'>" . ($row->band_name) . "</h1>
                    <p>Genre: " . ($row->genre_band) . "</p>
                    <p>Tipe: " . ($row->tipe) . "</p>
                    <p>Asal: " . ($row->asal) . "</p>
                    <p class='mt-4'>
                      " . ($row->about) . "
                    </p>
                  </div>
                </div>
              </div>";
        } ?>

        <div id="map" class="mr-6" style="height: 350px; width: 50%;"></div>

      </div>

      <h class="flex justify-center font-bold text-3xl mb-8 text-zinc-50">Tracks</h>
      <div class="grid gap-16 grid-cols-4 grid-rows-6 ml-8 mr-8">
        <?php
        foreach ($result as $row) {
          echo "<td>" .
            '<iframe
                      style="border-radius:14px" src="https://open.spotify.com/embed/track/' . ($row->id_spotify) . '?utm_source=generator" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>' .
            "</td>";
          echo "</tr>";
        }
        ?>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {

      var bandOrigin = '<?php foreach ($result2 as $row)
                          echo ($row->asal); ?>';
      var locations = <?php echo json_encode($locations); ?>;

      if (locations[bandOrigin]) {
        var lat = locations[bandOrigin].lat;
        var lon = locations[bandOrigin].lon;

        var map = L.map('map').setView([lat, lon], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([lat, lon]).addTo(map)
          .bindPopup('Asal: ' + bandOrigin)
          .openPopup();
      } else {
        console.log('Lokasi tidak ditemukan untuk asal band: ' + bandOrigin);
      }
    });
  </script>
</body>

</html>