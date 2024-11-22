import requests
from rdflib import Graph, Namespace, URIRef, Literal
from rdflib.namespace import RDF

# Konfigurasi API
url = "https://spotify-statistics-and-stream-count.p.rapidapi.com/artist/5LyRnL0rysObxDRxzSfV1z"
headers = {
    "x-rapidapi-key": "fd44836f53msh38132121d4d2607p17b933jsnb886c23246ee",
    "x-rapidapi-host": "spotify-statistics-and-stream-count.p.rapidapi.com"
}

id_artist = ""

# Permintaan ke API
response = requests.get(url, headers=headers)
data = response.json()

# Fungsi untuk membuat RDF
def create_rdf_from_api(data):
    # Namespace
    BASE = Namespace("http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#")
    LOKAL_BAND = Namespace("http://www.semanticweb.org/nitro/ontologies/2024/10/lokal_band#")
    
    # Membuat graph RDF
    g = Graph()
    
    # Band URI
    band_uri = BASE["band107"]
    
    # Data Band
    band_name = data.get("name", "Unknown Artist")
    biography = data.get("biography", "Biography not available.")
    cover_art = data.get("coverArt", [{}])[2].get("url", "No cover art available.")
    top_tracks = data.get("topTracks", [])
    
    # Menambahkan informasi band
    g.add((band_uri, RDF.type, LOKAL_BAND.Band))
    g.add((band_uri, LOKAL_BAND.nama_band, Literal(band_name)))
    g.add((band_uri, LOKAL_BAND.about_band, Literal(biography)))
    g.add((band_uri, LOKAL_BAND.link_gambar, Literal(cover_art)))
    g.add((band_uri, LOKAL_BAND.genre, Literal("Unknown")))
    g.add((band_uri, LOKAL_BAND.band_type, Literal("Internasional"))) 
    g.add((band_uri, LOKAL_BAND.asal_band, Literal("Unknown"))) 
    
    # Menambahkan top tracks
    for i, track in enumerate(top_tracks, start=1):
        track_uri = BASE[f"band107_track{i}"]
        g.add((band_uri, LOKAL_BAND.hasTrack, track_uri))
        g.add((track_uri, RDF.type, LOKAL_BAND.Single))
        g.add((track_uri, LOKAL_BAND.id_track, Literal(track["id"])))
        g.add((track_uri, LOKAL_BAND.nama_track, Literal(track["name"])))
    
    # Serialisasi ke RDF/XML
    rdf_output = g.serialize(format="xml", encoding="utf-8")
    return rdf_output.decode("utf-8")

# Proses hasil API
rdf_result = create_rdf_from_api(data)

# Menyimpan ke file
with open("spotify_artist.rdf", "w", encoding="utf-8") as f:
    f.write(rdf_result)

# Output RDF ke konsol
print(rdf_result)
