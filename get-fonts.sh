#!/usr/bin/env bash
# USO: ./get-fonts.sh "Nome Font"
FONT_NAME="${1:-Inter}"
mkdir -p assets/fonts
UA="Mozilla/5.0 (Windows NT 10.0; Win64; x64)"
API_URL="https://fonts.googleapis.com/css2?family=$(echo "$FONT_NAME" | tr ' ' '+'):wght@400;700&display=swap"
RAW_CSS=$(curl -s -A "$UA" "$API_URL")
echo "$RAW_CSS" | grep -o 'https://[^)]*\.woff2' | sort -u | while read -r URL; do
    FILE=$(basename "$URL")
    curl -s -o "assets/fonts/${FILE}" "$URL"
done
echo "$RAW_CSS" | sed -E 's|https://[^)]+/([^/]+\.woff2)|\1|g' > assets/fonts/fonts.css
