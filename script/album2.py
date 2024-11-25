import requests
import json
from rdflib import Graph, URIRef, Literal, Namespace

search_url = "https://spotify-scraper.p.rapidapi.com/v1/search"

tracks_url = "https://spotify-scraper.p.rapidapi.com/v1/album/tracks"

album_name = input("Masukkan nama album yang ingin dicari: ")  

# Parameter pencarian - berdasarkan nama album
search_querystring = {"term": album_name, "type": "album"} 
# Header untuk autentikasi
headers = {
    "x-rapidapi-key": "fd44836f53msh38132121d4d2607p17b933jsnb886c23246ee", 
    "x-rapidapi-host": "spotify-scraper.p.rapidapi.com"
}

search_response = requests.get(search_url, headers=headers, params=search_querystring)

if search_response.status_code == 200:
    search_data = search_response.json()

    print("Respons pencarian album:")
    print(json.dumps(search_data, indent=4))

    if search_data.get("status") and "albums" in search_data:
        
        album_data_key = "items" 
        if album_data_key in search_data["albums"]:
            albums = search_data["albums"][album_data_key]
            if albums:
                album_id = albums[0]["id"]  
                print(f"ID Album yang ditemukan: {album_id}")

                querystring = {"albumId": album_id}

                tracks_response = requests.get(tracks_url, headers=headers, params=querystring)

                if tracks_response.status_code == 200:
                    tracks_data = tracks_response.json()

                    print("Respons API untuk lagu:")
                    print(json.dumps(tracks_data, indent=4))

                    g = Graph()
                    EX = Namespace("http://example.org/")

                    if tracks_data.get("status") and "tracks" in tracks_data:
                        if isinstance(tracks_data["tracks"], dict):
                            track_data_key = "items" 
                            if track_data_key in tracks_data["tracks"]:
                                for track in tracks_data["tracks"][track_data_key]:
                                    if isinstance(track, dict):
                                        track_id = track.get("id", "unknown")
                                        track_name = track.get("name", "unknown")
                                        artist_name = track.get("artist", "unknown")
                                        track_uri = URIRef(EX[track_id])
                                        g.add((track_uri, URIRef(EX.track_id), Literal(track_id)))
                                        g.add((track_uri, URIRef(EX.track_name), Literal(track_name)))
                                        g.add((track_uri, URIRef(EX.artist), Literal(artist_name)))
                        else:
                            print("Expected 'tracks' to be a dictionary but got:", type(tracks_data["tracks"]))

                        g.serialize(destination='album_tracks_metadata.rdf', format='xml')
                        print("Data lagu berhasil disimpan di'album_tracks_metadata.rdf'.")
                    else:
                        print("Tidak ada hasil ditemukan untuk album tersebut.")
                else:
                    print("Error fetching tracks:", tracks_response.status_code, tracks_response.text)
            else:
                print("Tidak ada album ditemukan untuk pencarian tersebut.")
        else:
            print(f"Key '{album_data_key}' not found in search results.")
    else:
        print("Tidak ada hasil ditemukan untuk pencarian album tersebut.")
else:
    print("Error fetching search data:", search_response.status_code, search_response.text)