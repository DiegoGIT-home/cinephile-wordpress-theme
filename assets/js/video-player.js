/**
 * Script Player Video Cinematografico (Lite-Player Facade)
 *
 * Attivazione on-demand dell'iframe YouTube (Due Clic GDPR) al clic o pressione tasto.
 *
 * Tema: Cinephile - Editorial Cinema Magazine
 * Ideatore: Diego Costanzo (Firenze, Italia)
 * Autore & Sviluppo: Antigravity & Gemini (Google DeepMind)
 * Realizzato con l'ausilio di Intelligenza Artificiale (AI)
 * Versione: 1.0.0 - Settembre 2026
 * Licenza: GNU General Public License v2 or later (Open Source)
 *
 * @package Cinephile
 */

document.addEventListener('DOMContentLoaded', function () {
    const players = document.querySelectorAll('.cinephile-cinema-player');
    if (!players.length) return;

    players.forEach(function (container) {
        const poster = container.querySelector('.cinema-player-poster');
        if (!poster) return;

        function startVideo() {
            const videoId = container.getAttribute('data-video-id');
            if (!videoId) return;

            // Creazione iframe pulito su dominio youtube-nocookie.com (Zero-Cookie preventivi)
            const iframe = document.createElement('iframe');
            iframe.setAttribute('src', 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(videoId) + '?autoplay=1&rel=0&modestbranding=1');
            iframe.setAttribute('title', 'Riproduttore video YouTube');
            iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
            iframe.setAttribute('allowfullscreen', 'true');
            iframe.setAttribute('frameborder', '0');
            iframe.className = 'cinema-player-iframe';

            // Sostituzione istantanea del poster con il flusso video reale
            container.innerHTML = '';
            container.appendChild(iframe);
            iframe.focus();
        }

        // Attivazione via Clic o Tocco
        poster.addEventListener('click', startVideo);

        // Accessibilità: attivazione da tastiera tramite tasto Invio o Spazio
        poster.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                startVideo();
            }
        });
    });
});
