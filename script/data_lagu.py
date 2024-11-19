import requests
import json
from rdflib import Graph, URIRef, Literal, Namespace

# URL endpoint untuk mencari lagu
url = "https://spotify-scraper.p.rapidapi.com/v1/track/search"

# Parameter pencarian
querystring = {"name": "Biar Six Jamm"}  # Ganti dengan nama lagu yang diinginkan

# Header untuk autentikasi
headers = {
    "x-rapidapi-key": "065afcc0camsh8ddd21794759830p109244jsn8afdeb992d97",  # Ganti dengan kunci API Anda
    "x-rapidapi-host": "spotify-scraper.p.rapidapi.com"
}

# Mengirim permintaan GET ke API
response = requests.get(url, headers=headers, params=querystring)

# Memeriksa status kode respons
if response.status_code == 200:
    # Mengambil data dalam format JSON
    data = response.json()
    
    # Menampilkan informasi dengan format yang lebih mudah dibaca
    print("Respons API:")
    print(json.dumps(data, indent=4))  # Memformat output JSON dengan indentasi 4 spasi

    # Membuat grafik RDF
    g = Graph()
    
    # Mendefinisikan namespace
    EX = Namespace("http://example.org/")

    # Memeriksa apakah ada hasil
    if data.get("status") and data.get("type") == "track":
        track_id = data.get("id", "unknown")

        # Menggunakan ID lagu sebagai URI
        track_uri = URIRef(EX[track_id])

        # Menambahkan track ID ke grafik RDF
        g.add((track_uri, URIRef(EX.track_id), Literal(track_id)))

        # Menyimpan grafik RDF ke file dalam format RDF/XML
        g.serialize(destination='track_id_metadata.rdf', format='xml')
        print("Track ID berhasil disimpan dalam format RDF/XML sebagai 'track_id_metadata.rdf'.")
    else:
        print("Tidak ada hasil ditemukan untuk pencarian tersebut.")

else:
    # Jika terjadi kesalahan, cetak status kode dan pesan kesalahan
    print("Error fetching data:", response.status_code, response.text)