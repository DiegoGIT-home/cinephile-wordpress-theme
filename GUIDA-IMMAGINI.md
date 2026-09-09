# 📸 Guida ai Formati, Risoluzioni e Ottimizzazione Immagini

> **Guida Operativa per la Redazione & i Collaboratori di Cinephile**  
> In una rivista di cinema online, le immagini (locandine, fotogrammi di scena, ritratti di registi e attori) rappresentano l'80% del peso complessivo delle pagine. Caricare immagini enormi, non ottimizzate o nel formato sbagliato rallenta il sito, consuma i dati mobili dei lettori e penalizza il posizionamento su Google (Core Web Vitals).  
> 
> Questa guida offre una **formula rapida, chiara e completa** per sapere esattamente **quale formato scegliere**, a **quale risoluzione ritagliare** e **come comprimere** ogni singola immagine del sito prima di caricarla.

---

## ⚡ Tabella di Riferimento Rapido (A Colpo d'Occhio)

| Elemento del Sito | Posizione / Utilizzo | Risoluzione Consigliata | Rapporto (Ratio) | Formato Raccomandato | Peso Massimo Target |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Logo del Sito** | Header / Barra di navigazione | **Larghezza 600–800 px** (altezza prop. ~150–200 px) | Orizzontale | **SVG** *(ideale)* o **PNG/WebP** trasparente | **< 30–50 KB** |
| **Favicon / Icona Sito** | Scheda browser e app mobile | **512 × 512 px** | 1:1 Quadrato | **PNG** trasparente | **< 30 KB** |
| **Immagine in Evidenza** | Copertina articolo, Home, Social OG | **1200 × 675 px** *(o 1200×630)* | **16:9** Widescreen | **WebP** *(o JPEG compresso)* | **< 150–200 KB** |
| **Foto nel Corpo Articolo** | Fotogrammi e scene nel testo | **Larghezza 800–1000 px** (altezza libera) | Libero / Originale | **WebP** *(o JPEG compresso)* | **< 80–120 KB** |
| **Galleria & Lightbox HD** | Polaroid gallery e scatti scena | **1600 × 900–1060 px** (lato lungo max 1600px) | 16:9 / 3:2 | **WebP** *(o JPEG compresso)* | **< 200–250 KB** |
| **Foto Profilo / Autore** | Scheda critico, firma articolo, Chi Siamo | **300 × 300 px** *(o 400×400)* | **1:1** Quadrato | **WebP**, **JPEG** o **PNG** | **< 40–60 KB** |
| **Banner Pagina "Chi Siamo"** | Copertina panoramica manifesto | **1200 × 350 px** *(o 1200×400)* | **3:1 / 16:5** Ultrawide | **WebP** *(o JPEG compresso)* | **< 120–150 KB** |
| **Icone dei 3 Pilastri** | Sezione valori in "Chi Siamo" | **28 × 28 px** (vettoriale) | 1:1 | **SVG** (o icone integrate) | **< 5 KB** |

---

## 🎨 Quale Formato Scegliere e Perché

