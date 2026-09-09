# 🎬 Cinephile — Editorial Cinema Magazine & Reviews WordPress Theme

[![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg?style=flat-square&logo=wordpress)](https://wordpress.org)
[![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4.svg?style=flat-square&logo=php)](https://php.net)
[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-green.svg?style=flat-square)](LICENSE)
[![GDPR Compliant](https://img.shields.io/badge/GDPR-100%25%20Native%20Compliant-success.svg?style=flat-square)](#-privacy--gdpr-compliance)
[![Plugin Free](https://img.shields.io/badge/Dependencies-Zero%20Plugins-orange.svg?style=flat-square)](#-zero-plugin-architecture)

> **Cinephile** is an ultra-fast, zero-dependency, high-end editorial WordPress theme designed for film critics, cinema magazines, cultural reviews, and cinephiles. Crafted with modern web standards, native schema markup, and an immersive dark-room aesthetic.

---

## 🌍 Language / Lingua
- [English Documentation](#-english-documentation)
- [Documentazione in Italiano](#-documentazione-in-italiano)

---

# 🇬🇧 English Documentation

## 🌟 Key Highlights

- **⚡ Zero Plugin Dependency**: Everything works 100% out of the box — movie technical sheet, contact forms, schema markup, and interactive galleries without installing heavy third-party plugins.
- **🛡️ 100% GDPR-Native & Privacy First**: Zero third-party tracker requests, no external Google Fonts calls (all fonts are served locally in modern WOFF2 format), no tracking cookies.
- **🎞️ Interactive Film Technical Sheet**: Built-in metabox for director, original title, cast, country, year, runtime, genre, and decimal rating badge (1.0 to 10.0).
- **📸 Polaroid Lightbox Scenography**: Responsive photo gallery with vintage polaroid styling, dynamic subtle rotation, and smooth native JavaScript lightbox.
- **🎯 Curated Home Page Slot Management**: Intuitive editorial curation system directly in the WordPress admin to assign articles to specific homepage slots (*Spotlight*, *Editoriale*, *Primo Piano*, etc.) with dedicated list-table filters.
- **🚀 Ultra-Optimized Performance**: Stripped-down core bloat (removed emoji scripts, oEmbeds, generator tags, WLW manifest), built-in transient caching, and responsive WebP image optimization.
- **📊 Native Rich Snippets (Schema.org)**: Complete JSON-LD generation for `Movie`, `Review`, and `Article`, boosting SEO visibility with Google rich review stars.
- **🎨 Live Customizer Integration**: Real-time styling with bespoke color schemes (*Deep Cinema Noir*, *Crimson Elegance*, *Sepia Archive*, *Minimalist Light*), typography presets, and layout switches.

---

## 🏛️ Architecture (Single Responsibility Principle)

The theme follows strict modern PHP standards and WordPress Theme Review Guidelines (WPCS). Core features are decoupled across focused modules inside the [`inc/`](inc/) directory:

```
cinephile-theme/
├── 404.php                     # Hero-styled custom 404 page
├── archive.php                 # Categorized archives layout
├── assets/
│   ├── css/                    # Lightbox & admin styles
│   ├── fonts/                  # 100% Local WOFF2 fonts (Cinzel, Inter, Lora, Outfit, Playfair)
│   ├── icons/                  # Crisp inline SVG icons
│   └── js/                     # Modular vanilla JS (lightbox, customizer live preview, navigation)
├── category.php                # Category template with bento grid
├── comments.php                # Clean, accessible threaded comments
├── footer.php                  # Semantic footer with navigation & copyright
├── front-page.php              # Curated magazine homepage with editorial slots
├── functions.php               # Core orchestrator loading inc/ modules
├── header.php                  # High-performance header with navigation & search modal
├── inc/
│   ├── customizer.php          # Live Customizer controls & dynamic CSS injection
│   ├── excerpt-cleaner.php     # Smart excerpt trimmer preserving readability
│   ├── form-contatti.php       # Plugin-free secure contact form with Cloudflare IP & honeypot
│   ├── hide-featured-image.php # Per-post toggle to hide hero thumbnail
│   ├── image-optimization.php  # WebP support, aspect-ratio wrappers & srcset
│   ├── mail_protetta.php       # Native email antispam obfuscator
│   ├── metabox-film.php        # Native movie metadata (director, cast, rating, runtime)
│   ├── metabox-gallery.php     # Polaroid gallery controls & preset overrides
│   ├── metabox-positions.php   # Editorial homepage slot assignment & admin filters
│   ├── performance.php         # Clean WP bloatware, transients & speed tweaks
│   ├── search-filters.php      # Search enhancement & query sanitation
│   ├── security.php            # Anti-enumeration, query inspection & XML-RPC hardening
│   ├── seo-schema.php          # JSON-LD structured data for Movie & Review
│   ├── setup-pages.php         # Automated template detection & page setup
│   ├── setup.php               # Theme supports, menus, widget areas & image sizes
│   └── template-tags.php       # Reading time counter, pill badges, and formatters
├── index.php                   # Fallback loop
├── page-chi-siamo.php          # Editorial "About Us" magazine layout
├── page-contatti.php           # Native contact page template
├── page.php                    # Default clean page layout
├── search.php                  # Interactive search results with live query badge
├── single.php                  # Single film review template with tech sheet & polaroid gallery
├── style.css                   # Master stylesheet with CSS custom properties
└── tag.php                     # Tag archive with cinema bento grid
```

---

## 🚀 Quick Start (Installation in 2 Minutes)

1. **Download / Clone**:
   Clone or download this repository into your WordPress themes folder:
   ```bash
   cd wp-content/themes/
   git clone https://github.com/DiegoGIT-home/cinephile-wordpress-theme.git cinephile
   ```

2. **Activate the Theme**:
   Go to your WordPress Admin panel: **Appearance > Themes** and click **Activate** on **Cinephile**.

3. **Recommended Settings**:
   - Navigate to **Appearance > Customize** to choose your favorite palette and typography.
   - Go to **Settings > Permalinks** and ensure **Post name** (`/%postname%/`) is selected.

---

## 🔒 Security & Code Standards

- **Late Escaping**: 100% of frontend outputs are escaped using contextual functions (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`, `wp_json_encode`).
- **CSRF Protection**: All form submissions and metadata saves are validated with nonces.
- **Capability Verification**: Post and options saves are strictly restricted via `current_user_can()`.
- **Zero Raw SQL**: Uses native WordPress APIs (`WP_Query`, `get_post_meta`), preventing SQL injection risks entirely.

---

## 👤 Credits & Authors

- **Ideator & Art Director**: [Diego Costanzo](https://github.com/DiegoGIT-home) (Florence, Italy)
- **AI Software Engineering**: Developed in pair-programming with **Antigravity & Gemini** (Google DeepMind)
- **Inspiration**: The golden age of Italian & International film criticism.

---

## 📄 License

This project is open-source software licensed under the **GNU General Public License v2.0 or later**.  
See the [LICENSE](LICENSE) file for complete details.

---
---

# 🇮🇹 Documentazione in Italiano

## 🌟 Caratteristiche Principali

- **⚡ Zero Dipendenze da Plugin**: Funziona al 100% in autonomia fin dal primo secondo. Scheda tecnica film, modulo contatti, microdati Schema.org e gallerie polaroid sono integrati nativamente nel tema.
- **🛡️ 100% Conforme al GDPR**: Nessun font o risorsa caricata da server esterni (Google Fonts inclusi in locale in formato WOFF2 ad altissima efficienza), zero cookie di tracciamento o profilazione.
- **🎞️ Scheda Tecnica Cinematografica Nativa**: Metabox dedicato per Titolo Originale, Regista, Cast, Anno, Nazione, Durata, Genere e Voto critico (da 1.0 a 10.0 con visualizzazione a stella).
- **📸 Galleria Scenografie Polaroid**: Presentazione fotografica a polaroid con inclinazioni casuali naturali e lightbox fotografico nativo in puro JavaScript (nessuna libreria esterna pesante).
- **🎯 Gestione Editoriale degli Slot in Home Page**: Sistema di posizionamento dei post per la prima pagina (*Spotlight*, *Editoriale*, *Primo Piano*, ecc.) direttamente dal pannello degli articoli, con filtro dedicato nella tabella dei contenuti.
- **🚀 Performance Estreme**: Rimozione automatica del codice superfluo di WordPress (emoji script, oEmbeds non necessari, link wlwmanifest), transient cache su query complesse e supporto WebP nativo.
- **📊 SEO & Dati Strutturati**: Generazione automatica di JSON-LD conforme a Schema.org per `Movie`, `Review` e `Article`, con supporto per le stelle di recensione su Google.
- **🎨 Pannello Customizer in Tempo Reale**: Personalizzazione estetica con palette cinematografiche (*Deep Cinema Noir*, *Crimson Elegance*, *Sepia Archive*, *Minimalist Light*), preset tipografici e impostazioni della galleria.

---

## 🛠️ Installazione Rapida

1. Scarica o clona la cartella nella directory dei temi:
   ```bash
   cd wp-content/themes/
   git clone https://github.com/DiegoGIT-home/cinephile-wordpress-theme.git cinephile
   ```
2. Accedi al pannello di amministrazione di WordPress: **Aspetto > Temi** e clicca su **Attiva** sul tema **Cinephile**.
3. Personalizza i colori e i caratteri da **Aspetto > Personalizza**.

---

## 👥 Crediti Ufficiali

- **Ideazione e Direzione Artistica**: Diego Costanzo (Firenze)
- **Sviluppo Software e AI Engineering**: Antigravity & Gemini (Google DeepMind)
- **Licenza**: GNU General Public License v2.0 o successiva (vedi [LICENSE](LICENSE)).
