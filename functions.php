<?php
/**
 * Controller e Orchestratore Principale del Tema
 *
 * Caricamento centralizzato e condizionale di tutti i moduli funzionali atomici nella cartella /inc/.
 * Conforme alle linee guida di architettura: functions.php opera unicamente da orchestratore require_once.
 *
 * Tema: Cinephile - Editorial Cinema Magazine
 * Ideatore: Diego Costanzo (Firenze, Italia)
 * Autore & Programmatore: Antigravity & Gemini (Google DeepMind)
 * Realizzato con l'ausilio di Intelligenza Artificiale (AI)
 * Versione: 1.0.0 - Settembre 2026
 * Licenza: GNU General Public License v2 or later (Open Source)
 *
 * @package    Cinephile
 * @author     Diego Costanzo & Antigravity
 * @copyright  2026 Diego Costanzo (Firenze, Italia)
 * @license    GPL-2.0-or-later
 * @version    1.0.0
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   CARICAMENTO MODULI CORE ATOMICI (/inc/)
   ========================================================================== */

/**
 * Mappatura esaustiva dei file di supporto con architettura a singola responsabilità (SRP).
 */
$cinephile_inc_dir = get_template_directory() . '/inc/';

$cinephile_moduli_core = array(
	'setup.php',              // Configurazione iniziale, supporti core WP e nav menu
	'assets.php',             // Enqueue fogli di stile, font locali, script e favicon
	'security.php',           // Disabilitazione XML-RPC, firewall leggero e pulizia header
	'performance.php',        // Ottimizzazione asset, rimozione bloatware ed epurazione Transient Cache
	'template-tags.php',      // Helper layout, calcolo tempo di lettura e fallback estratti
	'metabox-film.php',       // Scheda tecnica film e metabox dati strutturati
	'metabox-gallery.php',    // Override stile scenografia galleria per singolo post
	'metabox-positions.php',  // Gestione slot dinamici posizionali della Homepage
	'seo-schema.php',         // Microdati Schema.org (JSON-LD) e Meta Tag Open Graph
	'excerpt-cleaner.php',    // Sanitizzazione ed elaborazione estratti puliti (rimozione URL)
	'mail-protetta.php',      // Mascheramento e protezione email anti-spam (Base64/JS)
	'image-optimization.php', // Taglie personalizzate e conversione forzata in WebP
	'form-contatti.php',      // Logica backend, validazione, rate limiting, debug ed invio form
	'search-filters.php',     // Filtri di esclusione pagine istituzionali dalla ricerca
	'hide-featured-image.php',// Gestione tag di servizio per soppressione cover
	'setup-pages.php',        // Creazione e gestione automatica pagine di sistema
	'customizer.php',         // Pannello di configurazione unificato Customizer & CSS Variables
	'video-player.php',       // Player video cinematografico (Lite Facade & Due Clic GDPR)
);

// Inclusione sequenziale controllata tramite require_once
foreach ( $cinephile_moduli_core as $modulo ) {
	$file_path = $cinephile_inc_dir . $modulo;
	if ( file_exists( $file_path ) ) {
		require_once $file_path;
	}
}
