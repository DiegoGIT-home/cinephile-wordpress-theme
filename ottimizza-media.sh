#!/usr/bin/env bash
# USO: Inserisci immagini e video in /assets/raw/. Lancia ./ottimizza-media.sh
mkdir -p assets/img assets/video assets/raw
for f in assets/raw/*.{jpg,jpeg,png}; do
  [ -e "$f" ] || continue
  cwebp -q 80 "$f" -o "assets/img/$(basename "${f%.*}").webp" && rm "$f"
done
for f in assets/raw/*.mp4; do
  [ -e "$f" ] || continue
  ffmpeg -i "$f" -vcodec libx264 -crf 28 -preset fast "assets/video/$(basename "${f%.*}")_opt.mp4" && rm "$f"
done
echo "Ottimizzazione completata. Originali eliminati."
