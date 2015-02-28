#!/usr/bin/liquidsoap

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
myplaylist = playlist(reload=14400, "/home/music/songs")

# Les jingles
jingles = playlist(reload=20000, "/home/music/jingles/playlist.pls")

# En cas de soucis, liquidsoap amorce sur le fichier de sécurité
security = single("/home/securite.ogg")

# Début de la construction du flux avec de la musique, ajoute un fondu et normalise le son des musiques
radio = smart_crossfade(normalize(myplaylist))

# Ajoute les jingles ...
radio = random(weights = [1, 4],[jingles, radio])

# Définition du live
live = input.http("Adresse du live")

# Et s'en suit la sécurité
radio = fallback(track_sensitive = false, [radio, security])
radio = fallback(track_sensitive = false, [live, radio])


# Enfin, la sortie du flux vers Icecast !
output.icecast.vorbis (host="Hôte", port=Port d'icecast, password="mot de passe source", name="Vibrations Libres", description="Don't forget your roots and culture !", mount="/radio", url="http://vibrationslibres.fr", radio)
