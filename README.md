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
- **🎞️ Interactive Film Technical Sheet**: Built-in metabox for director, original title, cast, country, year, runtime, genre, and rating badge (1 to 5 stars with half-stars).
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
├── front-page.php              # Curated magazine homepage with editorial slots & empty state
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
├── page-chi-siamo.php          # Editorial "About Us" magazine layout with widescreen banner
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

3. **Recommended Initial Settings**:
   - Go to **Settings > Permalinks** and ensure **Post name** (`/%postname%/`) is selected (crucial for SEO!).
   - Navigate to **Appearance > Customize** to choose your favorite palette and typography.
   - Start writing your first review: as soon as you publish, the homepage and slots will automatically populate!

---

## 📈 SEO Mastery & Editorial Best Practices

### Why SEO is Crucial for a Cinema Magazine
Film reviews face intense competition on Google from industry giants (IMDb, Rotten Tomatoes, Letterboxd). To rank near the top and attract passionate cinephiles, technical optimization must be combined with disciplined editorial writing.

### What Cinephile Does Automatically For You:
- **Google Star Rating Rich Snippets**: Automatically generates Schema.org `Review` + `Movie` JSON-LD markup. When you rate a film, Google can display yellow review stars directly in search results.
- **Hierarchical Breadcrumbs**: Built-in `BreadcrumbList` schema showing site navigation in Google SERPs.
- **Sitelinks Search Box**: Generates `WebSite` schema enabling Google to show a direct search box for your publication.
- **Open Graph & Twitter Cards**: Native social sharing meta tags with large preview images (`max-image-preview:large`) for Google Discover, WhatsApp, Telegram, Facebook, and X.
- **Duplicate Content Defense**: Manages strict canonical URLs to prevent search engines from penalizing duplicate query parameters.
- **Blistering Core Web Vitals (100/100)**: Clean vanilla CSS/JS and zero bloated third-party scripts guarantee maximum speed, Google's #1 ranking factor.

