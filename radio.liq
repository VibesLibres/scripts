# Ceci est le fichier .liq de Vibrations Libres
# Il sert à faire tourner la radio
# Il met en place la diffusion automatique des musiques
# Il met en place la possibilité de diffuser en direct depuis un ordinateur
# Et pleins d'autres trucs sympathiques

# Emplacement des logs
set("log.file.path","/tmp/vibrations-libres.log")
set("harbor.icy",true)
set("harbor.bind_addr","0.0.0.0")

# Musiques
myplaylist = playlist(reload=14400, "/home/radio/musique/playlist_base")

# Les jingles
jingles = playlist(reload=20000, "/home/radio/jingles.pls")

#Les AlterJTs (alterjt.tv)
alterjts = playlist(reload=14400, "/home/radio/musique/alter_jts")

# En cas de soucis, liquidsoap amorce sur le fichier de sécurité
security = single("/home/securite.ogg")

# Début de la construction du flux avec de la musique, et les AlterJts
radio = smart_crossfade(normalize(myplaylist))

# Les playlists speciales
#creneau_prog = playlist(reload=20000, "/home/radio/musique/playlist_prog")

alterswitch = switch([({12h-13h},normalize(alterjts))])

# Ajoute les jingles ...
radio = random(weights = [1, 8],[jingles, radio])

# Définition du live
live = input.harbor(id="live", port=xxxx, password="motdepasse", "live")

# Et s'en suit la sécurité
radio = fallback(track_sensitive = false, [radio, security])
radio = fallback(track_sensitive = false, [live, radio])
radio = fallback(track_sensitive = false, [alterswitch, radio])

# Enfin, la sortie du flux vers Icecast !
output.icecast(%vorbis(samplerate=44100, channels=2, quality=0.8), host="xxxx", port=8000, password="xxxx", name="Vibrations Libres", description="Webradio militante, libre, rebelle et agitée !", mount="/radio", url="http://vibrationslibres.fr", radio)
# Sortie du flux vers Icecast, relais MP3 pour ceux et celles ne pouvant lire le format OGG
output.icecast(%mp3(bitrate=192, stereo=true, samplerate=44100), host="xxxx", port=8000, password="xxxx", name="Vibrations Libres en MP3", description="Webradio militante, libre, rebelle et agitée !", mount="/radio-nfs", url="http://vibrationslibres.fr", radio)
