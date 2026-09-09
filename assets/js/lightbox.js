/**
 * Motore Interattivo Lightbox Polaroid e Scenografie Cinematografiche
 *
 * Gestione aperture, navigazione touch, zoom e animazioni prop scenografici.
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
    const galleries = document.querySelectorAll('figure.wp-block-gallery, .wp-block-gallery, .gallery');
    if (!galleries.length) return;

    const config = Object.assign({ preset: 'classico_master', randomRot: true }, window.ccGalleryConfig || {});
    const isMobile = window.matchMedia('(max-width: 768px)').matches;

    // Funzione di mescolamento Fisher-Yates
    function shuffle(arr) {
        const a = arr.slice();
        for (let i = a.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            const t = a[i]; a[i] = a[j]; a[j] = t;
        }
        return a;
    }

    // 1. LIVELLO SOTTOSTANTE: Pellicole 35mm e guide del tavolo (micro-variazioni analogiche stabili)
    function buildUnderProps(preset) {
        if (preset === 'none') return '';

        // Lievi micro-variazioni (±1° / ±2px) per dare vita alla superficie del tavolo
        const s1Rot = config.randomRot ? (-7 + (Math.random() * 2.2 - 1.1)).toFixed(1) : -7;
        const s1Top = config.randomRot ? (-12 + (Math.random() * 3 - 1.5)).toFixed(0) : -12;
        const s2Rot = config.randomRot ? (8 + (Math.random() * 2.2 - 1.1)).toFixed(1) : 8;
        const s2Bot = config.randomRot ? (-15 + (Math.random() * 3 - 1.5)).toFixed(0) : -15;
        const s3Rot = config.randomRot ? (-42 + (Math.random() * 3 - 1.5)).toFixed(1) : -42;
        const s5Rot = config.randomRot ? (-18 + (Math.random() * 3 - 1.5)).toFixed(1) : -18;

        const underMap = {
            strip1: '<div class="cc-prop cc-strip-1" style="transform: rotate(' + s1Rot + 'deg); top: ' + s1Top + 'px;"></div>',
            strip2: '<div class="cc-prop cc-strip-2" style="transform: rotate(' + s2Rot + 'deg); bottom: ' + s2Bot + 'px;"></div>',
            strip3: '<div class="cc-prop cc-strip-3" style="transform: rotate(' + s3Rot + 'deg);"></div>',
            strip4: '<div class="cc-prop cc-strip-4"></div>',
            strip5: '<div class="cc-prop cc-strip-5" style="transform: rotate(' + s5Rot + 'deg);"></div>',

            regBar: '<div class="cc-prop cc-director-bar" style="transform: rotate(' + (-2.5 + (Math.random() * 1.5 - 0.75)).toFixed(1) + 'deg);"></div>',
            regBoom: '<div class="cc-prop cc-boom-cable" style="transform: rotate(' + (3.5 + (Math.random() * 1.5 - 0.75)).toFixed(1) + 'deg);"></div>',

            movTrackTop: '<div class="cc-prop cc-moviola-track-top" style="transform: rotate(' + (-2 + (Math.random() * 1 - 0.5)).toFixed(1) + 'deg);"></div>',
            movTrackBot: '<div class="cc-prop cc-moviola-track-bottom" style="transform: rotate(' + (2.5 + (Math.random() * 1 - 0.5)).toFixed(1) + 'deg);"></div>',
            movFrames: '<div class="cc-prop cc-film-strip-loose" style="transform: rotate(' + (-10 + (Math.random() * 4 - 2)).toFixed(1) + 'deg);"></div>'
        };

        const underPresets = {
            classico_master: ['strip1', 'strip2', 'strip3', 'strip4', 'strip5'],
            classico_v1:     ['strip1', 'strip2', 'strip3', 'strip4', 'strip5'],
            classico_v2:     ['strip1', 'strip2'],
            classico_v3:     ['strip1', 'strip2'],

            regia_master:    ['regBar', 'regBoom'],
            regia_v1:        ['regBoom'],
            regia_v2:        ['regBar'],
            regia_v3:        ['regBoom', 'regBar'],

            moviola_master:  ['movTrackTop', 'movTrackBot', 'movFrames'],
            moviola_v1:      ['movTrackTop', 'movFrames'],
            moviola_v2:      ['movTrackBot', 'movFrames'],
            moviola_v3:      ['movTrackTop', 'movTrackBot']
        };

        const keys = underPresets[preset] || ['strip1', 'strip2', 'strip3'];
        let html = '';
        keys.forEach(function (k) {
            if (underMap[k]) html += underMap[k];
        });
        return html;
    }

    // 2. LIVELLO SOPRASTANTE: Oggetti fisici a mo' di "Fermacarte"
    // Mescolati casualmente tra gli slot perimetrali ad ogni refresh!
    function buildOverProps(preset) {
        if (preset === 'none') return '';

        const paperweights = {
            // Classico
            reel1:    { cls: 'cc-reel-1', title: 'Pizza 35mm Grande', isRound: true },
            reel2:    { cls: 'cc-reel-2', title: 'Pizza 35mm Media', isRound: true },
            reel3:    { cls: 'cc-reel-3', title: 'Pizza 16mm Piccola', isRound: true },
            can1:     { cls: 'cc-canister-1', title: 'Rullino Vintage', baseRot: -26, rotSpread: 18 },
            can2:     { cls: 'cc-canister-2', title: 'Rullino 35mm', baseRot: 68, rotSpread: 22 },

            // Regia
            regCiak:  { cls: 'cc-clapperboard-real', title: 'Ciak di Scena', baseRot: 12, rotSpread: 24 },
            regNote:  { cls: 'cc-director-notebook', title: 'Taccuino di Regia', baseRot: 8, rotSpread: 18 },
            regMega:  { cls: 'cc-megaphone-xl', title: 'Megafono da Set XL', baseRot: -22, rotSpread: 16 },
            regChair: { cls: 'cc-director-chair-xl', title: 'Sedia da Regista XL', baseRot: 14, rotSpread: 16 },
            regLamp:  { cls: 'cc-spotlight-lamp', title: 'Proiettore da Set', baseRot: -15, rotSpread: 18 },

            // Moviola
            movSciss: { cls: 'cc-editor-scissors-xl', title: 'Forbici XL da Montatore', baseRot: -32, rotSpread: 24 },
            movLoupe: { cls: 'cc-loupe-xl', title: 'Lente d\'Ingrandimento XL', baseRot: 20, rotSpread: 24 },
            movTape:  { cls: 'cc-splicing-tape', title: 'Nastro Giuntatore', isRound: true },
            movRazor: { cls: 'cc-editor-razor', title: 'Bisturi da Banco', baseRot: -12, rotSpread: 20 }
        };

        const overPresets = {
            classico_master: ['reel1', 'reel2', 'reel3', 'can1', 'can2'],
            classico_v1:     ['reel1', 'can1', 'reel3'],
            classico_v2:     ['reel1', 'reel2', 'reel3', 'can1', 'can2'],
            classico_v3:     ['reel2', 'can2'],

            regia_master:    ['regCiak', 'regNote', 'regMega', 'regChair', 'regLamp'],
            regia_v1:        ['regChair', 'regMega', 'regCiak'],
            regia_v2:        ['regCiak', 'regNote', 'regLamp'],
            regia_v3:        ['regCiak', 'regMega', 'regNote'],

            moviola_master:  ['movSciss', 'movLoupe', 'movTape', 'movRazor'],
            moviola_v1:      ['movSciss', 'movTape', 'movRazor'],
            moviola_v2:      ['movLoupe', 'movRazor', 'movTape'],
            moviola_v3:      ['movSciss', 'movLoupe', 'movRazor']
        };

        const keys = overPresets[preset] || ['reel1', 'can1'];
        const allSlots = ['tr', 'bl', 'tl', 'br', 'tc', 'bc'];

        // Se l'opzione di inclinazione/rotazione dinamica è attiva nel Customizer:
        // Mescola gli oggetti e gli slot di ancoraggio per un tavolo sempre unico
        const activeWeights = config.randomRot ? shuffle(keys) : keys;
        const activeSlots   = config.randomRot ? shuffle(allSlots) : allSlots;

        let html = '';
        activeWeights.forEach(function (key, idx) {
            const item = paperweights[key];
            if (!item) return;

            const slot = activeSlots[idx % activeSlots.length];

            let rot = 0;
            if (config.randomRot) {
                if (item.isRound) {
                    // Gli oggetti rotondi (pizze metalliche e rotolo nastro) ruotano liberamente a 360°
                    rot = Math.floor(Math.random() * 360);
                } else {
                    const spread = item.rotSpread || 16;
                    rot = (item.baseRot || 0) + (Math.random() * spread - spread / 2);
                }
            } else {
                rot = item.baseRot || 0;
            }

            // Micro-jitter traslazionale per evitare allineamenti rigidi
            const dx = config.randomRot ? (Math.random() * 12 - 6).toFixed(1) : 0;
            const dy = config.randomRot ? (Math.random() * 10 - 5).toFixed(1) : 0;

            html += '<div class="cc-prop ' + item.cls + ' cc-slot-' + slot + '" title="' + item.title + '" style="transform: rotate(' + rot.toFixed(1) + 'deg) translate(' + dx + 'px, ' + dy + 'px);"></div>';
        });

        return html;
    }

    const formats = [
        { w: '225px', h: '165px' },
        { w: '165px', h: '225px' },
        { w: '190px', h: '190px' },
        { w: '245px', h: '140px' },
        { w: '175px', h: '215px' }
    ];

    // Distribuzione omogenea sul tavolo: le foto partono su una griglia sfalsata
    // che copre l'intero rettangolo, poi una repulsione a coppie con un "gap"
    // visibile mantiene la distanza reciproca. Ritorna punti centrati sul
    // baricentro per non sbilanciare la pagina.
    function layoutPoints(items, halfW, halfH, isMobile) {
        const gap = isMobile ? 16 : 26;   // spazio visibile tra le foto (superficie del tavolo)
        const factor = 0.62;              // raggio efficace (ingombro ridotto per favorire la dispersione)
        const iterations = 160;
        const pts = [];

        for (let i = 0; i < items.length; i++) {
            const w = parseInt(items[i].fmt.w, 10);
            const h = parseInt(items[i].fmt.h, 10);
            const scale = isMobile ? 1 : (0.96 + Math.random() * 0.1);
            const r = Math.sqrt(w * w + h * h) / 2 * factor * scale;
            pts.push({ tx: 0, ty: 0, r: r, scale: scale });
        }

        // Griglia sfalsata: copre l'intera superficie fin dalla prima iterazione.
        const cols = Math.max(1, Math.ceil(Math.sqrt(items.length * halfW / halfH)));
        const rows = Math.ceil(items.length / cols);
        const cellW = (halfW * 2) / cols;
        const cellH = (halfH * 2) / rows;
        for (let i = 0; i < pts.length; i++) {
            const col = i % cols;
            const row = Math.floor(i / cols);
            pts[i].tx = -halfW + (col + 0.5) * cellW + (Math.random() * cellW * 0.4 - cellW * 0.2);
            pts[i].ty = -halfH + (row + 0.5) * cellH + (Math.random() * cellH * 0.4 - cellH * 0.2);
        }

        for (let it = 0; it < iterations; it++) {
            for (let i = 0; i < pts.length; i++) {
                for (let j = i + 1; j < pts.length; j++) {
                    const dx = pts[j].tx - pts[i].tx;
                    const dy = pts[j].ty - pts[i].ty;
                    const d = Math.sqrt(dx * dx + dy * dy);
                    const minD = pts[i].r + pts[j].r + gap;
                    if (d < minD) {
                        const ang = d > 0.001 ? Math.atan2(dy, dx) : Math.random() * Math.PI * 2;
                        const push = (minD - d) / 2 + 0.05;
                        pts[i].tx -= Math.cos(ang) * push;
                        pts[i].ty -= Math.sin(ang) * push;
                        pts[j].tx += Math.cos(ang) * push;
                        pts[j].ty += Math.sin(ang) * push;
                    }
                }
            }
            for (let i = 0; i < pts.length; i++) {
                const p = pts[i];
                const maxX = halfW - p.r * 0.5;
                const maxY = halfH - p.r * 0.5;
                p.tx = Math.max(-maxX, Math.min(maxX, p.tx));
                p.ty = Math.max(-maxY, Math.min(maxY, p.ty));
            }
        }

        let cx = 0, cy = 0;
        for (let i = 0; i < pts.length; i++) { cx += pts[i].tx; cy += pts[i].ty; }
        cx /= pts.length; cy /= pts.length;
        for (let i = 0; i < pts.length; i++) { pts[i].tx -= cx; pts[i].ty -= cy; }

        return pts;
    }

    galleries.forEach(function (gallery) {
        gallery.classList.add('gallery-stage');

        const underHTML = buildUnderProps(config.preset);
        const overHTML  = buildOverProps(config.preset);

        // 1. Layer Sottostante: Pellicole 35mm e guide di delimitazione del tavolo da lavoro (SOTTO le foto)
        if (underHTML && !gallery.querySelector('.cc-props-under')) {
            const underBox = document.createElement('div');
            underBox.className = 'cc-cinema-props cc-props-under';
            underBox.innerHTML = underHTML;
            gallery.insertBefore(underBox, gallery.firstChild);
        }

        const figures = gallery.querySelectorAll('figure.wp-block-image, .gallery-item, .wp-block-image');
        const items = Array.prototype.map.call(figures, function (fig, idx) {
            return { fig: fig, idx: idx, fmt: formats[idx % formats.length] };
        });

        // Tavolo virtuale: rettangolo orizzontale (desktop) / verticale (mobile).
        const halfW = isMobile ? 110 : 350;
        const halfH = isMobile ? 420 : 200;
        const pts = layoutPoints(items, halfW, halfH, isMobile);

        items.forEach(function (item, i) {
            const fig = item.fig;
            fig.classList.add('polaroid-item');

            const rotRange = isMobile ? [-6, 6] : [-10, 10];
            const rot = config.randomRot ? (rotRange[0] + Math.random() * (rotRange[1] - rotRange[0])) : 0;
            const z = 10 + item.idx;

            fig.style.setProperty('--w', item.fmt.w);
            fig.style.setProperty('--h', item.fmt.h);
            fig.style.setProperty('--rot', rot.toFixed(2) + 'deg');
            fig.style.setProperty('--scale', pts[i].scale.toFixed(3));
            fig.style.setProperty('--tx', pts[i].tx.toFixed(1) + 'px');
            fig.style.setProperty('--ty', pts[i].ty.toFixed(1) + 'px');
            fig.style.setProperty('--z', z);
        });

        // 2. Layer Soprastante: Oggetti fisici "fermacarte" (pizze, rullini, ciak, forbici, lenti) che poggiano SOPRA le foto
        if (overHTML && !gallery.querySelector('.cc-props-over')) {
            const overBox = document.createElement('div');
            overBox.className = 'cc-cinema-props cc-props-over';
            overBox.innerHTML = overHTML;
            gallery.appendChild(overBox);
        }
    });

    // Lightbox overlay modale full-screen
    const overlay = document.createElement('div');
    overlay.className = 'cc-lightbox-overlay';
    overlay.setAttribute('role', 'dialog');
    overlay.setAttribute('aria-modal', 'true');
    overlay.setAttribute('aria-hidden', 'true');
    overlay.innerHTML =
        '<span class="cc-lb-btn cc-lb-close" title="Chiudi (Esc)" aria-label="Chiudi">&times;</span>' +
        '<span class="cc-lb-btn cc-lb-prev" title="Precedente" aria-label="Precedente">&larr;</span>' +
        '<span class="cc-lb-btn cc-lb-next" title="Successiva" aria-label="Successiva">&rarr;</span>' +
        '<div class="cc-lb-content"><img class="cc-lb-img" src="" alt=""><div class="cc-lb-caption"></div></div>';
    document.body.appendChild(overlay);

    const lbImg = overlay.querySelector('.cc-lb-img');
    const lbCaption = overlay.querySelector('.cc-lb-caption');
    const closeBtn = overlay.querySelector('.cc-lb-close');
    const prevBtn = overlay.querySelector('.cc-lb-prev');
    const nextBtn = overlay.querySelector('.cc-lb-next');

    let currentImages = [];
    let currentIndex = 0;
    let lastActiveElement = null;

    galleries.forEach(function (gallery) {
        const imgs = Array.from(gallery.querySelectorAll('img'));
        imgs.forEach(function (img, idx) {
            img.tabIndex = 0;

            const open = function (e) {
                e.preventDefault();
                lastActiveElement = document.activeElement;
                currentImages = imgs;
                currentIndex = idx;
                updateLightbox(currentIndex);
                overlay.classList.add('active');
                overlay.setAttribute('aria-hidden', 'false');
            };

            img.addEventListener('click', open);
            img.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') open(e);
            });
        });
    });

    function updateLightbox(index) {
        if (index < 0 || index >= currentImages.length) return;
        const targetImg = currentImages[index];
        lbImg.src = targetImg.currentSrc || targetImg.src;
        lbImg.alt = targetImg.alt || '';
        const figure = targetImg.closest('figure');
        const caption = figure ? figure.querySelector('figcaption, .wp-element-caption') : null;
        lbCaption.textContent = caption ? caption.textContent : '';
        const multiple = currentImages.length > 1;
        prevBtn.style.display = multiple ? 'block' : 'none';
        nextBtn.style.display = multiple ? 'block' : 'none';
    }

    function close() {
        overlay.classList.remove('active');
        overlay.setAttribute('aria-hidden', 'true');
        if (lastActiveElement) lastActiveElement.focus();
    }

    function prev() { currentIndex = currentIndex > 0 ? currentIndex - 1 : currentImages.length - 1; updateLightbox(currentIndex); }
    function next() { currentIndex = currentIndex < currentImages.length - 1 ? currentIndex + 1 : 0; updateLightbox(currentIndex); }

    prevBtn.addEventListener('click', function (e) { e.stopPropagation(); prev(); });
    nextBtn.addEventListener('click', function (e) { e.stopPropagation(); next(); });
    closeBtn.addEventListener('click', close);
    overlay.addEventListener('click', function (e) { if (e.target === overlay) close(); });
    document.addEventListener('keydown', function (e) {
        if (!overlay.classList.contains('active')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') prev();
        if (e.key === 'ArrowRight') next();
    });
});