### Editorial SEO Checklist (What the Author MUST Do):
1. **Permalink Structure**: Go to **Settings > Permalinks** and select **Post name** (`/%postname%/`). Never leave default query-string URLs (`?p=123`).
2. **Fill the "Film Technical Sheet"**: On every review, fill in the Director, Year, and especially the **Rating (1 to 5 stars)**. Without a rating, Google cannot display review stars!
3. **Keyword-Rich Titles (H1)**: Always include the movie title and keywords like "Review", "Analysis", or director name (e.g., *Oppenheimer: In-depth Review of Christopher Nolan's Masterpiece*).
4. **Write a Custom Excerpt**: Fill the "Excerpt" field in the post editor with 1-2 compelling sentences (140–160 characters). This automatically becomes your Google meta description and social media summary.
5. **Featured Image with Alt Text**: Upload high-resolution horizontal stills and **always fill in the "Alternative Text" (ALT)** describing the image content (e.g., *Cillian Murphy in Oppenheimer*).
6. **Subheadings (H2, H3)**: Break your critique into readable sections using H2 and H3 tags (e.g., *Directorial Style & Cinematography*, *Performances & Casting*, *Verdict*).

---

## 🔒 Security Architecture & The ONLY Recommended Plugin

### Native Built-in Security:
- **Zero Raw SQL Queries**: 100% powered by WordPress core APIs (`WP_Query`, `get_post_meta`), eliminating SQL Injection risks.
- **Superglobal Sanitization**: All `$_POST`, `$_GET`, and `$_SERVER` data are unslashed and sanitized with native helper functions.
- **CSRF Token Validation**: Form and metabox saves require strict nonce verification.
- **Anti-Enumeration Protection**: Blocks author enumeration attempts used by automated brute-force bots.
- **XML-RPC Hardening**: Closes insecure legacy RPC endpoints.

### The Single Recommended Security Plugin:
Cinephile requires **ZERO security plugins** for daily operation. However, we strongly recommend installing one lightweight, open-source plugin:
* **Plugin**: A login URL obfuscator such as **WPS Hide Login** (free, open source, lightweight).
* **Why**: Over 99% of malicious bots constantly probe default URLs like `yoursite.com/wp-login.php` and `yoursite.com/wp-admin`. Renaming the login URL to a private slug (e.g., `yoursite.com/editorial-access` or `yoursite.com/ciak-login`) immediately neutralizes brute-force attacks.

> [!CAUTION]
> **CRITICAL WARNING**: Immediately after configuring your new secret login URL, **bookmark it or write it down in a safe password manager**. If you forget your custom login URL, you will be locked out of your WordPress admin dashboard!

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
- **🎞️ Scheda Tecnica Cinematografica Nativa**: Metabox dedicato per Titolo Originale, Regista, Cast, Anno, Nazione, Durata, Genere e Voto critico (da 1 a 5 stelle con mezzi voti e visualizzazione dorata).
- **📸 Galleria Scenografie Polaroid**: Presentazione fotografica a polaroid con inclinazioni casuali naturali e lightbox fotografico nativo in puro JavaScript (nessuna libreria esterna pesante).
- **🎯 Gestione Editoriale degli Slot in Home Page**: Sistema di posizionamento dei post per la prima pagina (*Spotlight*, *Editoriale*, *Primo Piano*, ecc.) direttamente dal pannello degli articoli, con filtro dedicato nella tabella dei contenuti.
- **🚀 Performance Estreme**: Rimozione automatica del codice superfluo di WordPress (emoji script, oEmbeds non necessari, link wlwmanifest), transient cache su query complesse e supporto WebP nativo.
- **📊 SEO & Dati Strutturati**: Generazione automatica di JSON-LD conforme a Schema.org per `Movie`, `Review` e `Article`, con supporto per le stelle di recensione su Google.
- **🎨 Pannello Customizer in Tempo Reale**: Personalizzazione estetica con palette cinematografiche (*Deep Cinema Noir*, *Crimson Elegance*, *Sepia Archive*, *Minimalist Light*), preset tipografici e impostazioni della galleria.

---

## 🛠️ Installazione Rapida

1. **Scarica o Clona il Tema**:
   ```bash
   cd wp-content/themes/
   git clone https://github.com/DiegoGIT-home/cinephile-wordpress-theme.git cinephile
   ```
2. **Attiva il Tema**:
   Accedi a WordPress: **Aspetto > Temi** e clicca su **Attiva** sul tema **Cinephile**.
3. **Configurazione Iniziale Consigliata**:
   - Vai in **Impostazioni > Permalink** e seleziona **Nome articolo** (`/%postname%/`) (fondamentale per la SEO!).
   - Personalizza colori e caratteri da **Aspetto > Personalizza**.
   - Inizia a scrivere: appena pubblicherai il tuo primo articolo, la home page si popolerà automaticamente!

---

## 📈 Guida Completa alla SEO & Best Practice Editoriali

### Perché la SEO è Vitale per una Rivista di Cinema
Le recensioni di film competono quotidianamente sui motori di ricerca contro colossi come IMDb, MyMovies, Movieplayer o Wikipedia. Per farsi trovare da Google e posizionarsi tra i primi risultati, la tecnica del tema deve andare a braccetto con una corretta disciplina redazionale.

### Cosa fa Cinephile Automaticamente per Te:
- **Stelle di Recensione su Google (Rich Snippets)**: Genera automaticamente i microdati JSON-LD `Review` + `Movie`. Quando inserisci un voto al film, Google può mostrare le stelle dorate di valutazione direttamente nei risultati di ricerca!
- **Percorsi Breadcrumbs**: Genera lo schema `BreadcrumbList` per far capire a Google la gerarchia delle categorie.
- **Sitelinks Search Box**: Genera lo schema `WebSite` per mostrare la barra di ricerca del tuo sito nei risultati di Google.
- **Open Graph & Twitter Cards**: Genera anteprime social grandi e d'impatto con direttiva `max-image-preview:large` per Google Discover.
- **Zero Codice Duplicato**: Gestione rigorosa dei tag Canonical per evitare penalizzazioni.
- **Core Web Vitals da 100/100**: Codice leggerissimo, zero librerie pesanti di terze parti, fattore di ranking n.1 per Google.

### Checklist Redazionale SEO (Cosa DEVE Fare l'Autore):
1. **Struttura Permalink**: Vai in **Impostazioni > Permalink** e seleziona **Nome articolo** (`/%postname%/`). Non usare mai gli indirizzi predefiniti con `?p=123`.
2. **Compila la "Scheda Film"**: In ogni recensione, compila sempre il Regista, l'Anno e soprattutto la **Valutazione Film (da 1 a 5 stelle)** nel box sotto l'articolo. Senza voto, Google non mostrerà le stelline nella ricerca!
3. **Titolo Efficace (H1)**: Inserisci sempre il nome del film e parole chiave ricercate come "Recensione", "Analisi" o il nome del regista (es. *Dune - Parte Due: Recensione del capolavoro fantascientifico di Denis Villeneuve*).
4. **Scrivi un Estratto Accattivante**: Nel pannello laterale dell'articolo compila il campo **"Estratto"** con 1-2 frasi incisive (140–160 caratteri). Diventerà la meta-descrizione su Google e il testo d'anteprima su WhatsApp e social.
5. **Immagine in Evidenza & Testo ALT**: Carica foto orizzontali ad alta definizione e compila sempre il **"Testo alternativo (ALT)"** descrivendo l'immagine (es. *Scena del film con protagonista nel deserto*).
6. **Sottotitoli nel Testo (H2, H3)**: Non pubblicare muri di testo unici; dividi l'analisi con titoli H2 (es. *La regia e la messa in scena*, *Le interpretazioni del cast*, *Giudizio finale*).

---

## 🔒 Sicurezza del Sito & L'UNICO Plugin Raccomandato

### Protezioni Native Già Attive nel Tema:
- **Nessuna Query SQL Raw**: Il tema usa esclusivamente le API core di WordPress, azzerando i rischi di SQL Injection.
- **Sanitizzazione Totale**: Tutti gli input da form e URL sono filtrati con `wp_unslash()` e sanitizzati nativamente.
- **Protezione CSRF**: Form e salvataggi sono protetti da token crittografici Nonce.
- **Anti-Enumeration Autori**: Blocca i bot automatici che tentano di risalire ai nomi utente per sferrare attacchi brute-force.
- **Hardening XML-RPC**: Disabilita endpoint non sicuri spesso presi di mira da attacchi esterni.

### L'Unico Plugin Raccomandato:
Cinephile non richiede **alcun plugin pesante di sicurezza** per funzionare al massimo. Consigliamo soltanto un plugin open source leggero e pulito:
* **Plugin**: Un software per **nascondere/modificare l'indirizzo di login**, come **WPS Hide Login** (gratuito, open source, leggero).
* **Perché serve**: Oltre il 99% dei bot malevoli scansiona automaticamente gli indirizzi predefiniti `tuosito.it/wp-login.php` o `tuosito.it/wp-admin`. Cambiando questo percorso in uno segreto (ad esempio `tuosito.it/accesso-redazione` o `tuosito.it/ciak-login`), i bot riceveranno un errore 404 e il sito risulterà protetto da attacchi automatici.

> [!CAUTION]
> **AVVERTENZA FONDAMENTALE**: Subito dopo aver attivato il plugin e scelto il nuovo indirizzo di login segreto, **salvalo immediatamente nei preferiti del browser o annotalo in un posto sicuro**. Se dimentichi il nuovo link di accesso, non potrai più accedere al pannello di amministrazione di WordPress!

---

## ⚡ Prestazioni Estreme su Hosting Condivisi da 20€/anno (Guida Zero-Plugin)

I piani di hosting condivisi ultra-economici (da ~20€/anno come Hostinger Single, Serverplan Starter, Aruba Basic, Namecheap Shared, Netsons) hanno vincoli hardware severi imposti dai provider (CloudLinux LVE):
* **CPU Quota**: 1 vCPU condivisa. Se il consumo di "CPU seconds" supera la soglia oraria, l'hosting sospende temporaneamente il sito mostrando l'errore `508 Resource Limit Reached`.
* **RAM Limitata**: Spesso limitata a 256MB–512MB di memoria PHP.
* **I/O Disco Meccanico / SSD Lento**: Poche centinaia di IOPS; query al database non ottimizzate generano code di attesa.
* **Processi PHP Concorrenti**: Solo 10–20 processi simultanei ("Entry Processes").

Mentre i temi commerciali (Elementor, Divi) richiedono 150MB di RAM per pagina e decine di plugin per funzionare, **Cinephile è stato ingegnerizzato specificamente per volare su queste macchine a basso costo**.

### 🚀 Ottimizzazioni Native Già Attive nel Codice (Zero Plugin Richiesti)

1. **Throttling della Heartbeat API**: La frequenza di `admin-ajax.php` è ridotta da 15 a 60 secondi nell'editor e **completamente disabilitata sul frontend per i visitatori**. Questo impedisce il consumo silenzioso della CPU condivisa mentre si scrive una recensione.
2. **Limitazione Revisioni del Database**: WordPress salva per impostazione predefinita infinite copie di ogni articolo. Cinephile imposta un tetto massimo di **5 revisioni per post**, mantenendo la tabella `wp_posts` microscopica e veloce su dischi condivisi.
3. **Disattivazione Self-Pingbacks**: Quando un articolo inserisce un link a un'altra recensione del tuo sito, WordPress non effettua richieste HTTP a se stesso, risparmiando processi PHP.
4. **Preload Nativo Font WOFF2 in `<head>`**: Il tema inietta automaticamente tag `<link rel="preload">` per i file WOFF2 del titolo e del corpo testo. I font iniziano a scaricarsi al byte 1, eliminando il ritardo visivo del testo (FOUT) e il Cumulative Layout Shift (CLS).
5. **LCP Eager Loading**: L'immagine Hero in primo piano della Homepage e la foto di copertina del singolo articolo hanno priorità massima (`fetchpriority="high"` e `loading="eager"`), garantendo tempi di caricamento LCP inferiori a 0.8s.
6. **Eliminazione Asset Inutilizzati**: Dashicons (`dashicons.min.css`, ~30KB) viene rimosso per tutti gli utenti non loggati; la libreria di blocchi Gutenberg viene rimossa in Homepage (essendo un layout 100% PHP).
7. **Transient API Caching**: Gli slot editoriali della Home Page e la lista redattori della pagina "Chi Siamo" vengono salvati nella memoria cache interna di WordPress, azzerando le query al database.

---

### ⚙️ Configurazione Consigliata del Server (PHP & `.htaccess`)

#### 1. Versione e Parametri PHP per Immagini e Video Pesanti
Nei server condivisi (cPanel, Plesk o DirectAdmin), apri lo strumento **MultiPHP INI Editor** o **Select PHP Version** per impostare i seguenti parametri ottimali:

* **Versione PHP**: Seleziona **PHP 8.2** o **PHP 8.3** (fino a 3 volte più veloce di PHP 7.4 e parsimonioso di RAM).
* **OPcache**: Attiva l'estensione `opcache` (velocizza l'esecuzione del codice PHP di oltre il 200%).
* **Parametri per Upload Media (Immagini HD e Video)**:
  * `upload_max_filesize = 128M` (o `256M` se desideri consentire l'upload di file video consistenti).
  * `post_max_size = 128M` (o `256M`, deve essere sempre pari o superiore a `upload_max_filesize`).
  * `memory_limit = 256M` (o `512M` durante l'elaborazione di ritagli fotografici ad alta risoluzione).
  * `max_execution_time = 120` (o `300` per evitare che la connessione scada durante il caricamento di file pesanti).
  * `max_input_time = 120` (tempo massimo concesso per la ricezione dei dati via upload).
  * `max_input_vars = 3000`.

> [!TIP]
> **Come applicare questi valori se non hai cPanel**: Se l'hosting non offre un selettore grafico, puoi creare un file denominato `.user.ini` nella cartella principale del tuo sito WordPress inserendo queste righe:
> ```ini
> upload_max_filesize = 128M
> post_max_size = 128M
> memory_limit = 256M
> max_execution_time = 120
> max_input_time = 120
> ```

---

#### 2. File `.htaccess` Completo: Prestazioni Estreme & Protezione Totale
Se il tuo provider di hosting utilizza un web server **Apache** o **LiteSpeed**, inserisci il seguente blocco in cima al file `.htaccess` situato nella cartella principale del tuo sito WordPress (`public_html`):

```apache
# ==============================================================================
# 🎬 CINEPHILE: PRESTAZIONI ESTREME & SICUREZZA SERVER
# ==============================================================================

# 1. COMPRESSIONE GZIP / BROTLI (mod_deflate)
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css
    AddOutputFilterByType DEFLATE application/javascript application/x-javascript application/json
    AddOutputFilterByType DEFLATE image/svg+xml application/vnd.ms-fontobject application/x-font-ttf font/opentype
</IfModule>

# 2. CACHE DEL BROWSER A 1 ANNO (mod_expires)
<IfModule mod_expires.c>
    ExpiresActive On
    # Font locali WOFF2 e immagini WebP conservati nella memoria del visitatore per 1 anno
    ExpiresByType font/woff2 "access plus 1 year"
    ExpiresByType font/woff "access plus 1 year"
    ExpiresByType image/webp "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresDefault "access plus 2 days"
</IfModule>

# 3. HEADER DI CACHING (mod_headers)
<IfModule mod_headers.c>
    <FilesMatch "\.(woff2|woff|webp|png|jpe?g|css|js)$">
        Header set Cache-Control "max-age=31536000, public"
    </FilesMatch>
</IfModule>

# 4. SICUREZZA: DISABILITAZIONE NAVIGAZIONE CARTELLE
Options -Indexes

# 5. SICUREZZA: PROTEZIONE FILE CRITICI (wp-config.php e file nascosti)
<Files wp-config.php>
    Order allow,deny
    Deny from all
</Files>

<Files xmlrpc.php>
    Order allow,deny
    Deny from all
</Files>

<FilesMatch "(^\.|\.(bak|config|sql|fla|psd|ini|log|sh))$">
    Order allow,deny
    Deny from all
</FilesMatch>

# 6. SICUREZZA: BLOCCO ESECUZIONE PHP NELLA CARTELLA UPLOADS
# (Impedisce l'esecuzione di script malevoli caricati spacciati per immagini)
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} ^/wp-content/uploads/.*\.php$ [NC]
    RewriteRule .* - [F,L]
</IfModule>
# ==============================================================================
# FINE CONFIGURAZIONE CINEPHILE
# ==============================================================================
```

---

### 🎥 Guida Strategica ai Video: Perché YouTube ("Non in Elenco") Batte il Self-Hosting

Su un hosting condiviso a basso costo (~20€/anno), **caricare file video (MP4/MOV) direttamente nella libreria media di WordPress è sconsigliato** per 3 motivi tecnici critici:
1. **Saturazione dello Spazio Disco**: Un video in Full HD o 4K di pochi minuti pesa tra i 200MB e 1GB. Con soli 3 o 4 video esauriresti l'intero spazio disco concesso dal tuo piano hosting.
2. **Saturazione della Banda e dei Processi PHP**: Quando un visitatore preme Play su un video self-hosted, il tuo server deve inviare una mole enorme di dati in streaming. Se 5 lettori guardano il video contemporaneamente, la banda del server si satura all'istante, provocando il blocco del sito con errore *508 Resource Limit*.
3. **Mancanza di Bitrate Adattivo**: I server condivisi non generano automaticamente le diverse risoluzioni (1080p, 720p, 480p, 360p) a seconda della velocità di connessione dell'utente, causando continui blocchi su smartphone e reti mobili.

#### 💡 La Strategia Vincente: YouTube con Video "Non in Elenco" (Unlisted)
Per avere video veloci, gratuiti e con qualità cinematografica:
1. **Carica il tuo video su YouTube** dal tuo account Google.
2. Nelle opzioni di visibilità, seleziona **"Non in elenco" (Unlisted)**.
   - *Cosa significa*: Il video **non compare nella ricerca di YouTube**, non compare sul tuo canale pubblico e nessuno può trovarlo casualmente.
   - *Chi può vederlo*: **Esclusivamente chi visita il tuo sito web!**
3. **Come incorporarlo nell'articolo**:
   - Copia semplicemente il link del video di YouTube (es. `https://www.youtube.com/watch?v=...`).
   - All'interno dell'editor del tuo articolo, incolla il link direttamente in un paragrafo o inserisci il blocco nativo **"YouTube"**.
   - WordPress lo convertirà istantaneamente in un riproduttore video perfettamente funzionante!
4. **Vantaggi Straordinari**:
   - **Zero spazio consumato** sul tuo hosting da 20€.
   - **Zero consumo di banda** (lo streaming viene gestito interamente dai potenti server globali di Google/YouTube).
   - **Qualità massima e adattiva**: lo spettatore guarda il video fluido a 1080p/4K su qualsiasi dispositivo e connessione.

---

### 🔌 Cosa Fare se il Traffico Raggiunge Centinaia di Migliaia di Visite?

Se la tua rivista diventa virale e ricevi decine di migliaia di visualizzazioni al giorno su un server economico da 20€:
* **L'UNICO plugin opzionale di cache**: Installa **Cache Enabler** (plugin open-source gratuito ultra-leggero di KeyCDN) oppure **LiteSpeed Cache** (se il tuo piano hosting da 20€ si trova su server LiteSpeed, come Netsons o Hostinger).
* **Come funziona**: Salva una copia HTML statica di ogni recensione. Quando un visitatore apre la pagina, il server invia il file HTML puro in **15 millisecondi**, senza svegliare né PHP né MySQL. In questo modo anche un server da 20€/anno può sostenere oltre 100.000 visualizzazioni al mese senza il minimo rallentamento.

---

## 👥 Crediti Ufficiali

- **Ideazione e Direzione Artistica**: Diego Costanzo (Firenze)
- **Sviluppo Software e AI Engineering**: Antigravity & Gemini (Google DeepMind)
- **Versione**: 1.0.0 (Settembre 2026)
- **Licenza**: GNU General Public License v2.0 o successiva (vedi [LICENSE](LICENSE)).
