<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php'; 


$endpoint = 'http://localhost:3030/rocksearch/query'; 


$sparql = new EasyRdf\Sparql\Client($endpoint);

$searchQuery = '';


if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['searchQuery'])) {
    $searchQuery = trim($_POST['searchQuery']);
}

// Menyusun query SPARQL
$query = '
PREFIX uni: <http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#>

SELECT DISTINCT ?band_name ?asal ?about ?link WHERE {
    ?band uni:nama_band ?band_name;
          uni:hasTrack ?track;
          uni:asal_band ?asal;
          uni:about_band ?about;
          uni:genre ?genre_band;
          uni:link_gambar ?link.

    ?track uni:nama_track ?track_name.
    
    FILTER (
        regex(?track_name, "' . htmlspecialchars($searchQuery) . '", "i") ||
        regex(?band_name, "' . htmlspecialchars($searchQuery) . '", "i") ||
        regex(?asal, "' . htmlspecialchars($searchQuery) . '", "i")||
        regex(?genre_band, "' . htmlspecialchars($searchQuery) . '", "i")
    )
}
';

$result = $sparql->query($query);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lagu</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body>

<div class="navbar bg-base-100">
  <div class="flex-1">
    <a class="btn" href="index.php">GigsPedia</a>
  </div>

  <div class="flex-none gap-2">
  <form method="POST" class="input input-bordered flex items-center gap-2" action="search.php">
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
</div>
    <div class="container mt-5">
        <h1>Hasil Pencarian Band dari: 
        <?php
        echo $searchQuery ;
        ?>
        </h1>
         
        <table class="table table-bordered">
            <thead>
                <tr>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan hasil dalam tabel
                foreach ($result as $row) {
                    echo "<div class='card lg:card-side bg-base-100 shadow-xl'>
                    <div class='card-body'>
                      <img class='w-32 h-32' src='"
                      .htmlspecialchars($row->link).
                      "'/>
                      <h2 class='card-title'>".htmlspecialchars($row->band_name)."</h2>
                      <p>".htmlspecialchars($row->about)."</p>
                      <div class='card-actions justify-end'>
                        <form method='POST' action='band_track.php'>
                                <input type='hidden' name='band_name' value='" . htmlspecialchars($row->band_name) . "'>
                                 <button class='btn btn-primary'>Listen</button>
                        </form>
                      </div>
                    </div>
                  </div>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>