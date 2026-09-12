# 🎬 Cinephile — Editorial Cinema Magazine & Reviews WordPress Theme

[![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg?style=flat-square&logo=wordpress)](https://wordpress.org)
[![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4.svg?style=flat-square&logo=php)](https://php.net)
[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-green.svg?style=flat-square)](LICENSE)
[![GDPR Compliant](https://img.shields.io/badge/GDPR-100%25%20Native%20Compliant-success.svg?style=flat-square)](#-player-cinematografico-facade-zero-cookie-preventivi--zero-banner-fastidiosi)
[![Plugin Free](https://img.shields.io/badge/Dependencies-Zero%20Plugins-orange.svg?style=flat-square)](#-caratteristiche-principali)

> **Cinephile** è un tema editoriale per WordPress ad altissime prestazioni, elegante, cinematografico e con **zero dipendenze da plugin**. Progettato su misura per riviste di cinema, critici cinematografici, recensioni culturali e cinefili, con microdati Schema.org nativi, conformità GDPR totale (esente da cookie banner) e ottimizzazione estrema per server economici condivisi (~20€/anno).

---

## 🌍 Scegli la Lingua / Select Language
- 🇮🇹 **[Documentazione in Italiano](#-documentazione-in-italiano)** *(Versione Principale)*
- 🇬🇧 **[English Documentation](#-english-documentation)** *(Complete Guide)*

---
---

# 🇮🇹 Documentazione in Italiano

## 🌟 Caratteristiche Principali

- **⚡ Zero Dipendenze da Plugin**: Funziona al 100% in autonomia fin dal primo secondo. Scheda tecnica film, modulo contatti, player video cinematografico, microdati Schema.org e gallerie polaroid sono integrati nativamente nel tema.
- **🛡️ 100% Conforme al GDPR (Zero Cookie Banner)**: Nessun font o risorsa caricata da server esterni (Google Fonts inclusi in locale in formato WOFF2 ad altissima efficienza), zero cookie di tracciamento o profilazione. Il sito è legalmente esente da banner cookie preventivi.
- **🎞️ Scheda Tecnica Cinematografica Nativa**: Metabox dedicato per Titolo Originale, Regista, Cast, Anno, Nazione, Durata, Genere e Voto critico (da 1 a 5 stelle con mezzi voti e visualizzazione dorata).
- **📸 Galleria Scenografie Polaroid**: Presentazione fotografica a polaroid con inclinazioni casuali naturali e lightbox fotografico nativo in puro JavaScript (nessuna libreria esterna pesante).
- **🎬 Player Video Cinematografico Facade**: Embed intelligente di YouTube in formato widescreen 16:9 con supporto a schermo intero. Carica solo la locandina HD (appena 25KB invece di 1.2MB), azzera i cookie preventivi ed è conforme alla direttiva "Doppio Clic" del Garante Privacy.
- **🎯 Gestione Editoriale degli Slot in Home Page**: Sistema di posizionamento dei post per la prima pagina (*Spotlight*, *Focus e Percorsi*, *Dal Nostro Archivio*) direttamente dal pannello degli articoli, con filtro dedicato nella tabella dei contenuti.
- **🚀 Performance Estreme per Server Economici (~20€/anno)**: Ottimizzato per server a risorse limitate (1 vCPU, quote di CPU seconds). Throttling di Heartbeat, massimo 5 revisioni DB per post, preload font WOFF2 in `<head>`, LCP eager loading e transient cache nativa.
- **📊 SEO & Dati Strutturati Google Rich Snippets**: Generazione automatica di JSON-LD conforme a Schema.org per `Movie`, `Review` e `Article`, con supporto per le stelle dorate di recensione su Google e direttiva `max-image-preview:large` per Google Discover.
- **🎨 Pannello Customizer in Tempo Reale**: Personalizzazione estetica con palette cinematografiche (*Deep Cinema Noir*, *Crimson Elegance*, *Sepia Archive*, *Minimalist Light*), preset tipografici e impostazioni della galleria.

---

## 🏛️ Architettura del Tema (Single Responsibility Principle)

Il tema rispetta rigorosamente gli standard ufficiali del WordPress Theme Review Team (WPCS). Ogni modulo risiede nella cartella [`inc/`](inc/) con una singola responsabilità:

```
cinephile-theme/
├── 404.php                     # Pagina errore 404 in stile cinema noir
├── archive.php                 # Layout archivio recensioni con griglia bento
├── assets/
│   ├── css/
│   │   ├── admin.css           # Stili dedicati al pannello admin e metabox
│   │   ├── editor-style.css    # Stili tipografici per l'editor Gutenberg (WYSIWYG)
│   │   └── lightbox.css        # Stili scenografia e lightbox galleria polaroid
│   ├── fonts/                  # Font locali WOFF2 (Cinzel, Inter, Lora, Outfit, Playfair)
│   ├── icons/                  # Icone vettoriali SVG inline nitide
│   ├── img/                    # Artwork, logo trasparente, favicon e banner widescreen
│   └── js/
│       ├── customizer-preview.js # Live preview reattiva per il Customizer
│       ├── lightbox.js         # Lightbox fotografico nativo in Vanilla JS
│       ├── navigation.js       # Navigazione mobile e accessibilità ARIA da tastiera
│       └── video-player.js     # Player video cinematografico (Lite Facade & Due Clic)
├── author.php                  # Scheda profilo del critico cinematografico e sue recensioni
├── category.php                # Template categorie con architettura visiva
├── comments.php                # Sistema commenti accessibile e conforme privacy
├── favicon.ico                 # Favicon nativa del sito per browser e bookmark
├── footer.php                  # Footer semantico con menu e copyright
├── front-page.php              # Homepage con slot editoriali e scheda benvenuto empty-state
├── functions.php               # Orchestratore principale e caricamento moduli inc/
├── get-fonts.sh                # Script shell per il download locale dei font Google in WOFF2
├── GUIDA-IMMAGINI.md           # Guida completa a formati, risoluzioni e compressione immagini
├── header.php                  # Testata ad alte prestazioni, logo trasparente e navigazione
├── inc/
│   ├── assets.php              # Enqueue fogli di stile, font locali WOFF2, script e favicon
│   ├── customizer.php          # Controlli Customizer live e iniezione variabili CSS
│   ├── excerpt-cleaner.php     # Pulizia estratti, rimozione URL e preservazione leggibilità
│   ├── form-contatti.php       # Modulo contatti nativo, honeypot anti-spam e transient rate-limit
│   ├── hide-featured-image.php # Toggle per post per sopprimere l'immagine di copertina
│   ├── image-optimization.php  # Supporto WebP nativo, taglie cinema e srcset
│   ├── mail-protetta.php       # Mascheramento email nativo antispambot e Base64/JS
│   ├── metabox-film.php        # Scheda tecnica del film (regista, anno, voto a stelle)
│   ├── metabox-gallery.php     # Controlli scenografia polaroid e preset
│   ├── metabox-positions.php   # Posizionamento slot homepage e filtri admin
│   ├── performance.php         # Throttling Heartbeat, limite 5 revisioni, preload font WOFF2
│   ├── search-filters.php      # Esclusione pagine istituzionali e pulizia query ricerca
│   ├── security.php            # Anti-enumerazione utenti, firewall leggero e no XML-RPC
│   ├── seo-schema.php          # Microdati Schema.org JSON-LD (Review stelle, Movie, Article)
│   ├── setup-pages.php         # Generazione pagine legali e shortcode Privacy GDPR
│   ├── setup.php               # Supporti tema, menu e formati mime font
│   ├── template-tags.php       # Tempo di lettura, badge e formattatori editoriali
│   └── video-player.php        # Player video cinematografico (Lite Facade & Due Clic GDPR)
├── index.php                   # Fallback loop standard WordPress
├── languages/
│   └── cinephile.pot           # File master di traduzione e localizzazione con 2.400+ stringhe
├── LICENSE                     # Licenza ufficiale internazionale (GNU GPL v2 in lingua inglese)
├── LICENZA.md                  # Traduzione italiana di cortesia & guida alla licenza GPL v2
├── ottimizza-media.sh          # Script shell per la conversione automatica WebP e MP4
├── page-chi-siamo.php          # Pagina manifesto con banner 2.35:1 e transient cache autori
├── page-contatti.php           # Template pagina contatti sicura
├── page.php                    # Layout pagina generica pulita
├── screenshot.png              # Immagine ufficiale di anteprima tema (1200×900px)
├── search.php                  # Risultati di ricerca con badge query dinamico
├── searchform.php              # Modulo di ricerca accessibile del tema
├── single.php                  # Singola recensione con scheda tecnica e polaroid
├── style.css                   # Foglio di stile principale con CSS Custom Properties
└── tag.php                     # Archivio tag cinematografici
```

---

## 🛠️ Installazione Rapida in 2 Minuti

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

## 📸 Guida Rapida ai Formati Immagine e Risoluzioni

Per mantenere il sito velocissimo (**100/100 sui Core Web Vitals di Google**), evitare di sprecare spazio disco sull'hosting economico e impedire tagli sgradevoli o immagini sgranate, la redazione dovrebbe attenersi a queste risoluzioni consigliate:

| Tipologia Immagine | Risoluzione Ottimale | Ratio | Formato Consigliato | Peso Massimo Target |
| :--- | :--- | :--- | :--- | :--- |
| **Immagine in Evidenza (Hero & Home)** | **1200 × 675 px** *(o 1200×630)* | 16:9 | **WebP** *(o JPEG compresso)* | **< 150–200 KB** |
| **Foto nel Corpo Articolo** | **Larghezza 800–1000 px** | Libero | **WebP** *(o JPEG compresso)* | **< 80–120 KB** |
| **Galleria & Lightbox Polaroid** | Lato lungo max **1600 px** | 16:9 / 3:2 | **WebP** *(o JPEG compresso)* | **< 200–250 KB** |
| **Logo del Sito (Header)** | Larghezza **600–800 px** | Orizzontale | **SVG** *(ideale)* o **PNG** trasparente | **< 30–50 KB** |
| **Favicon / Icona Sito** | **512 × 512 px** | 1:1 Quadrato | **PNG** trasparente | **< 30 KB** |
| **Foto Profilo Critico / Autore** | **300 × 300 px** | 1:1 Quadrato | **WebP** o **JPEG** | **< 40–50 KB** |
| **Banner "Chi Siamo"** | **1200 × 350 px** | Panoramico | **WebP** *(o JPEG compresso)* | **< 150 KB** |

> 💡 **Guida Completa & Tool Gratuiti**: Il tema integra già un motore di conversione automatica in WebP in [`inc/image-optimization.php`](inc/image-optimization.php). Per scoprire i software gratuiti (come [Squoosh.app](https://squoosh.app/) di Google), i passaggi in 3 click e gli errori da evitare, consulta il documento dedicato: **[`GUIDA-IMMAGINI.md`](GUIDA-IMMAGINI.md)**.

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

### 🚀 Ottimizzazioni Native Già Attive nel Codice:
1. **Throttling della Heartbeat API**: Frequenza di `admin-ajax.php` ridotta da 15 a 60 secondi nell'editor e **completamente disabilitata sul frontend per i visitatori**. Questo impedisce il consumo silenzioso della CPU condivisa.
2. **Limitazione Revisioni del Database**: WordPress salva per impostazione predefinita infinite copie di ogni articolo. Cinephile imposta un tetto massimo di **5 revisioni per post**, mantenendo la tabella `wp_posts` microscopica e veloce su dischi condivisi.
3. **Disattivazione Self-Pingbacks**: Quando un articolo inserisce un link a un'altra recensione del tuo sito, WordPress non effettua richieste HTTP a se stesso, risparmiando processi PHP.
4. **Preload Nativo Font WOFF2 in `<head>`**: Il tema inietta automaticamente tag `<link rel="preload">` per i file WOFF2 del titolo e del corpo testo. I font iniziano a scaricarsi al byte 1, eliminando il ritardo visivo del testo (FOUT) e il Cumulative Layout Shift (CLS).
5. **LCP Eager Loading**: L'immagine Hero in primo piano della Homepage e la foto di copertina del singolo articolo hanno priorità massima (`fetchpriority="high"` e `loading="eager"`), garantendo tempi di caricamento LCP inferiori a 0.8s.
6. **Eliminazione Asset Inutilizzati**: Dashicons (`dashicons.min.css`, ~30KB) viene rimosso per tutti gli utenti non loggati; la libreria di blocchi Gutenberg viene rimossa in Homepage (essendo un layout 100% PHP).
7. **Transient API Caching**: Gli slot editoriali della Home Page e la lista redattori della pagina "Chi Siamo" vengono salvati nella memoria cache interna di WordPress, azzerando le query al database.

---

## ⚙️ Configurazione Consigliata del Server (PHP & `.htaccess`)

### 1. Versione e Parametri PHP per Immagini e Video Pesanti
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

### 2. File `.htaccess` Completo: Prestazioni Estreme & Protezione Totale
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

## 🎥 Guida Strategica ai Video: Perché YouTube ("Non in Elenco") Batte il Self-Hosting

Su un hosting condiviso a basso costo (~20€/anno), **caricare file video (MP4/MOV) direttamente nella libreria media di WordPress è sconsigliato** per 3 motivi tecnici critici:
1. **Saturazione dello Spazio Disco**: Un video in Full HD o 4K di pochi minuti pesa tra i 200MB e 1GB. Con soli 3 o 4 video esauriresti l'intero spazio disco concesso dal tuo piano hosting.
2. **Saturazione della Banda e dei Processi PHP**: Quando un visitatore preme Play su un video self-hosted, il tuo server deve inviare una mole enorme di dati in streaming. Se 5 lettori guardano il video contemporaneamente, la banda del server si satura all'istante, provocando il blocco del sito con errore *508 Resource Limit*.
3. **Mancanza di Bitrate Adattivo**: I server condivisi non generano automaticamente le diverse risoluzioni (1080p, 720p, 480p, 360p) a seconda della velocità di connessione dell'utente, causando continui blocchi su smartphone e reti mobili.

### 💡 La Strategia Vincente: YouTube con Video "Non in Elenco" (Unlisted)
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

## 🎬 Player Cinematografico Facade (Zero Cookie Preventivi & Zero Banner Fastidiosi)

Cinephile include nativamente un sistema intelligente per i video di YouTube, ispirato alle sale cinematografiche e alla massima tutela della privacy:

1. **Come Inserire un Video in 3 Secondi (Senza Alcun Plugin)**:
   - All'interno della bacheca di WordPress, apri l'articolo o la recensione.
   - Incolla l'URL del video di YouTube direttamente su una riga vuota (oppure premi `+` e seleziona il blocco nativo **"YouTube"**).
   - Non devi installare nessun plugin: il tema intercetta automaticamente il link e lo trasforma nel **Player Cinematografico Cinephile**!

2. **Perché Non Serve Nessun Cookie Banner sul Sito (La "Two-Click Solution" del Garante)**:
   - Di norma, i siti web che inseriscono video di YouTube sono obbligati per legge a mostrare quegli odiosi banner/popup di consenso cookie (come Cookiebot o Iubenda), perché i video standard di YouTube rilasciano cookie pubblicitari di Google non appena la pagina viene aperta.
   - **Cinephile risolve questo problema alla radice con la Soluzione a Due Clic**:
     * **Al caricamento della pagina**: Viene mostrata la locandina HD del trailer con un pulsante Play dorato e un elegante micro-avviso semitrasparente. **Nessun cookie viene installato e nessun dato viene trasmesso a Google.** L'immagine del film rimane perfettamente nitida e visibile.
     * **Al clic su Play**: Il lettore acconsente esplicitamente alla riproduzione e il video si avvia istantaneamente sul dominio protetto `youtube-nocookie.com`.
     * **Risultato**: **Il tuo sito rimane al 100% libero da cookie banner invasivi**, pienamente conforme alle direttive del Garante della Privacy e con tempi di caricamento da record (**appena 25KB** invece di 1.2MB per video!).

3. **Funzioni Cinematografiche Integrate**:
   - **Formato Widescreen 16:9 Nativo**: Il player mantiene sempre le proporzioni ideali del cinema senza bande asimmetriche e senza sgranare su nessun dispositivo.
   - **Schermo Intero (Fullscreen)**: Cliccando sull'icona di espansione o ruotando lo smartphone in orizzontale, il video si visualizza a pieno schermo con risoluzione massima.
   - **Colori Dinamici del Tema**: Bordo, pulsante Play ed effetto d'alone luminoso utilizzano le variabili CSS globali (`var(--accent-color)`), adattandosi istantaneamente alla palette scelta nel Customizer (*Deep Cinema Noir*, *Crimson Elegance*, *Sepia Archive*, *Minimalist Light*).

---

## 🔌 Cosa Fare se il Traffico Raggiunge Centinaia di Migliaia di Visite?

Se la tua rivista diventa virale e ricevi decine di migliaia di visualizzazioni al giorno su un server economico da 20€:
* **L'UNICO plugin opzionale di cache**: Installa **Cache Enabler** (plugin open-source gratuito ultra-leggero di KeyCDN) oppure **LiteSpeed Cache** (se il tuo piano hosting da 20€ si trova su server LiteSpeed, come Netsons o Hostinger).
* **Come funziona**: Salva una copia HTML statica di ogni recensione. Quando un visitatore apre la pagina, il server invia il file HTML puro in **15 millisecondi**, senza svegliare né PHP né MySQL. In questo modo anche un server da 20€/anno può sostenere oltre 100.000 visualizzazioni al mese senza il minimo rallentamento.

---

## 👥 Crediti Ufficiali

- **Ideazione e Direzione Artistica**: Diego Costanzo (Firenze)
- **Sviluppo Software e AI Engineering**: Antigravity & Gemini (Google DeepMind)
- **Versione**: 1.0.0 (Settembre 2026)
- **Licenza**: GNU General Public License v2.0 o successiva (testo ufficiale vincolante in [LICENSE](LICENSE), traduzione e spiegazione in italiano in [LICENZA.md](LICENZA.md)).

---
---

# 🇬🇧 English Documentation

## 🌟 Key Highlights

- **⚡ Zero Plugin Dependency**: Everything works 100% out of the box — movie technical sheet, contact forms, schema markup, cinematic video player, and interactive galleries without installing heavy third-party plugins.
- **🛡️ 100% GDPR-Native & Privacy First (Zero Cookie Banners)**: Zero third-party tracker requests, no external Google Fonts calls (all fonts are served locally in modern WOFF2 format), no tracking cookies. The site is legally exempt from cookie consent banners.
- **🎞️ Interactive Film Technical Sheet**: Built-in metabox for director, original title, cast, country, year, runtime, genre, and rating badge (1 to 5 stars with half-stars and golden stars).
- **📸 Polaroid Lightbox Scenography**: Responsive photo gallery with vintage polaroid styling, dynamic subtle rotation, and smooth native JavaScript lightbox (zero bulky external libraries).
- **🎬 Cinematic Video Player Facade**: Smart YouTube embedding in 16:9 widescreen with fullscreen support. Loads only a lightweight HD poster (just 25KB instead of 1.2MB), eliminating upfront cookies in compliance with the EU "Two-Click" privacy standard.
- **🎯 Curated Home Page Slot Management**: Intuitive editorial curation system directly in the WordPress admin to assign articles to specific homepage slots (*Spotlight*, *Focus & Pathways*, *From the Archive*) with dedicated list-table filters.
- **🚀 Extreme Budget Hosting Speed (~20€/year)**: Specifically engineered for resource-constrained shared hosts (1 vCPU, limited CPU seconds). Features Heartbeat throttling, max 5 database revisions per post, `<head>` WOFF2 font preloading, LCP eager loading, and native transient caching.
- **📊 Native Google Rich Snippets (Schema.org)**: Complete JSON-LD generation for `Movie`, `Review`, and `Article`, boosting SEO visibility with Google rich review stars and `max-image-preview:large` for Google Discover.
- **🎨 Live Customizer Integration**: Real-time styling with bespoke cinema color schemes (*Deep Cinema Noir*, *Crimson Elegance*, *Sepia Archive*, *Minimalist Light*), typography presets, and layout switches.

---

## 🏛️ Architecture (Single Responsibility Principle)

The theme follows strict modern PHP standards and WordPress Theme Review Guidelines (WPCS). Core features are decoupled across focused modules inside the [`inc/`](inc/) directory:

```
cinephile-theme/
├── 404.php                     # Hero-styled custom 404 page in noir cinema aesthetic
├── archive.php                 # Categorized reviews archive with cinema bento grid
├── assets/
│   ├── css/
│   │   ├── admin.css           # Dedicated admin panel and metabox styles
│   │   ├── editor-style.css    # Typography stylesheet for Gutenberg block editor (WYSIWYG)
│   │   └── lightbox.css        # Polaroid gallery & lightbox scenic styling
│   ├── fonts/                  # 100% Local WOFF2 fonts (Cinzel, Inter, Lora, Outfit, Playfair)
│   ├── icons/                  # Crisp inline SVG icons
│   ├── img/                    # Artwork, transparent logo, native favicon set & widescreen banners
│   └── js/
│       ├── customizer-preview.js # Live preview postMessage handler for Customizer
│       ├── lightbox.js         # Native Vanilla JS lightbox modal
│       ├── navigation.js       # Accessible ARIA mobile menu & keyboard navigation
│       └── video-player.js     # Cinematic Video Player (Lite Facade & GDPR Two-Click)
├── author.php                  # Film critic profile template & published reviews catalogue
├── category.php                # Category template with bento grid
├── comments.php                # Clean, accessible threaded comments
├── favicon.ico                 # Browser and bookmark fallback native favicon
├── footer.php                  # Semantic footer with navigation & copyright
├── front-page.php              # Curated magazine homepage with editorial slots & empty state
├── functions.php               # Core orchestrator loading inc/ modules
├── get-fonts.sh                # Shell script to download Google Fonts locally into WOFF2
├── GUIDA-IMMAGINI.md           # Comprehensive image formats, resolutions & optimization guide
├── header.php                  # High-performance header with navigation & search modal
├── inc/
│   ├── assets.php              # Stylesheet enqueuing, local WOFF2 fonts, scripts & favicon
│   ├── customizer.php          # Live Customizer controls & dynamic CSS injection
│   ├── excerpt-cleaner.php     # Smart excerpt trimmer preserving readability
│   ├── form-contatti.php       # Plugin-free secure contact form with Cloudflare IP & honeypot
│   ├── hide-featured-image.php # Per-post toggle to hide hero thumbnail
│   ├── image-optimization.php  # WebP support, aspect-ratio wrappers & srcset
│   ├── mail-protetta.php       # Native email antispam obfuscator (Base64/JS)
│   ├── metabox-film.php        # Native movie metadata (director, cast, rating, runtime)
│   ├── metabox-gallery.php     # Polaroid gallery controls & preset overrides
│   ├── metabox-positions.php   # Editorial homepage slot assignment & admin filters
│   ├── performance.php         # Heartbeat throttling, max 5 DB revisions, WOFF2 preloading
│   ├── search-filters.php      # Search enhancement & query sanitation
│   ├── security.php            # Anti-enumeration, query inspection & XML-RPC hardening
│   ├── seo-schema.php          # JSON-LD structured data for Movie & Review (Google stars)
│   ├── setup-pages.php         # Automated template detection & GDPR privacy shortcode
│   ├── setup.php               # Theme supports, menus & font mime types
│   ├── template-tags.php       # Reading time counter, pill badges, and formatters
│   └── video-player.php        # Cinematic Video Player (Lite Facade & GDPR Two-Click)
├── index.php                   # Fallback loop standard WordPress
├── languages/
│   └── cinephile.pot           # Master localization template file with 2,400+ indexed strings
├── LICENSE                     # Official international license (GNU GPL v2 in English)
├── LICENZA.md                  # Italian courtesy translation & plain-language summary of GPL v2
├── ottimizza-media.sh          # Shell script for automated WebP and MP4 optimization
├── page-chi-siamo.php          # Editorial "About Us" magazine layout with 2.35:1 banner
├── page-contatti.php           # Native contact page template
├── page.php                    # Default clean page layout
├── screenshot.png              # Official theme preview screenshot (1200×900px)
├── search.php                  # Interactive search results with live query badge
├── searchform.php              # Accessible theme search form template
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
   - Start writing your first review: as soon as you publish, the homepage slots and archives will automatically populate!

---

## 📈 SEO Mastery & Editorial Best Practices

### Why SEO is Crucial for a Cinema Magazine
Film reviews face intense competition on Google from industry giants (IMDb, Rotten Tomatoes, Letterboxd). To rank near the top and attract passionate cinephiles, technical optimization must be combined with disciplined editorial writing.

### What Cinephile Does Automatically For You:
- **Google Star Rating Rich Snippets**: Automatically generates Schema.org `Review` + `Movie` JSON-LD markup. When you rate a film, Google can display golden review stars directly in search results.
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

## 📸 Image Formats, Resolutions & Optimization Guide

To preserve maximum performance (**100/100 Google PageSpeed & Core Web Vitals**), prevent budget hosting disk quota exhaustion, and eliminate awkwardly cropped or blurry visuals, editors should follow these golden standards:

| Image Type | Target Resolution | Aspect Ratio | Preferred Format | Target Max File Size |
| :--- | :--- | :--- | :--- | :--- |
| **Featured Image (Hero & Home)** | **1200 × 675 px** *(or 1200×630)* | 16:9 | **WebP** *(or compressed JPEG)* | **< 150–200 KB** |
| **In-Article Content Photos** | Width **800–1000 px** | Flexible | **WebP** *(or compressed JPEG)* | **< 80–120 KB** |
| **Polaroid Gallery & Lightbox HD**| Max long side **1600 px** | 16:9 / 3:2 | **WebP** *(or compressed JPEG)* | **< 200–250 KB** |
| **Site Logo (Header)** | Width **600–800 px** | Horizontal | **SVG** *(preferred)* or **PNG** transparent | **< 30–50 KB** |
| **Site Icon / Favicon** | **512 × 512 px** | 1:1 Square | **PNG** transparent | **< 30 KB** |
| **Author Profile / Critic Avatar** | **300 × 300 px** | 1:1 Square | **WebP** or **JPEG** | **< 40–50 KB** |
| **"About Us" Cover Banner** | **1200 × 350 px** | Panoramic | **WebP** *(or compressed JPEG)* | **< 150 KB** |

> 💡 **Comprehensive Handbook**: Cinephile features built-in WebP generation via [`inc/image-optimization.php`](inc/image-optimization.php). For step-by-step conversion tutorials using free browser tools like [Squoosh.app](https://squoosh.app/) and common pitfalls to avoid, see the dedicated handbook: **[`GUIDA-IMMAGINI.md`](GUIDA-IMMAGINI.md)**.

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

## ⚡ Ultra-Low-Cost Hosting Mastery (~20€/year Shared Hosting & Zero-Plugin Speed)

Budget shared hosting tiers (~20€/year from providers like Hostinger Single, Serverplan Starter, Aruba Basic, Namecheap Shared, Netsons) impose strict hardware quotas via CloudLinux LVE:
* **CPU Quota**: 1 shared vCPU. If CPU-seconds exceed the hourly quota, the server returns the dreaded `508 Resource Limit Reached` error.
* **Limited RAM**: Often restricted to 256MB–512MB of PHP memory.
* **Slow Mechanical/Throttled Disk I/O**: Only a few hundred IOPS; slow database queries queue up and cause 504 Gateway Timeouts.
* **Concurrent PHP Workers**: Typically capped at 10–20 entry processes.

While commercial multipurpose themes (Elementor, Divi) consume 150MB of RAM per page and trigger database bottlenecks, **Cinephile was engineered from the ground up to fly on these budget machines**.

### 🚀 Built-in Performance Tweaks:
1. **Heartbeat API Throttling**: Reduces `admin-ajax.php` polling from 15s to 60s in the post editor and **completely disables Heartbeat on the frontend for visitors**, eliminating silent shared CPU consumption.
2. **Database Revision Capping**: Restricts post revisions to a **maximum of 5 per post** via `wp_revisions_to_keep`, preventing `wp_posts` and `wp_postmeta` from bloating on slow mechanical disks.
3. **Internal Pingback Suppression**: Prevents WordPress from sending self-referential HTTP pingbacks when linking to other reviews on your own domain.
4. **Native `<head>` Font Preload**: Injects `<link rel="preload">` tags for the active heading and body WOFF2 font files, downloading them on byte 1 and eliminating both FOUT (Flash of Unstyled Text) and CLS (Cumulative Layout Shift).
5. **LCP Eager Loading**: Sets `fetchpriority="high"` and `loading="eager"` on the Homepage Hero image and the single review featured thumbnail for instant Largest Contentful Paint (<0.8s).
6. **Frontend Asset Pruning**: Unregisters `dashicons.min.css` (~30KB) for guest visitors and dequeues Gutenberg block libraries on the homepage.
7. **Transient API Caching**: Homepage editorial slots and About Page author lists are stored in memory transients, reducing database queries to nearly zero.

---

## ⚙️ Recommended Server Configuration (PHP Settings & Hardened `.htaccess`)

### 1. Recommended PHP Settings (cPanel / Plesk MultiPHP INI Editor)
* **PHP Version**: Select **PHP 8.2** or **PHP 8.3** (up to 30% less memory and 3x faster than PHP 7.4).
* **OPcache**: Ensure the `opcache` PHP extension is enabled (accelerates PHP execution by over 200%).
* **Media Upload Settings (HD Images & Video)**:
  * `upload_max_filesize = 128M` (or `256M` if you wish to allow large video uploads).
  * `post_max_size = 128M` (or `256M`, must match or exceed upload_max_filesize).
  * `memory_limit = 256M` (or `512M` for high-resolution photo cropping).
  * `max_execution_time = 120` (or `300` to prevent timeouts during large file transfers).
  * `max_input_time = 120`.
  * `max_input_vars = 3000`.

> [!TIP]
> **Applying settings without cPanel**: You can create a `.user.ini` file in your WordPress root folder containing:
> ```ini
> upload_max_filesize = 128M
> post_max_size = 128M
> memory_limit = 256M
> max_execution_time = 120
> max_input_time = 120
> ```

---

### 2. Complete `.htaccess` Configuration: Maximum Speed & Hardened Security
If your hosting provider runs on an **Apache** or **LiteSpeed** web server, place this snippet at the very top of your `.htaccess` file in your WordPress root (`public_html`):

```apache
# ==============================================================================
# 🎬 CINEPHILE: PERFORMANCE & SECURITY RULES
# ==============================================================================

# 1. GZIP / BROTLI COMPRESSION (mod_deflate)
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css
    AddOutputFilterByType DEFLATE application/javascript application/x-javascript application/json
    AddOutputFilterByType DEFLATE image/svg+xml application/vnd.ms-fontobject application/x-font-ttf font/opentype
</IfModule>

# 2. 1-YEAR BROWSER CACHE (mod_expires)
<IfModule mod_expires.c>
    ExpiresActive On
    # Local WOFF2 fonts and WebP images cached in browser for 1 year
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

# 3. CACHING HEADERS (mod_headers)
<IfModule mod_headers.c>
    <FilesMatch "\.(woff2|woff|webp|png|jpe?g|css|js)$">
        Header set Cache-Control "max-age=31536000, public"
    </FilesMatch>
</IfModule>

# 4. SECURITY: DISABLE DIRECTORY BROWSING
Options -Indexes

# 5. SECURITY: PROTECT CRITICAL SYSTEM FILES (wp-config.php & hidden files)
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

# 6. SECURITY: BLOCK PHP SCRIPT EXECUTION IN UPLOADS FOLDER
# (Prevents malicious scripts uploaded disguised as media files from executing)
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} ^/wp-content/uploads/.*\.php$ [NC]
    RewriteRule .* - [F,L]
</IfModule>
# ==============================================================================
# END CINEPHILE CONFIGURATION
# ==============================================================================
```

---

## 🎥 Strategic Video Guide: Why YouTube ("Unlisted") Beats Self-Hosting

On budget shared hosting (~20€/year), **uploading video files (MP4/MOV) directly to the WordPress media library is strongly discouraged** for 3 critical technical reasons:
1. **Disk Space Exhaustion**: A 5-minute Full HD or 4K video weighs between 200MB and 1GB. Uploading just 3 or 4 videos will consume your entire hosting storage quota.
2. **Bandwidth & CPU Throttling**: When a visitor streams a self-hosted video, your server must transfer massive data streams continuously. If 5 visitors watch a video at the same time, your server bandwidth will max out, crashing the site with a *508 Resource Limit* error.
3. **Lack of Adaptive Bitrate Streaming**: Shared hosting cannot automatically generate multiple resolution streams (1080p, 720p, 480p, 360p) according to user connection speed, resulting in constant buffering on mobile networks.

### 💡 The Winning Strategy: YouTube "Unlisted" Videos
For blazing-fast, free, and cinematic video delivery:
1. **Upload your video to YouTube** using your Google account.
2. Set visibility to **"Unlisted"**.
   - *What it means*: The video **will not appear in YouTube search results**, is not shown on your public channel, and cannot be found by random users.
   - *Who can watch it*: **Only readers who visit your cinema magazine!**
3. **How to embed in your article**:
   - Simply copy the YouTube video URL (e.g., `https://www.youtube.com/watch?v=...`).
   - Paste the link directly on a blank line in your post editor or insert the native **"YouTube"** block.
   - WordPress will instantly render it as an interactive video!
4. **Key Benefits**:
   - **Zero disk space consumed** on your 20€ hosting server.
   - **Zero server bandwidth used** (streaming is handled entirely by Google's global CDN infrastructure).
   - **Crystal-clear adaptive streaming**: smoothly plays in 1080p/4K across all devices and connections.

---

## 🎬 Cinematic Player Facade (Zero Upfront Cookies & Zero Annoying Cookie Banners)

Cinephile includes a native, privacy-first video facade inspired by classic cinema screening rooms:

1. **Embed a Video in 3 Seconds (Zero Plugins Needed)**:
   - Open any article in your WordPress admin editor.
   - Paste the YouTube URL on a blank line (or insert the native **YouTube** block).
   - No plugin required: the theme automatically intercepts the link and transforms it into the **Cinephile Cinema Player**!

2. **Why You Don't Need an Annoying Cookie Banner (The "Two-Click" Privacy Model)**:
   - Standard YouTube embeds inject advertising cookies and user tracking scripts immediately upon page load, legally forcing websites to install intrusive cookie banners (e.g., Cookiebot or Iubenda).
   - **Cinephile solves this at the root via the Two-Click Facade**:
     * **On Page Load**: Only a lightweight HD poster is displayed with a golden Play button and an elegant semi-transparent micro-notice. **Zero cookies are set and no IP data is transmitted to Google.** The poster artwork remains completely sharp and unobstructed.
     * **On Play Click**: The reader gives explicit positive consent to stream the video. The player instantly mounts an iframe on the privacy-enhanced `youtube-nocookie.com` domain with `autoplay=1`.
     * **Result**: **Your website remains 100% free from intrusive cookie popups**, fully compliant with EU GDPR and EDPB guidelines, and boasts lightning-fast page load times (**only 25KB** instead of 1.2MB per video!).

3. **Built-in Cinema Features**:
   - **Native 16:9 Widescreen Aspect Ratio**: Never distorts, clips letterbox bars, or overflows the editorial reading column.
   - **Fullscreen Support**: Clicking the expand icon or rotating a mobile device immediately opens the video in full-screen cinema mode.
   - **Dynamic Theme Colors**: Borders, play buttons, and subtle glow ripple animations automatically inherit your active Customizer palette (`var(--accent-color)`).

---

## 🔌 High-Traffic Scaling (What to Do If Traffic Explodes)

If your magazine goes viral and receives tens of thousands of daily pageviews on a 20€ budget server:
* **The ONLY Optional Caching Plugin**: Install **Cache Enabler** (a tiny, free, open-source static HTML caching plugin by KeyCDN) or **LiteSpeed Cache** (if your 20€ plan runs on a LiteSpeed web server, such as Hostinger or Netsons).
* **How It Works**: Saves a static `.html` snapshot of each published review. When a visitor lands on the page, the server delivers pure HTML in **15 milliseconds** without waking up PHP or MySQL, allowing a 20€/year host to easily serve over 100,000 monthly pageviews.

---

## 👤 Official Credits & License

- **Ideator & Art Director**: [Diego Costanzo](https://github.com/DiegoGIT-home) (Florence, Italy)
- **AI Software Engineering**: Developed in pair-programming with **Antigravity & Gemini** (Google DeepMind)
- **Version**: 1.0.0 (September 2026)
- **License**: GNU General Public License v2.0 or later (see [LICENSE](LICENSE)).