### 1. 🥇 WebP (Lo Standard Moderno Raccomandato)
* **Quando usarlo**: Per **tutte le fotografie, locandine e fotogrammi cinematografici** (immagini in evidenza, gallerie, corpo dell'articolo).
* **Perché**: A parità di qualità visiva percepita, pesa dal **30% al 45% in meno** rispetto a un JPEG tradizionale. È supportato al 100% da tutti i browser moderni (Chrome, Safari, Firefox, Edge, smartphone iOS e Android).

### 2. ✒️ SVG (Vettoriale per Grafica e Loghi)
* **Quando usarlo**: Per il **Logo ufficiale della testata**, pittogrammi e icone.
* **Perché**: Non è una griglia di pixel ma una formula geometrica: pesa una manciata di kilobyte (spesso meno di 15 KB) e rimane **nitidissimo e perfetto a qualsiasi livello di zoom** su schermi 4K e Retina, senza mai sgranare.

### 3. 🖼️ PNG con Trasparenza
* **Quando usarlo**: Esclusivamente quando serve uno **sfondo trasparente** (ad esempio un logo con trasparenza qualora non si disponga dell'SVG, o la Favicon quadrata a 512×512px).
* **Attenzione**: Non usare MAI il formato PNG per le fotografie o i fotogrammi di scena: produrrebbe file da 2 a 5 Megabyte, pesantissimi e inutili!

### 4. 📷 JPEG / JPG (Formato Tradizionale di Fallback)
* **Quando usarlo**: Se non hai modo di convertire in WebP prima del caricamento.
* **Consiglio**: Comprimi sempre con qualità **78% – 82%** (oltre l'85% l'occhio umano non nota differenze ma il file raddoppia di peso).

---

## 🔍 Dettaglio per Ogni Tipologia di Immagine

### 1. Immagine in Evidenza (Featured Image) & Locandina Film
* **Dove si carica**: Nella barra laterale destra di WordPress durante la stesura dell'articolo &rarr; **Immagine in evidenza**.
* **Utilizzi automatici del tema**:
  * Copertina a tutta larghezza in cima alla recensione (*Hero banner*).
  * Schede della Home Page (Slot *Primo Piano*, *Focus*, *Dall'Archivio*).
  * Griglie degli archivi Categorie, Tag e Ricerca.
  * Anteprima per i social (Facebook, X/Twitter, WhatsApp, Telegram, Google Discover).
* **Risoluzione d'oro**: **1200 × 675 pixel** (rapporto widescreen 16:9).
* **Peso ideale**: tra **120 KB e 180 KB** in formato WebP.
* **Consiglio cinematografico**: Scegli un fotogramma orizzontale significativo con il soggetto principale centrato (il tema applica un ritaglio centrale fluido sui display compatti).

### 2. Immagini nel Corpo dell'Articolo (Editor Gutenberg)
* **Dove si carica**: Nel blocco *Immagine* all'interno del testo.
* **Risoluzione d'oro**: Larghezza massima consigliata di **800–1000 pixel**.
* **Peso ideale**: tra **60 KB e 100 KB**.
* **Nota tecnica**: Il tema registra automaticamente la taglia `foto_articolo` a 800px di larghezza per evitare di servire al browser l'immagine originale gigante.

### 3. Galleria Fotografica & Scenografia Polaroid (Lightbox)
* **Dove si carica**: Nel blocco *Galleria* di WordPress o tramite immagini singole all'interno dell'articolo.
* **Risoluzione d'oro**: **1600 pixel** sul lato lungo (ad es. 1600×900 o 1600×1067).
* **Peso ideale**: **< 200–250 KB**.
* **Nota tecnica**: Il tema mette a disposizione la taglia `foto_galleria_hd` (1600px max) per consentire ingrandimenti definiti nel lightbox senza consumare gigabyte di banda.

### 4. Logo del Sito (Header e Barra di Navigazione)
* **Dove si imposta**: **Aspetto > Personalizza > Denominazione del sito > Logo**.
* **Risoluzione d'oro**: 
  * Se in **SVG**: scalabile all'infinito, peso < 20 KB.
  * Se in **PNG/WebP con sfondo trasparente**: risoluzione di caricamento consigliata **600 × 150 px** o **800 × 200 px** (il CSS del tema lo visualizza a circa 45–55px di altezza, mantenendolo nitidissimo sui display Retina ad alta densità).
* **Peso ideale**: **< 30–50 KB**.

### 5. Favicon & Icona del Sito
* **Dove si imposta**: **Aspetto > Personalizza > Denominazione del sito > Icona del sito**.
* **Risoluzione d'oro**: **512 × 512 pixel** (formato quadrato perfetto 1:1, PNG trasparente).
* **Cosa fa WordPress**: Genera in automatico tutte le versioni per i browser (32×32), i segnalibri, i dispositivi Android (192×192) e l'icona home per iPhone e iPad (*Apple Touch Icon* 180×180).

### 6. Foto Profilo / Avatar dei Critici e Autori
* **Dove si gestisce**: Tramite il servizio globale **Gravatar** (collegato all'email dell'utente di WordPress) oppure da **Aspetto > Personalizza > Pagina Chi Siamo > Foto Autore**.
* **Risoluzione d'oro**: **300 × 300 pixel** (quadrato 1:1).
* **Peso ideale**: **< 40–50 KB**.

### 7. Banner Panoramico della Pagina "Chi Siamo"
* **Dove si imposta**: **Aspetto > Personalizza > Pagina Chi Siamo > Immagine di Copertina** (oppure caricando l'immagine in evidenza della pagina).
* **Risoluzione d'oro**: **1200 × 350 pixel** (o 1200×400 pixel, formato panoramico cinematografico).
* **Peso ideale**: **< 150 KB**.

---

## 🛠️ Strumenti Gratuiti per Convertire e Ridurre il Peso in 5 Secondi

Non serve essere esperti di grafica o possedere software a pagamento per ottimizzare le immagini. Ecco i migliori strumenti gratuiti consigliati:

### 1. 🚀 [Squoosh.app](https://squoosh.app/) *(Consigliato da Google - Il Migliore)*
* **Come funziona**: È un'applicazione web gratuita sviluppata da Google Chrome Labs. Non richiede installazione né registrazione.
* **Istruzioni in 3 passi**:
  1. Trascina l'immagine nella finestra del browser.
  2. Nel pannello a destra, sotto **Resize**, imposta la larghezza (es. `1200` per l'immagine in evidenza).
  3. Sotto **Compress**, scegli **WebP** con qualità `80%` (o lasciata al valore predefinito).
  4. Clicca sull'icona di download blu in basso a destra. Il file passerà tipicamente da 4 MB a 120 KB senza alcuna perdita visibile!

### 2. 🐼 [TinyPNG / TinyJPG](https://tinypng.com/)
* Ottimo per comprimere al volo fino a 20 immagini contemporaneamente con un semplice drag & drop.

### 3. 🖥️ Photopea ([photopea.com](https://www.photopea.com/))
* Un Photoshop completo direttamente nel browser, 100% gratuito.
* Menu **File > Esporta come > WebP** &rarr; imposta larghezza a 1200px e qualità a 80%.

---

## 💡 Il Motore di Ottimizzazione Automatico Integrato in Cinephile

Il tema **Cinephile** non lascia nulla al caso: all'interno del file [`inc/image-optimization.php`](inc/image-optimization.php) è già attiva una configurazione ad alte prestazioni:

1. **Conversione Automatica dei Ritagli in WebP**: Quando carichi un file JPEG o PNG, il server di WordPress genera automaticamente i formati intermedi (miniature, card, bento grid) direttamente in formato compresso `.webp`.
2. **Disattivazione Formati Inutili**: Abbiamo rimosso la generazione automatica delle dimensioni ridondanti di default di WordPress (come 1536px e 2048px), risparmiando oltre il 60% dello spazio disco del tuo hosting economico.
3. **Lazy Loading Nativo & Priorità LCP**: Le immagini secondarie vengono caricate solo quando l'utente scorre la pagina (`loading="lazy"`), mentre la copertina principale dell'articolo riceve priorità immediata (`fetchpriority="high"`) per un punteggio massimo su Google PageSpeed.

---

## 🚫 I 4 Errori Più Comuni da Evitare

1. ❌ **Caricare foto scattate con smartphone o reflex senza ridimensionarle**: Le fotocamere moderne salvano a 4000×3000px pesando 6–15 MB. Questo esaurisce lo spazio del server e blocca la navigazione da mobile.
2. ❌ **Usare il formato PNG per le fotografie**: Il PNG non è concepito per le foto complesse; salverà file enormi. Usa PNG solo per loghi e icone con sfondo trasparente.
3. ❌ **Dimenticare il Testo Alternativo (Tag ALT)**: Quando carichi un'immagine, compila sempre il campo "Testo alternativo" con una breve descrizione della scena (es. *Primo piano di Cillian Murphy nel film Oppenheimer*). È essenziale per la SEO di Google Immagini e per l'accessibilità degli utenti ipovedenti.
4. ❌ **Caricare immagini verticali come Immagine in Evidenza**: L'immagine in evidenza richiede un taglio orizzontale (16:9). Una locandina verticale verrebbe tagliata in modo sgradevole al centro. Per le locandine verticali, inseriscile nel corpo del testo dell'articolo!
