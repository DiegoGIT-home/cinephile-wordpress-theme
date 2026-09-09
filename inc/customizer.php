<?php
/**
 * Modulo Customizer Unificato e Gestione Variabili CSS
 *
 * Registrazione controlli personalizzabili (Brand, Palette, Tipografia, Contatti, Dati Legali, Layout) e iniezione CSS :root.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Protezione da accesso diretto via URL.
}

/* ==========================================================================
   1. MAPPA CENTRALE DEI VALORI PREDEFINITI (DEFAULTS)
   ========================================================================== */

/**
 * Restituisce l'array unificato di tutti i valori predefiniti del tema.
 * Se un'opzione non è ancora stata modificata dall'utente nel Customizer,
 * il sistema usa questi valori neutrali come fallback automatico.
 *
 * @return array Mappa chiave => valore predefinito.
 */
function cinephile_get_customizer_defaults() {
	$site_name = get_bloginfo( 'name' );
	if ( empty( $site_name ) ) {
		$site_name = __( 'Cinephile', 'cinephile' );
	}

	$site_desc = get_bloginfo( 'description' );
	if ( empty( $site_desc ) ) {
		$site_desc = __( 'Rivista indipendente di analisi e approfondimento cinematografico', 'cinephile' );
	}

	$admin_email = get_option( 'admin_email' );
	if ( empty( $admin_email ) ) {
		$admin_email = 'redazione@example.com';
	}

	return array(
		// --- 1. BRAND & PALETTE COLORI (CSS VARIABLES) ---
		'brand_name'                 => $site_name,
		'brand_tagline'              => $site_desc,
		'header_logo_url'            => get_theme_file_uri( '/assets/img/cinephile-logo.webp' ),
		'theme_color_accent'         => '#c2410c', // Terracotta ambrato caldo / cinematografico
		'theme_bg_canvas'            => '#f8fafc', // Slate 50: Sfondo generale neutro, chiaro e rilassante
		'theme_text_main'            => '#0f172a', // Slate 900: Inchiostro scuro ad altissimo contrasto (WCAG AAA)
		'theme_bg_card'              => '#ffffff', // Bianco puro: Stacco volumetrico e profondità delle schede
		'theme_text_muted'           => '#64748b', // Slate 500: Testo secondario, date e metadati bilanciati
		'theme_border_line'          => '#e2e8f0', // Slate 200: Linee divisorie, campi e bordi definiti e puliti

		// --- 2. TIPOGRAFIA LOCALE & SISTEMA (GDPR SAFE) ---
		'theme_typography_preset'    => 'editorial', // Retrocompatibilità
		'font_family_title'          => 'playfair',  // Playfair Display: grazie ad alto contrasto per testata e titoli
		'font_custom_title_file'     => '',
		'font_custom_title_name'     => '',
		'font_family_body'           => 'plus_jakarta', // Plus Jakarta Sans: moderno geometrico nitido per lettura
		'font_custom_body_file'      => '',
		'font_custom_body_name'      => '',
		'enable_comments_system'     => false,

		// --- 3. PAGINA CONTATTI & MODULO ---
		'contact_hero_kicker'        => __( "PARLA CON LA REDAZIONE", 'cinephile' ),
		'contact_hero_intro'         => sprintf(
			/* translators: %s: Nome del sito web */
			__( '%s è uno spazio editoriale aperto al dialogo e alle collaborazioni. Hai un feedback, un suggerimento o una proposta? Scrivici compilando il modulo o usa i nostri recapiti diretti.', 'cinephile' ),
			'<strong>' . esc_html( $site_name ) . '</strong>'
		),
		'contact_author_name'        => __( 'Redazione & Direzione', 'cinephile' ),
		'contact_author_role'        => __( 'Coordinamento Editoriale & Stampa', 'cinephile' ),
		'contact_author_desc'        => __( 'Spazio dedicato a lettori, collaboratori e distributori per proposte di recensione, interviste ed eventi speciali.', 'cinephile' ),
		'contact_author_avatar'      => '',
		// Recapito 1 (Email Principale)
		'contact_card1_title'        => __( 'Email Redazione', 'cinephile' ),
		'contact_card1_email'        => $admin_email,
		'contact_card1_icon'         => 'email', // email | pec | chat | send
		// Recapito 2 (Secondario opzionale)
		'contact_card2_enable'       => false,
		'contact_card2_title'        => __( 'Recapito Telefonico', 'cinephile' ),
		'contact_card2_text'         => '+39 000 0000000',
		'contact_card2_icon'         => 'phone', // phone | whatsapp | clock | location
		// Recapito 3 (Sede/Indirizzo opzionale)
		'contact_card3_enable'       => false,
		'contact_card3_title'        => __( 'Sede Operativa', 'cinephile' ),
		'contact_card3_text'         => __( 'Via Roma 1, 00100 Roma (RM)', 'cinephile' ),
		'contact_card3_icon'         => 'location', // location | building | star
		// Modulo contatti & Rate Limiting
		'contact_email'              => $admin_email,
		'contact_button_label'       => __( 'Invia Messaggio', 'cinephile' ),
		'contact_privacy_notice'     => __( "I dati inseriti e l'indirizzo IP di connessione vengono temporaneamente elaborati per un massimo di 15 minuti al solo fine di proteggere il sistema da invii spam automatizzati.", 'cinephile' ),

		// --- 4. DATI LEGALI, PRIVACY POLICY & FORNITORE HOSTING ---
		'owner_name'                 => __( '[Nome e Cognome / Ragione Sociale Titolare]', 'cinephile' ),
		'owner_city'                 => __( '[Città / Sede Legale Titolare]', 'cinephile' ),
		'owner_email'                => $admin_email,
		'hosting_name'               => __( '[Nome Fornitore Hosting]', 'cinephile' ),
		'hosting_address'            => __( '[Sede Legale Fornitore Hosting]', 'cinephile' ),
		'hosting_privacy_url'        => 'https://example.com/privacy',

		// --- 5. PAGINA CHI SIAMO (MANIFESTO EDITORIALE) ---
		'about_hero_kicker'          => __( 'IL MANIFESTO EDITORIALE', 'cinephile' ),
		'about_hero_intro'           => sprintf(
			/* translators: %s: Nome del sito web */
			__( '%s è una rivista digitale indipendente. Nasce per offrire uno sguardo analitico, slegato da logiche commerciali, sul cinema contemporaneo, i classici del passato e i principali festival internazionali.', 'cinephile' ),
			'<strong>' . esc_html( $site_name ) . '</strong>'
		),
		'about_cover_image'          => get_theme_file_uri( '/assets/img/about-hero-banner.webp' ),
		'about_pillar1_title'        => __( 'Indipendenza Critica', 'cinephile' ),
		'about_pillar1_desc'         => __( 'Nessun condizionamento commerciale o promozionale. Analisi critiche sincere, rigorose e fondate su una visione autoriale autentica.', 'cinephile' ),
		'about_pillar1_icon'         => 'compass',
		'about_pillar1_custom_icon'  => '',
		'about_pillar2_title'        => __( 'Festival & Rassegne', 'cinephile' ),
		'about_pillar2_desc'         => __( 'Copertura capillare delle rassegne e dei festival cinematografici con diari di bordo, recensioni in anteprima e reportage speciali.', 'cinephile' ),
		'about_pillar2_icon'         => 'film',
		'about_pillar2_custom_icon'  => '',
		'about_pillar3_title'        => __( 'Saggi & Approfondimenti', 'cinephile' ),
		'about_pillar3_desc'         => __( 'Monografie, retrospettive tematiche e saggi visivi concepiti come archivio culturale permanente pensato per durare nel tempo.', 'cinephile' ),
		'about_pillar3_icon'         => 'book',
		'about_pillar3_custom_icon'  => '',
		'about_author_name'          => __( 'Curatore del Progetto', 'cinephile' ),
		'about_author_role'          => __( 'Fondatore & Direttore Editoriale', 'cinephile' ),
		'about_author_bio'           => __( 'Critico e saggista cinematografico. Cura la linea editoriale, la selezione degli speciali e il coordinamento del comitato dei collaboratori.', 'cinephile' ),
		'about_author_avatar'        => '',

		// --- 6. CONTENUTI TEMPLATE (HOME, ARCHIVI, RICERCA, 404) ---
		'home_section_focus_title'   => __( 'In Primo Piano', 'cinephile' ),
		'home_section_archive_title' => __( 'Ultime Recensioni & Saggi', 'cinephile' ),
		'archive_main_title'         => __( 'Archivio Critiche & Saggi', 'cinephile' ),
		'archive_read_more_text'     => __( 'Leggi articolo', 'cinephile' ),
		'tag_hero_kicker'            => __( 'Esplora per Argomento', 'cinephile' ),
		'search_hero_kicker'         => __( 'Risultati della Ricerca', 'cinephile' ),
		'search_no_results_badge'    => __( 'Nessun articolo trovato', 'cinephile' ),
		'error_404_kicker'           => __( '404 - Pellicola Smarrita', 'cinephile' ),
		'error_404_button_label'     => __( 'Torna alla Home', 'cinephile' ),
		'default_fallback_image'     => '',
		'single_show_featured_image' => true,
		'show_featured_images'       => true,
		'enable_author_archive_links' => false,

		// --- 7. SOCIAL MEDIA & ESTERNI ---
		'social_letterboxd'          => '',
		'social_instagram'           => '',
		'social_youtube'             => '',
		'social_x'                   => '',

		// --- 8. FOOTER & CREDITI ---
		'footer_copyright_text'      => sprintf(
			/* translators: 1: Anno corrente, 2: Nome del sito web */
			__( '© %1$s %2$s. Tutti i diritti riservati.', 'cinephile' ),
			date_i18n( 'Y' ),
			$site_name
		),
		'footer_credits_text'        => __( 'Rivista culturale indipendente • 100% Privacy & GDPR Native', 'cinephile' ),
		'footer_show_credits'        => true,

		// --- 9. SCENOGRAFIA GALLERIA CINEMA & RESET ---
		'gallery_props_preset'       => 'classico_master',
		'gallery_random_rot'         => true,
		'customizer_reset_all'       => false,
	);
}

/* ==========================================================================
   2. WHITELIST & SANITIZZAZIONE DEI CONTROLLI
   ========================================================================== */

/**
 * Whitelist centralizzata degli stili di scenografia galleria (12 preset + nessuna).
 *
 * @return array Lista identificatori consentiti.
 */
function cinephile_get_gallery_presets() {
	return array(
		'classico_master', 'classico_v1', 'classico_v2', 'classico_v3',
		'regia_master', 'regia_v1', 'regia_v2', 'regia_v3',
		'moviola_master', 'moviola_v1', 'moviola_v2', 'moviola_v3',
		'none',
	);
}

/**
 * Sanitizza il preset della galleria controllandone la presenza nella whitelist.
 *
 * @param string $preset   Valore inviato.
 * @param string $fallback Valore predefinito.
 * @return string Preset validato.
 */
function cinephile_sanitize_gallery_preset( $preset, $fallback = 'classico_master' ) {
	$preset  = sanitize_key( $preset );
	$allowed = cinephile_get_gallery_presets();
	return in_array( $preset, $allowed, true ) ? $preset : $fallback;
}

/**
 * Sanitizzazione generica per controlli Select tramite confronto con le scelte (choices).
 *
 * @param mixed                $input   Valore selezionato.
 * @param WP_Customize_Setting $setting Oggetto setting del Customizer.
 * @return mixed Valore validato oppure il default.
 */
function cinephile_sanitize_select( $input, $setting ) {
	$input   = sanitize_text_field( $input );
	$control = $setting->manager->get_control( $setting->id );
	if ( $control && isset( $control->choices ) && is_array( $control->choices ) ) {
		return array_key_exists( $input, $control->choices ) ? $input : $setting->default;
	}
	return $setting->default;
}

/**
 * Sanitizzazione restrittiva per campi di testo ricco (textarea formative).
 * Ammette esclusivamente tag di formattazione sicuri evitando injection di script, form o iframe.
 *
 * @param string $input Testo inserito.
 * @return string Testo filtrato e sicuro.
 */
function cinephile_sanitize_rich_text( $input ) {
	$allowed = array(
		'a'      => array(
			'href'   => array(),
			'title'  => array(),
			'target' => array(),
			'rel'    => array(),
		),
		'strong' => array(),
		'b'      => array(),
		'em'     => array(),
		'i'      => array(),
		'p'      => array(),
		'br'     => array(),
		'span'   => array(
			'class' => array(),
		),
		'code'   => array(),
	);
	return wp_kses( (string) $input, $allowed );
}

/**
 * Condizionale Customizer: Mostra i controlli di upload e nome font solo se è selezionato 'custom' per i titoli.
 *
 * @param WP_Customize_Control $control Oggetto del controllo Customizer.
 * @return bool True se il font titoli selezionato è 'custom'.
 */
function cinephile_is_custom_title_font( $control ) {
	$setting = $control->manager->get_setting( 'font_family_title' );
	return $setting && 'custom' === $setting->value();
}

/**
 * Condizionale Customizer: Mostra i controlli di upload e nome font solo se è selezionato 'custom' per il corpo.
 *
 * @param WP_Customize_Control $control Oggetto del controllo Customizer.
 * @return bool True se il font corpo selezionato è 'custom'.
 */
function cinephile_is_custom_body_font( $control ) {
	$setting = $control->manager->get_setting( 'font_family_body' );
	return $setting && 'custom' === $setting->value();
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Cinephile_Customizer_Header_Control' ) ) {
	/**
	 * Controllo divisore decorativo per creare gerarchia e separatori visivi nella sidebar Customizer.
	 */
	class Cinephile_Customizer_Header_Control extends WP_Customize_Control {
		public $type = 'cec_header';

		public function render_content() {
			if ( ! empty( $this->label ) ) {
				echo '<div class="cec-customizer-header-badge">';
				echo '<span>' . esc_html( $this->label ) . '</span>';
				echo '</div>';
			}
			if ( ! empty( $this->description ) ) {
				echo '<p class="description customize-control-description cec-header-desc">' . wp_kses_post( $this->description ) . '</p>';
			}
		}
	}
}

/* ==========================================================================
   3. REGISTRAZIONE SEZIONI, SETTAGGI E CONTROLLI CUSTOMIZER
   ========================================================================== */

/**
 * Inizializza il pannello Customizer organizzato in 8 sezioni logiche, progressive e didattiche.
 * Rimuove sezioni ridondanti di WordPress core e attiva il supporto live preview.
 *
 * @param WP_Customize_Manager $wp_customize Gestore del Customizer.
 */
function cinephile_customize_register( $wp_customize ) {
	$defaults = cinephile_get_customizer_defaults();

	// --------------------------------------------------------------------------
	// 0. PULIZIA SEZIONI NATIVE WORDPRESS RIDONDANTI O NON UTILIZZATE
	// --------------------------------------------------------------------------
	$wp_customize->remove_section( 'colors' );           // La palette è gestita interamente tramite le CSS Variables del tema
	$wp_customize->remove_section( 'header_image' );     // Sostituita dalla Hero e dal Logo testata dedicati
	$wp_customize->remove_section( 'background_image' ); // Sostituita dal controllo Sfondo Canvas del tema

	// Sposta il controllo nativo Favicon / Icona del Sito nella nostra Sezione 1 (Identità)
	if ( $wp_customize->get_control( 'site_icon' ) ) {
		$wp_customize->get_control( 'site_icon' )->section     = 'cec_brand_identity';
		$wp_customize->get_control( 'site_icon' )->priority    = 30;
		$wp_customize->get_control( 'site_icon' )->label       = __( 'Icona del Sito / Favicon', 'cinephile' );
		$wp_customize->get_control( 'site_icon' )->description = __( 'Compare nelle schede del browser, nei segnalibri e come icona dell\'app per smartphone (consigliata immagine quadrata di almeno 512×512 pixel).', 'cinephile' );
	}
	$wp_customize->remove_section( 'title_tagline' );

	/* --------------------------------------------------------------------------
	   SEZIONE 1: IDENTITÀ DEL SITO, LOGO & ICONA
	   Priorità: 15
	   -------------------------------------------------------------------------- */
	$wp_customize->add_section( 'cec_brand_identity', array(
		'title'       => __( '1. Identità del Sito, Logo & Icona', 'cinephile' ),
		'priority'    => 15,
		'description' => __( 'Definisci l\'identità di base del tuo magazine: nome del sito, motto/sottotitolo, logo grafico per la testata e icona favicon per il browser.', 'cinephile' ),
	) );

	// Intestazione: Nome & Motto
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_brand_info', array(
		'label'    => __( '🏷️ Nome della Testata & Slogan', 'cinephile' ),
		'section'  => 'cec_brand_identity',
		'settings' => array(),
		'priority' => 5,
	) ) );

	// Nome Brand / Testata (Live Preview con postMessage)
	$wp_customize->add_setting( 'brand_name', array(
		'default'           => $defaults['brand_name'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'brand_name', array(
		'label'       => __( 'Nome del Sito / Testata', 'cinephile' ),
		'description' => __( 'Il titolo del tuo sito. Compare nell\'header, nel footer e nei titoli delle pagine.', 'cinephile' ),
		'section'     => 'cec_brand_identity',
		'type'        => 'text',
		'priority'    => 10,
	) );

	// Motto / Sottotitolo (Live Preview)
	$wp_customize->add_setting( 'brand_tagline', array(
		'default'           => $defaults['brand_tagline'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'brand_tagline', array(
		'label'       => __( 'Motto / Sottotitolo del Sito', 'cinephile' ),
		'description' => __( 'Breve frase o slogan descrittivo mostrato sotto il logo nella testata e nei motori di ricerca.', 'cinephile' ),
		'section'     => 'cec_brand_identity',
		'type'        => 'text',
		'priority'    => 20,
	) );

	// Intestazione: Logo
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_brand_logo', array(
		'label'    => __( '🖼️ Logo Grafico dell\'Header', 'cinephile' ),
		'section'  => 'cec_brand_identity',
		'settings' => array(),
		'priority' => 22,
	) ) );

	// Logo Header Personalizzato
	$wp_customize->add_setting( 'header_logo_url', array(
		'default'           => $defaults['header_logo_url'],
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_logo_url', array(
		'label'       => __( 'Logo Grafico dell\'Intestazione', 'cinephile' ),
		'description' => __( 'Carica un\'immagine PNG, SVG o WebP con sfondo trasparente. Se impostata, compare nella testata.', 'cinephile' ),
		'section'     => 'cec_brand_identity',
		'priority'    => 25,
	) ) );

	/* --------------------------------------------------------------------------
	   SEZIONE 2: PALETTE COLORI DEL TEMA (LIVE PREVIEW)
	   Priorità: 20
	   -------------------------------------------------------------------------- */
	$wp_customize->add_section( 'cec_colors_section', array(
		'title'       => __( '2. Palette Colori del Tema (Live)', 'cinephile' ),
		'priority'    => 20,
		'description' => __( 'I 6 colori cardine del sito. Modificando i selettori, la schermata di anteprima a destra si aggiornerà istantaneamente in tempo reale prima di pubblicare.', 'cinephile' ),
	) );

	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_colors_main', array(
		'label'       => __( '🎨 Palette Cromatica del Magazine', 'cinephile' ),
		'description' => __( 'Colori principali di accento, sfondo, schede e testi con aggiornamento in tempo reale.', 'cinephile' ),
		'section'     => 'cec_colors_section',
		'settings'    => array(),
		'priority'    => 1,
	) ) );

	$colors = array(
		'theme_color_accent' => array(
			'label' => __( 'Colore di Accento Primario (--color-accent)', 'cinephile' ),
			'desc'  => __( 'Usato per i pulsanti principali, i link attivi, i tag e le sottolineature decorative.', 'cinephile' ),
		),
		'theme_bg_canvas'    => array(
			'label' => __( 'Sfondo Generale della Pagina (--bg-canvas)', 'cinephile' ),
			'desc'  => __( 'Il colore dello sfondo visibile dietro all\'intero sito web e attorno ai contenuti.', 'cinephile' ),
		),
		'theme_bg_card'      => array(
			'label' => __( 'Sfondo Schede & Riquadri (--bg-card)', 'cinephile' ),
			'desc'  => __( 'Il colore delle singole card degli articoli, delle biografie e dei moduli.', 'cinephile' ),
		),
		'theme_text_main'    => array(
			'label' => __( 'Colore Testo Principale (--text-main)', 'cinephile' ),
			'desc'  => __( 'Colore ad alto contrasto per i titoli e la lettura degli articoli lunghi.', 'cinephile' ),
		),
		'theme_text_muted'   => array(
			'label' => __( 'Colore Testo Secondario (--text-muted)', 'cinephile' ),
			'desc'  => __( 'Colore attenuato per date di pubblicazione, autore, categorie e note a piè di pagina.', 'cinephile' ),
		),
		'theme_border_line'  => array(
			'label' => __( 'Bordi & Linee Divisorie (--border-line)', 'cinephile' ),
			'desc'  => __( 'Colore delle linee sottili che separano le sezioni, i box e le cornici dei moduli.', 'cinephile' ),
		),
	);

	foreach ( $colors as $id => $data ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $defaults[ $id ],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage', // Aggiornamento istantaneo tramite JS
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
			'label'       => $data['label'],
			'description' => $data['desc'],
			'section'     => 'cec_colors_section',
		) ) );
	}

	/* --------------------------------------------------------------------------
	   SEZIONE 3: CARATTERI & TIPOGRAFIA (100% LOCALE & GDPR NATIVE)
	   Priorità: 25
	   -------------------------------------------------------------------------- */
	$wp_customize->add_section( 'cec_typography_section', array(
		'title'       => __( '3. Caratteri & Tipografia (100% Locale)', 'cinephile' ),
		'priority'    => 25,
		'description' => __( 'Tipografia 100% GDPR-compliant e indipendente: tutti i font risiedono sul tuo server senza alcuna connessione verso Google Fonts. Puoi combinare caratteri diversi per i titoli e per la lettura, oppure caricare file font personalizzati (.woff2, .woff, .ttf).', 'cinephile' ),
	) );

	// Scelte font per Titoli
	$font_choices_title = array(
		'playfair'     => __( 'Playfair Display (Serif Elegante / Editoriale)', 'cinephile' ),
		'cinzel'       => __( 'Cinzel (Serif Cinematografico / Epico)', 'cinephile' ),
		'lora'         => __( 'Lora (Serif Letterario per Saggistica)', 'cinephile' ),
		'plus_jakarta' => __( 'Plus Jakarta Sans (Geometrico Moderno)', 'cinephile' ),
		'inter'        => __( 'Inter (Sans Clean Minimal)', 'cinephile' ),
		'outfit'       => __( 'Outfit (Sans Contemporaneo Display)', 'cinephile' ),
		'system_serif' => __( 'Georgia / Serif Nativo OS (Zero Download)', 'cinephile' ),
		'system_sans'  => __( 'System Sans Nativo OS (Apple, Segoe UI, Roboto)', 'cinephile' ),
		'custom'       => __( '📁 Carica File Font Personalizzato (.woff2)', 'cinephile' ),
	);

	// 1. Selezione Font Titoli
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_font_titles', array(
		'label'       => __( '🔤 Carattere per i Titoli (--font-title)', 'cinephile' ),
		'description' => __( 'Applicato alle intestazioni h1, h2, h3, alle schede film e ai titoli degli articoli.', 'cinephile' ),
		'section'     => 'cec_typography_section',
		'settings'    => array(),
	) ) );

	$wp_customize->add_setting( 'font_family_title', array(
		'default'           => $defaults['font_family_title'],
		'sanitize_callback' => 'cinephile_sanitize_select',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'font_family_title', array(
		'label'       => __( 'Seleziona Font Titoli', 'cinephile' ),
		'description' => __( 'Scegli uno dei font inclusi nel tema oppure seleziona l\'opzione per caricare un tuo file .woff2.', 'cinephile' ),
		'section'     => 'cec_typography_section',
		'type'        => 'select',
		'choices'     => $font_choices_title,
	) );

	// Upload Font Titoli Personalizzato (Mostrato SOLO se font_family_title è 'custom')
	$wp_customize->add_setting( 'font_custom_title_file', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'font_custom_title_file', array(
		'label'           => __( 'Carica File Font Titoli (.woff2, .woff, .ttf)', 'cinephile' ),
		'description'     => __( 'Necessario SOLO se sopra selezioni "📁 Carica File Font Personalizzato". Il file viene ospitato sul tuo server in locale (100% GDPR, zero chiamate esterne). Se hai scelto un font dall\'elenco, ignora questo campo.', 'cinephile' ),
		'section'         => 'cec_typography_section',
		'active_callback' => 'cinephile_is_custom_title_font',
	) ) );

	$wp_customize->add_setting( 'font_custom_title_name', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'font_custom_title_name', array(
		'label'           => __( 'Nome Famiglia Font Titoli (Solo per font personalizzato)', 'cinephile' ),
		'description'     => __( 'Necessario SOLO se hai caricato un file font tuo qui sopra: assegna un nome al carattere per il CSS (es. "MioFontTitoli" o "Futura"). Se usi uno dei font già inclusi nell\'elenco a tendina, lascia questo campo vuoto.', 'cinephile' ),
		'section'         => 'cec_typography_section',
		'type'            => 'text',
		'active_callback' => 'cinephile_is_custom_title_font',
	) );

	// Scelte font per Corpo
	$font_choices_body = array(
		'plus_jakarta' => __( 'Plus Jakarta Sans (Geometrico - Massima Leggibilità)', 'cinephile' ),
		'inter'        => __( 'Inter (Sans Clean Neutro)', 'cinephile' ),
		'outfit'       => __( 'Outfit (Sans Contemporaneo)', 'cinephile' ),
		'lora'         => __( 'Lora (Serif Caldo per Letture Lunghe)', 'cinephile' ),
		'playfair'     => __( 'Playfair Display (Serif Classico)', 'cinephile' ),
		'system_sans'  => __( 'System Sans Nativo OS (Apple, Segoe UI, Roboto)', 'cinephile' ),
		'system_serif' => __( 'Georgia / Serif Nativo OS', 'cinephile' ),
		'custom'       => __( '📁 Carica File Font Personalizzato (.woff2)', 'cinephile' ),
	);

	// 2. Selezione Font Corpo / Contesto
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_font_body', array(
		'label'       => __( '📄 Carattere per il Corpo del Testo (--font-body)', 'cinephile' ),
		'description' => __( 'Applicato a paragrafi di lettura, recensioni, schede tecniche, biografie ed estratti.', 'cinephile' ),
		'section'     => 'cec_typography_section',
		'settings'    => array(),
	) ) );

	$wp_customize->add_setting( 'font_family_body', array(
		'default'           => $defaults['font_family_body'],
		'sanitize_callback' => 'cinephile_sanitize_select',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'font_family_body', array(
		'label'       => __( 'Seleziona Font Corpo', 'cinephile' ),
		'description' => __( 'Scegli uno dei font inclusi nel tema oppure seleziona l\'opzione per caricare un tuo file .woff2.', 'cinephile' ),
		'section'     => 'cec_typography_section',
		'type'        => 'select',
		'choices'     => $font_choices_body,
	) );

	// Upload Font Corpo Personalizzato (Mostrato SOLO se font_family_body è 'custom')
	$wp_customize->add_setting( 'font_custom_body_file', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'font_custom_body_file', array(
		'label'           => __( 'Carica File Font Corpo (.woff2, .woff, .ttf)', 'cinephile' ),
		'description'     => __( 'Necessario SOLO se sopra selezioni "📁 Carica File Font Personalizzato". Il file viene ospitato sul tuo server in locale (100% GDPR, zero chiamate esterne). Se hai scelto un font dall\'elenco, ignora questo campo.', 'cinephile' ),
		'section'         => 'cec_typography_section',
		'active_callback' => 'cinephile_is_custom_body_font',
	) ) );

	$wp_customize->add_setting( 'font_custom_body_name', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'font_custom_body_name', array(
		'label'           => __( 'Nome Famiglia Font Corpo (Solo per font personalizzato)', 'cinephile' ),
		'description'     => __( 'Necessario SOLO se hai caricato un file font tuo qui sopra: assegna un nome al carattere per il CSS (es. "MioFontCorpo"). Se usi uno dei font già inclusi nell\'elenco a tendina, lascia questo campo vuoto.', 'cinephile' ),
		'section'         => 'cec_typography_section',
		'type'            => 'text',
		'active_callback' => 'cinephile_is_custom_body_font',
	) );

	/* --------------------------------------------------------------------------
	   SEZIONE 4: PAGINA CONTATTI & MODULO DI INVIO
	   Priorità: 30
	   -------------------------------------------------------------------------- */
	$wp_customize->add_section( 'cec_contact_section', array(
		'title'       => __( '4. Pagina Contatti & Modulo', 'cinephile' ),
		'priority'    => 30,
		'description' => __( 'Personalizza tutti i contenuti visibili nella pagina /contatti/: intestazione, profilo del referente, fino a 3 schede con icone a scelta, email di ricezione e parametri del modulo.', 'cinephile' ),
	) );

	// Hero Kicker & Intro
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_contact_intro', array(
		'label'    => __( '📋 Intestazione & Testo dei Contatti', 'cinephile' ),
		'section'  => 'cec_contact_section',
		'settings' => array(),
	) ) );

	$wp_customize->add_setting( 'contact_hero_kicker', array(
		'default'           => $defaults['contact_hero_kicker'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'contact_hero_kicker', array(
		'label'       => __( 'Kicker Superiore Hero', 'cinephile' ),
		'description' => __( 'Piccola intestazione in maiuscolo sopra il testo introduttivo dei contatti.', 'cinephile' ),
		'section'     => 'cec_contact_section',
		'type'        => 'text',
	) );

	// Hero Intro Text
	$wp_customize->add_setting( 'contact_hero_intro', array(
		'default'           => $defaults['contact_hero_intro'],
		'sanitize_callback' => 'cinephile_sanitize_rich_text',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'contact_hero_intro', array(
		'label'       => __( 'Testo Introduttivo dei Contatti', 'cinephile' ),
		'description' => __( 'Paragrafo di presentazione visualizzato in cima alla pagina dei contatti (supporta formattazione html sicura).', 'cinephile' ),
		'section'     => 'cec_contact_section',
		'type'        => 'textarea',
	) );

	// Avatar Referente
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_contact_author', array(
		'label'       => __( '👤 Profilo del Referente', 'cinephile' ),
		'description' => __( 'Dati del contatto redazionale mostrati in pagina.', 'cinephile' ),
		'section'     => 'cec_contact_section',
		'settings'    => array(),
	) ) );

	$wp_customize->add_setting( 'contact_author_avatar', array(
		'default'           => $defaults['contact_author_avatar'],
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'contact_author_avatar', array(
		'label'       => __( 'Foto / Avatar del Referente', 'cinephile' ),
		'description' => __( 'Immagine circolare mostrata accanto alla scheda del referente (se non impostata, viene usato Gravatar o icona generica).', 'cinephile' ),
		'section'     => 'cec_contact_section',
	) ) );

	// Dati Profilo Referente
	$wp_customize->add_setting( 'contact_author_name', array(
		'default'           => $defaults['contact_author_name'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'contact_author_name', array(
		'label'       => __( 'Nome del Referente', 'cinephile' ),
		'description' => __( 'Nome e cognome della persona di riferimento.', 'cinephile' ),
		'section'     => 'cec_contact_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'contact_author_role', array(
		'default'           => $defaults['contact_author_role'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'contact_author_role', array(
		'label'       => __( 'Ruolo del Referente', 'cinephile' ),
		'description' => __( 'Es. "Fondatore & Redazione" o "Ufficio Stampa".', 'cinephile' ),
		'section'     => 'cec_contact_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'contact_author_desc', array(
		'default'           => $defaults['contact_author_desc'],
		'sanitize_callback' => 'cinephile_sanitize_rich_text',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'contact_author_desc', array(
		'label'       => __( 'Breve Descrizione / Mansioni', 'cinephile' ),
		'description' => __( 'Spiega in poche righe di cosa si occupa il referente o per quali richieste contattarlo.', 'cinephile' ),
		'section'     => 'cec_contact_section',
		'type'        => 'textarea',
	) );

	// --- RECAPITI (Email, Telefono, Sede) ---
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_contact_cards', array(
		'label'       => __( '📬 Schede Recapiti (Fino a 3 box)', 'cinephile' ),
		'description' => __( 'Configura canali diretti con icone a scelta.', 'cinephile' ),
		'section'     => 'cec_contact_section',
		'settings'    => array(),
	) ) );

	$wp_customize->add_setting( 'contact_card1_title', array(
		'default'           => $defaults['contact_card1_title'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'contact_card1_title', array(
		'label'       => __( 'Recapito 1: Titolo Scheda', 'cinephile' ),
		'description' => __( 'Titolo del primo riquadro contatti (es. "Email Diretta").', 'cinephile' ),
		'section'     => 'cec_contact_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'contact_card1_email', array(
		'default'           => $defaults['contact_card1_email'],
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'contact_card1_email', array(
		'label'       => __( 'Recapito 1: Indirizzo Email Pubblico', 'cinephile' ),
		'description' => __( 'Indirizzo email mostrato pubblicamente (protetto automaticamente da antispambot contro i bot web).', 'cinephile' ),
		'section'     => 'cec_contact_section',
		'type'        => 'email',
	) );

	$wp_customize->add_setting( 'contact_card1_icon', array(
		'default'           => $defaults['contact_card1_icon'],
		'sanitize_callback' => 'cinephile_sanitize_select',
	) );
	$wp_customize->add_control( 'contact_card1_icon', array(
		'label'   => __( 'Recapito 1: Icona', 'cinephile' ),
		'section' => 'cec_contact_section',
		'type'    => 'select',
		'choices' => array(
			'email' => __( '✉️ Busta Lettera Classica', 'cinephile' ),
			'pec'   => __( '📜 Lettera Certificata / PEC', 'cinephile' ),
			'chat'  => __( '💬 Fumetto Messaggio', 'cinephile' ),
			'send'  => __( '✈️ Aeroplanino Invia', 'cinephile' ),
		),
	) );

	// --- RECAPITO 2 (Telefono / Orari - Opzionale) ---
	$wp_customize->add_setting( 'contact_card2_enable', array(
		'default'           => $defaults['contact_card2_enable'],
		'sanitize_callback' => 'wp_validate_boolean',
	) );
	$wp_customize->add_control( 'contact_card2_enable', array(
		'label'       => __( 'Mostra Recapito 2 (Secondario)', 'cinephile' ),
		'description' => __( 'Spunta per visualizzare una seconda scheda recapiti accanto alla prima.', 'cinephile' ),
		'section'     => 'cec_contact_section',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'contact_card2_title', array(
		'default'           => $defaults['contact_card2_title'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'contact_card2_title', array(
		'label'   => __( 'Recapito 2: Titolo Scheda', 'cinephile' ),
		'section' => 'cec_contact_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'contact_card2_text', array(
		'default'           => $defaults['contact_card2_text'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'contact_card2_text', array(
		'label'   => __( 'Recapito 2: Testo o Numero di Telefono', 'cinephile' ),
		'section' => 'cec_contact_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'contact_card2_icon', array(
		'default'           => $defaults['contact_card2_icon'],
		'sanitize_callback' => 'cinephile_sanitize_select',
	) );
	$wp_customize->add_control( 'contact_card2_icon', array(
		'label'   => __( 'Recapito 2: Icona', 'cinephile' ),
		'section' => 'cec_contact_section',
		'type'    => 'select',
		'choices' => array(
			'phone'    => __( '📞 Telefono Cornetta', 'cinephile' ),
			'whatsapp' => __( '📱 Cellulare / Chat', 'cinephile' ),
			'clock'    => __( '⏰ Orari & Disponibilità', 'cinephile' ),
			'location' => __( '📍 Posizione Geografica', 'cinephile' ),
		),
	) );

	// --- RECAPITO 3 (Sede / Collaborazioni - Opzionale) ---
	$wp_customize->add_setting( 'contact_card3_enable', array(
		'default'           => $defaults['contact_card3_enable'],
		'sanitize_callback' => 'wp_validate_boolean',
	) );
	$wp_customize->add_control( 'contact_card3_enable', array(
		'label'       => __( 'Mostra Recapito 3 (Sede / Press)', 'cinephile' ),
		'description' => __( 'Spunta per visualizzare una terza scheda informativa.', 'cinephile' ),
		'section'     => 'cec_contact_section',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'contact_card3_title', array(
		'default'           => $defaults['contact_card3_title'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'contact_card3_title', array(
		'label'   => __( 'Recapito 3: Titolo Scheda', 'cinephile' ),
		'section' => 'cec_contact_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'contact_card3_text', array(
		'default'           => $defaults['contact_card3_text'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'contact_card3_text', array(
		'label'   => __( 'Recapito 3: Indirizzo o Testo Informativo', 'cinephile' ),
		'section' => 'cec_contact_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'contact_card3_icon', array(
		'default'           => $defaults['contact_card3_icon'],
		'sanitize_callback' => 'cinephile_sanitize_select',
	) );
	$wp_customize->add_control( 'contact_card3_icon', array(
		'label'   => __( 'Recapito 3: Icona', 'cinephile' ),
		'section' => 'cec_contact_section',
		'type'    => 'select',
		'choices' => array(
			'location' => __( '📍 Posizione Geografica', 'cinephile' ),
			'building' => __( '🏛️ Edificio / Redazione', 'cinephile' ),
			'star'     => __( '⭐ Stella / Partnership', 'cinephile' ),
			'email'    => __( '✉️ Busta Lettera', 'cinephile' ),
		),
	) );

	// Modulo Contatti & Rate Limiting
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_contact_form', array(
		'label'       => __( '✉️ Modulo di Invio & Ricezione Email', 'cinephile' ),
		'description' => __( 'Configura la casella di arrivo dei messaggi e i parametri del modulo.', 'cinephile' ),
		'section'     => 'cec_contact_section',
		'settings'    => array(),
	) ) );

	$wp_customize->add_setting( 'contact_email', array(
		'default'           => $defaults['contact_email'],
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'contact_email', array(
		'label'       => __( 'Email Destinatario del Modulo di Invio', 'cinephile' ),
		'description' => __( 'La casella di posta a cui verranno recapitati i messaggi inviati dai visitatori (default: email amministratore).', 'cinephile' ),
		'section'     => 'cec_contact_section',
		'type'        => 'email',
	) );

	$wp_customize->add_setting( 'contact_button_label', array(
		'default'           => $defaults['contact_button_label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'contact_button_label', array(
		'label'       => __( 'Etichetta del Pulsante di Invio', 'cinephile' ),
		'description' => __( 'Testo sul bottone per spedire il messaggio (es. "Invia Messaggio").', 'cinephile' ),
		'section'     => 'cec_contact_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'contact_privacy_notice', array(
		'default'           => $defaults['contact_privacy_notice'],
		'sanitize_callback' => 'cinephile_sanitize_rich_text',
	) );
	$wp_customize->add_control( 'contact_privacy_notice', array(
		'label'       => __( 'Avviso Privacy & Sicurezza Anti-Spam del Modulo', 'cinephile' ),
		'description' => __( 'Dicitura informativa posta sotto il modulo che spiega la conservazione temporanea di sicurezza dell\'IP per 15 minuti contro lo spam.', 'cinephile' ),
		'section'     => 'cec_contact_section',
		'type'        => 'textarea',
	) );

	/* --------------------------------------------------------------------------
	   SEZIONE 5: DATI LEGALI, PRIVACY POLICY & COMMENTI
	   Priorità: 35
	   -------------------------------------------------------------------------- */
	$wp_customize->add_section( 'cec_legal_section', array(
		'title'       => __( '5. Dati Legali, Privacy Policy & Commenti', 'cinephile' ),
		'priority'    => 35,
		'description' => __( 'Compilando questi dati, la pagina /privacy-e-cookie-policy/ viene popolata automaticamente nel rispetto del GDPR senza dover modificare file di codice. Puoi inoltre abilitare i commenti agli articoli con sincronizzazione immediata.', 'cinephile' ),
	) );

	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_legal_owner', array(
		'label'       => __( '⚖️ Titolare del Trattamento Dati (GDPR)', 'cinephile' ),
		'description' => __( 'Dati del responsabile del sito per conformità al Regolamento UE 2016/679.', 'cinephile' ),
		'section'     => 'cec_legal_section',
		'settings'    => array(),
	) ) );

	$wp_customize->add_setting( 'owner_name', array(
		'default'           => $defaults['owner_name'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'owner_name', array(
		'label'       => __( 'Nome Titolare del Trattamento / Ragione Sociale', 'cinephile' ),
		'description' => __( 'Nome e Cognome della persona fisica o denominazione dell\'associazione/azienda titolare del sito.', 'cinephile' ),
		'section'     => 'cec_legal_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'owner_city', array(
		'default'           => $defaults['owner_city'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'owner_city', array(
		'label'       => __( 'Città / Sede del Titolare', 'cinephile' ),
		'description' => __( 'Comune o luogo di residenza/sede operativa del titolare (es. Firenze, Italia).', 'cinephile' ),
		'section'     => 'cec_legal_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'owner_email', array(
		'default'           => $defaults['owner_email'],
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'owner_email', array(
		'label'       => __( 'Email Ufficiale per Richieste Privacy (GDPR)', 'cinephile' ),
		'description' => __( 'Indirizzo a cui i visitatori possono scrivere per esercitare i propri diritti GDPR (es. accesso o cancellazione).', 'cinephile' ),
		'section'     => 'cec_legal_section',
		'type'        => 'email',
	) );

	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_legal_hosting', array(
		'label'       => __( '🏢 Provider Hosting & Datacenter', 'cinephile' ),
		'description' => __( 'Informazioni tecniche sull\'infrastruttura server.', 'cinephile' ),
		'section'     => 'cec_legal_section',
		'settings'    => array(),
	) ) );

	$wp_customize->add_setting( 'hosting_name', array(
		'default'           => $defaults['hosting_name'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'hosting_name', array(
		'label'       => __( 'Nome Fornitore Servizio Hosting', 'cinephile' ),
		'description' => __( 'Denominazione del provider che ospita server e database del sito (es. SiteGround, Hetzner, OVH...).', 'cinephile' ),
		'section'     => 'cec_legal_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'hosting_address', array(
		'default'           => $defaults['hosting_address'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'hosting_address', array(
		'label'       => __( 'Sede Legale del Fornitore Hosting', 'cinephile' ),
		'description' => __( 'Sede legale del provider per attestare la conformità europea (es. Milano, MI, Italia - Datacenter UE).', 'cinephile' ),
		'section'     => 'cec_legal_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'hosting_privacy_url', array(
		'default'           => $defaults['hosting_privacy_url'],
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'hosting_privacy_url', array(
		'label'       => __( 'Link Informativa Privacy del Fornitore Hosting', 'cinephile' ),
		'description' => __( 'Indirizzo web (URL) della policy privacy ufficiale pubblicata dal tuo provider di hosting.', 'cinephile' ),
		'section'     => 'cec_legal_section',
		'type'        => 'url',
	) );

	// Toggle Sistema Commenti & Privacy Correlata
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_legal_comments', array(
		'label'       => __( '💬 Commenti & Moderazione Pubblica', 'cinephile' ),
		'description' => __( 'Abilitazione dei commenti agli articoli con informativa privacy integrata.', 'cinephile' ),
		'section'     => 'cec_legal_section',
		'settings'    => array(),
	) ) );

	$wp_customize->add_setting( 'enable_comments_system', array(
		'default'           => $defaults['enable_comments_system'],
		'sanitize_callback' => 'wp_validate_boolean',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'enable_comments_system', array(
		'label'       => __( 'Abilita Sistema Commenti negli Articoli', 'cinephile' ),
		'description' => __( 'Se abilitato, compare l\'area commenti con form anti-spam sotto gli articoli. La pagina Privacy Policy si adatta automaticamente inserendo la sezione legale specifica su dati raccolti, IP, email, moderazione e diritti GDPR (Artt. 6 e 17 GDPR).', 'cinephile' ),
		'section'     => 'cec_legal_section',
		'type'        => 'checkbox',
	) );

	/* --------------------------------------------------------------------------
	   SEZIONE 6: PAGINA CHI SIAMO (MANIFESTO & TEAM)
	   Priorità: 40
	   -------------------------------------------------------------------------- */
	$wp_customize->add_section( 'cec_about_section', array(
		'title'       => __( '6. Pagina Chi Siamo (Manifesto & Team)', 'cinephile' ),
		'priority'    => 40,
		'description' => __( 'Configura la pagina /chi-siamo/: testo introduttivo del manifesto, banner panoramico, i 3 pilastri fondanti e il profilo dell\'autore/curatore.', 'cinephile' ),
	) );

	// 1. Kicker & Intro Manifesto
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_about_intro', array(
		'label'       => __( '📝 1. Manifesto & Testo Introduttivo', 'cinephile' ),
		'section'     => 'cec_about_section',
		'settings'    => array(),
	) ) );

	$wp_customize->add_setting( 'about_hero_kicker', array(
		'default'           => $defaults['about_hero_kicker'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'about_hero_kicker', array(
		'label'       => __( 'Kicker Superiore Manifesto', 'cinephile' ),
		'description' => __( 'Piccola etichetta in maiuscolo sopra il testo del manifesto.', 'cinephile' ),
		'section'     => 'cec_about_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'about_hero_intro', array(
		'default'           => $defaults['about_hero_intro'],
		'sanitize_callback' => 'cinephile_sanitize_rich_text',
	) );
	$wp_customize->add_control( 'about_hero_intro', array(
		'label'       => __( 'Testo Introduttivo del Manifesto', 'cinephile' ),
		'description' => __( 'Presentazione della linea editoriale e dei valori del progetto.', 'cinephile' ),
		'section'     => 'cec_about_section',
		'type'        => 'textarea',
	) );

	// 2. Banner Immagine Chi Siamo
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_about_banner', array(
		'label'       => __( '🖼️ 2. Banner Panoramico di Copertina', 'cinephile' ),
		'section'     => 'cec_about_section',
		'settings'    => array(),
	) ) );

	$wp_customize->add_setting( 'about_cover_image', array(
		'default'           => $defaults['about_cover_image'],
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'about_cover_image', array(
		'label'       => __( 'Banner Fotografico Panoramico', 'cinephile' ),
		'description' => __( 'Immagine panoramica di copertina per la pagina Chi Siamo (consigliata: 1200×350 px).', 'cinephile' ),
		'section'     => 'cec_about_section',
	) ) );

	// Scelte icone vettoriali per i 3 Pilastri
	$pillar_icon_choices = array(
		'compass'      => __( '🧭 Bussola / Rosa dei venti (Indipendenza)', 'cinephile' ),
		'film'         => __( '🎞️ Pellicola cinematografica (Cinema / Festival)', 'cinephile' ),
		'book'         => __( '📖 Libro (Saggi / Approfondimenti)', 'cinephile' ),
		'clapperboard' => __( '🎬 Ciak cinematografico (Regia / Settima Arte)', 'cinephile' ),
		'camera'       => __( '🎥 Cinepresa (Autori / Visione)', 'cinephile' ),
		'award'        => __( '🏆 Trofeo / Premio (Festival / Riconoscimenti)', 'cinephile' ),
		'star'         => __( '⭐ Stella (Critica d\'Autore / Eccellenza)', 'cinephile' ),
		'eye'          => __( '👁️ Occhio (Sguardo Critico / Analisi Visiva)', 'cinephile' ),
		'feather'      => __( '✒️ Penna d\'oca (Scrittura / Recensioni)', 'cinephile' ),
		'ticket'       => __( '🎟️ Biglietto (Sala Cinematografica)', 'cinephile' ),
		'projector'    => __( '📽️ Proiettore (Storia e Memoria del Cinema)', 'cinephile' ),
		'flame'        => __( '🔥 Fiamma (Passione Cinefila)', 'cinephile' ),
		'heart'        => __( '❤️ Cuore (Amore per la Settima Arte)', 'cinephile' ),
		'sparkles'     => __( '✨ Scintille (Magia del Cinema)', 'cinephile' ),
		'custom'       => __( '📁 Icona Personalizzata (Usa il campo sotto)', 'cinephile' ),
	);

	// 3. Pilastro 1
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_about_p1', array(
		'label'       => __( '🧭 3. Primo Pilastro (Valore 1)', 'cinephile' ),
		'description' => __( 'Configura il primo box valori della griglia (es. Indipendenza Critica).', 'cinephile' ),
		'section'     => 'cec_about_section',
		'settings'    => array(),
	) ) );

	$wp_customize->add_setting( 'about_pillar1_title', array(
		'default'           => $defaults['about_pillar1_title'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'about_pillar1_title', array(
		'label'       => __( 'Pilastro 1: Titolo', 'cinephile' ),
		'description' => __( 'Titolo della prima scheda concettuale (es. "Indipendenza").', 'cinephile' ),
		'section'     => 'cec_about_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'about_pillar1_desc', array(
		'default'           => $defaults['about_pillar1_desc'],
		'sanitize_callback' => 'cinephile_sanitize_rich_text',
	) );
	$wp_customize->add_control( 'about_pillar1_desc', array(
		'label'       => __( 'Pilastro 1: Descrizione', 'cinephile' ),
		'description' => __( 'Sintesi del primo valore editoriale.', 'cinephile' ),
		'section'     => 'cec_about_section',
		'type'        => 'textarea',
	) );

	$wp_customize->add_setting( 'about_pillar1_icon', array(
		'default'           => $defaults['about_pillar1_icon'],
		'sanitize_callback' => 'cinephile_sanitize_select',
	) );
	$wp_customize->add_control( 'about_pillar1_icon', array(
		'label'       => __( 'Pilastro 1: Icona del Box', 'cinephile' ),
		'description' => __( 'Seleziona un\'icona inclusa, oppure scegli "📁 Icona Personalizzata" per caricarne una tua.', 'cinephile' ),
		'section'     => 'cec_about_section',
		'type'        => 'select',
		'choices'     => $pillar_icon_choices,
	) );

	$wp_customize->add_setting( 'about_pillar1_custom_icon', array(
		'default'           => $defaults['about_pillar1_custom_icon'],
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'about_pillar1_custom_icon', array(
		'label'       => __( 'Pilastro 1: Carica Icona Personalizzata (Opzionale)', 'cinephile' ),
		'description' => __( 'Opzionale: carica un\'icona o immagine personalizzata. Formato consigliato: SVG (vettoriale) oppure PNG / WebP con sfondo trasparente. Dimensioni consigliate: 64×64 px quadrata (minimo 28×28 px, max 128×128 px). Se caricata, sostituisce l\'icona selezionata.', 'cinephile' ),
		'section'     => 'cec_about_section',
	) ) );

	// 4. Pilastro 2
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_about_p2', array(
		'label'       => __( '🎞️ 4. Secondo Pilastro (Valore 2)', 'cinephile' ),
		'description' => __( 'Configura il secondo box valori della griglia (es. Festival & Rassegne).', 'cinephile' ),
		'section'     => 'cec_about_section',
		'settings'    => array(),
	) ) );

	$wp_customize->add_setting( 'about_pillar2_title', array(
		'default'           => $defaults['about_pillar2_title'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'about_pillar2_title', array(
		'label'       => __( 'Pilastro 2: Titolo', 'cinephile' ),
		'description' => __( 'Titolo della seconda scheda (es. "Copertura Festival").', 'cinephile' ),
		'section'     => 'cec_about_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'about_pillar2_desc', array(
		'default'           => $defaults['about_pillar2_desc'],
		'sanitize_callback' => 'cinephile_sanitize_rich_text',
	) );
	$wp_customize->add_control( 'about_pillar2_desc', array(
		'label'       => __( 'Pilastro 2: Descrizione', 'cinephile' ),
		'description' => __( 'Sintesi del secondo valore.', 'cinephile' ),
		'section'     => 'cec_about_section',
		'type'        => 'textarea',
	) );

	$wp_customize->add_setting( 'about_pillar2_icon', array(
		'default'           => $defaults['about_pillar2_icon'],
		'sanitize_callback' => 'cinephile_sanitize_select',
	) );
	$wp_customize->add_control( 'about_pillar2_icon', array(
		'label'       => __( 'Pilastro 2: Icona del Box', 'cinephile' ),
		'description' => __( 'Seleziona un\'icona inclusa, oppure scegli "📁 Icona Personalizzata" per caricarne una tua.', 'cinephile' ),
		'section'     => 'cec_about_section',
		'type'        => 'select',
		'choices'     => $pillar_icon_choices,
	) );

	$wp_customize->add_setting( 'about_pillar2_custom_icon', array(
		'default'           => $defaults['about_pillar2_custom_icon'],
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'about_pillar2_custom_icon', array(
		'label'       => __( 'Pilastro 2: Carica Icona Personalizzata (Opzionale)', 'cinephile' ),
		'description' => __( 'Opzionale: carica un\'icona o immagine personalizzata. Formato consigliato: SVG (vettoriale) oppure PNG / WebP con sfondo trasparente. Dimensioni consigliate: 64×64 px quadrata (minimo 28×28 px, max 128×128 px). Se caricata, sostituisce l\'icona selezionata.', 'cinephile' ),
		'section'     => 'cec_about_section',
	) ) );

	// 5. Pilastro 3
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_about_p3', array(
		'label'       => __( '📖 5. Terzo Pilastro (Valore 3)', 'cinephile' ),
		'description' => __( 'Configura il terzo box valori della griglia (es. Saggi & Approfondimenti).', 'cinephile' ),
		'section'     => 'cec_about_section',
		'settings'    => array(),
	) ) );

	$wp_customize->add_setting( 'about_pillar3_title', array(
		'default'           => $defaults['about_pillar3_title'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'about_pillar3_title', array(
		'label'       => __( 'Pilastro 3: Titolo', 'cinephile' ),
		'description' => __( 'Titolo della terza scheda (es. "Approfondimento").', 'cinephile' ),
		'section'     => 'cec_about_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'about_pillar3_desc', array(
		'default'           => $defaults['about_pillar3_desc'],
		'sanitize_callback' => 'cinephile_sanitize_rich_text',
	) );
	$wp_customize->add_control( 'about_pillar3_desc', array(
		'label'       => __( 'Pilastro 3: Descrizione', 'cinephile' ),
		'description' => __( 'Sintesi del terzo valore.', 'cinephile' ),
		'section'     => 'cec_about_section',
		'type'        => 'textarea',
	) );

	$wp_customize->add_setting( 'about_pillar3_icon', array(
		'default'           => $defaults['about_pillar3_icon'],
		'sanitize_callback' => 'cinephile_sanitize_select',
	) );
	$wp_customize->add_control( 'about_pillar3_icon', array(
		'label'       => __( 'Pilastro 3: Icona del Box', 'cinephile' ),
		'description' => __( 'Seleziona un\'icona inclusa, oppure scegli "📁 Icona Personalizzata" per caricarne una tua.', 'cinephile' ),
		'section'     => 'cec_about_section',
		'type'        => 'select',
		'choices'     => $pillar_icon_choices,
	) );

	$wp_customize->add_setting( 'about_pillar3_custom_icon', array(
		'default'           => $defaults['about_pillar3_custom_icon'],
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'about_pillar3_custom_icon', array(
		'label'       => __( 'Pilastro 3: Carica Icona Personalizzata (Opzionale)', 'cinephile' ),
		'description' => __( 'Opzionale: carica un\'icona o immagine personalizzata. Formato consigliato: SVG (vettoriale) oppure PNG / WebP con sfondo trasparente. Dimensioni consigliate: 64×64 px quadrata (minimo 28×28 px, max 128×128 px). Se caricata, sostituisce l\'icona selezionata.', 'cinephile' ),
		'section'     => 'cec_about_section',
	) ) );

	// 6. Scheda Autore (Singolo)
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_about_author', array(
		'label'       => __( '👤 6. Profilo Fondatore / Autore', 'cinephile' ),
		'description' => __( 'Dati del curatore visualizzati nella scheda autore a fondo pagina.', 'cinephile' ),
		'section'     => 'cec_about_section',
		'settings'    => array(),
	) ) );
	$author_settings = array(
		'about_author_name' => array( 'label' => __( 'Nome Fondatore / Autore', 'cinephile' ), 'desc' => __( 'Nome e cognome visualizzati nella scheda autore.', 'cinephile' ), 'type' => 'text', 'san' => 'sanitize_text_field' ),
		'about_author_role' => array( 'label' => __( 'Ruolo Professionale', 'cinephile' ), 'desc' => __( 'Es. "Fondatore & Direttore Editoriale" o "Critico Cinematografico".', 'cinephile' ), 'type' => 'text', 'san' => 'sanitize_text_field' ),
		'about_author_bio'  => array( 'label' => __( 'Biografia dell\'Autore', 'cinephile' ), 'desc' => __( 'Breve presentazione del percorso o degli interessi.', 'cinephile' ), 'type' => 'textarea', 'san' => 'cinephile_sanitize_rich_text' ),
	);

	foreach ( $author_settings as $id => $data ) {
		$wp_customize->add_setting( $id, array(
			'default'           => isset( $defaults[ $id ] ) ? $defaults[ $id ] : '',
			'sanitize_callback' => $data['san'],
		) );
		$wp_customize->add_control( $id, array(
			'label'       => $data['label'],
			'description' => $data['desc'],
			'section'     => 'cec_about_section',
			'type'        => $data['type'],
		) );
	}

	// Avatar Autore Singolo
	$wp_customize->add_setting( 'about_author_avatar', array(
		'default'           => $defaults['about_author_avatar'],
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'about_author_avatar', array(
		'label'       => __( 'Foto Profilo dell\'Autore', 'cinephile' ),
		'description' => __( 'Foto quadrata visualizzata nella scheda autore se il sito ha un solo redattore registrato.', 'cinephile' ),
		'section'     => 'cec_about_section',
	) ) );

	/* --------------------------------------------------------------------------
	   SEZIONE 7: TESTI DELLE PAGINE & ARCHIVI
	   Priorità: 45
	   -------------------------------------------------------------------------- */
	$wp_customize->add_section( 'cec_template_content_section', array(
		'title'       => __( '7. Testi delle Pagine & Archivi', 'cinephile' ),
		'priority'    => 45,
		'description' => __( 'Personalizza i titoli delle sezioni della Home page, le intestazioni degli archivi, i pulsanti di lettura e la schermata di errore 404.', 'cinephile' ),
	) );

	// 1. Home
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_tmpl_home', array(
		'label'    => __( '🏠 Titoli & Testi della Home Page', 'cinephile' ),
		'section'  => 'cec_template_content_section',
		'settings' => array(),
	) ) );

	$wp_customize->add_setting( 'home_section_focus_title', array(
		'default'           => $defaults['home_section_focus_title'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'home_section_focus_title', array(
		'label'       => __( 'Titolo Sezione "In Evidenza" (Home)', 'cinephile' ),
		'description' => __( 'Titolo sopra la griglia degli articoli speciali in evidenza nella Home.', 'cinephile' ),
		'section'     => 'cec_template_content_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'home_section_archive_title', array(
		'default'           => $defaults['home_section_archive_title'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'home_section_archive_title', array(
		'label'       => __( 'Titolo Sezione "Ultime Recensioni" (Home)', 'cinephile' ),
		'description' => __( 'Titolo sopra la griglia delle recensioni recenti in Home.', 'cinephile' ),
		'section'     => 'cec_template_content_section',
		'type'        => 'text',
	) );

	// 2. Archivi & Ricerca
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_tmpl_archives', array(
		'label'    => __( '📂 Archivi, Ricerca & Categorie', 'cinephile' ),
		'section'  => 'cec_template_content_section',
		'settings' => array(),
	) ) );

	$wp_customize->add_setting( 'archive_main_title', array(
		'default'           => $defaults['archive_main_title'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'archive_main_title', array(
		'label'       => __( 'Titolo Principale della Pagina Archivio', 'cinephile' ),
		'description' => __( 'Intestazione principale nelle pagine archivio e categorie.', 'cinephile' ),
		'section'     => 'cec_template_content_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'archive_read_more_text', array(
		'default'           => $defaults['archive_read_more_text'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'archive_read_more_text', array(
		'label'       => __( 'Testo del Link "Leggi l\'articolo"', 'cinephile' ),
		'description' => __( 'Etichetta del pulsante che porta alla lettura del singolo articolo.', 'cinephile' ),
		'section'     => 'cec_template_content_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'tag_hero_kicker', array(
		'default'           => $defaults['tag_hero_kicker'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'tag_hero_kicker', array(
		'label'       => __( 'Kicker Superiore Pagina Tag', 'cinephile' ),
		'description' => __( 'Piccola etichetta mostrata sopra il nome del tag selezionato.', 'cinephile' ),
		'section'     => 'cec_template_content_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'search_hero_kicker', array(
		'default'           => $defaults['search_hero_kicker'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'search_hero_kicker', array(
		'label'       => __( 'Kicker Superiore Pagina Ricerca', 'cinephile' ),
		'description' => __( 'Etichetta visualizzata sopra i risultati di ricerca.', 'cinephile' ),
		'section'     => 'cec_template_content_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'search_no_results_badge', array(
		'default'           => $defaults['search_no_results_badge'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'search_no_results_badge', array(
		'label'       => __( 'Badge "Nessun Risultato Trovato"', 'cinephile' ),
		'description' => __( 'Avviso mostrato quando una ricerca non produce risultati.', 'cinephile' ),
		'section'     => 'cec_template_content_section',
		'type'        => 'text',
	) );

	// 3. Pagina Errore 404
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_tmpl_404', array(
		'label'    => __( '🚫 Schermata di Errore 404', 'cinephile' ),
		'section'  => 'cec_template_content_section',
		'settings' => array(),
	) ) );

	$wp_customize->add_setting( 'error_404_kicker', array(
		'default'           => $defaults['error_404_kicker'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'error_404_kicker', array(
		'label'       => __( 'Kicker Pagina Errore 404', 'cinephile' ),
		'description' => __( 'Intestazione della pagina mostrata quando un link non esiste.', 'cinephile' ),
		'section'     => 'cec_template_content_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'error_404_button_label', array(
		'default'           => $defaults['error_404_button_label'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'error_404_button_label', array(
		'label'       => __( 'Etichetta Pulsante Pagina 404', 'cinephile' ),
		'description' => __( 'Testo del bottone che consente di tornare alla pagina iniziale.', 'cinephile' ),
		'section'     => 'cec_template_content_section',
		'type'        => 'text',
	) );

	// 4. Immagini & Miniature
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_tmpl_images', array(
		'label'    => __( '🖼️ Gestione Foto & Miniature Articoli', 'cinephile' ),
		'section'  => 'cec_template_content_section',
		'settings' => array(),
	) ) );

	// Immagine di fallback per articoli privi di thumbnail
	$wp_customize->add_setting( 'default_fallback_image', array(
		'default'           => $defaults['default_fallback_image'],
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'default_fallback_image', array(
		'label'       => __( 'Copertina di Riserva (Placeholder)', 'cinephile' ),
		'description' => __( 'Immagine automatica mostrata per gli articoli che non hanno una foto in evidenza assegnata.', 'cinephile' ),
		'section'     => 'cec_template_content_section',
	) ) );

	// Toggle Immagini in Evidenza
	$wp_customize->add_setting( 'single_show_featured_image', array(
		'default'           => $defaults['single_show_featured_image'],
		'sanitize_callback' => 'wp_validate_boolean',
	) );
	$wp_customize->add_control( 'single_show_featured_image', array(
		'label'       => __( 'Mostra Foto in Evidenza dentro l\'Articolo', 'cinephile' ),
		'description' => __( 'Se disattivato, la foto in evidenza compare solo nelle griglie esterne e non all\'inizio dell\'articolo singolo.', 'cinephile' ),
		'section'     => 'cec_template_content_section',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'show_featured_images', array(
		'default'           => $defaults['show_featured_images'],
		'sanitize_callback' => 'wp_validate_boolean',
	) );
	$wp_customize->add_control( 'show_featured_images', array(
		'label'       => __( 'Mostra Miniature nelle Griglie Archivio', 'cinephile' ),
		'description' => __( 'Se disattivato, mostra le griglie degli articoli solo con titoli e testi in stile minimale.', 'cinephile' ),
		'section'     => 'cec_template_content_section',
		'type'        => 'checkbox',
	) );

	// 5. Scheda Profilo Autore & Archivi Personali
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_tmpl_author', array(
		'label'    => __( '👤 Scheda Autore & Profilo Critico', 'cinephile' ),
		'section'  => 'cec_template_content_section',
		'settings' => array(),
	) ) );

	$wp_customize->add_setting( 'enable_author_archive_links', array(
		'default'           => $defaults['enable_author_archive_links'],
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'enable_author_archive_links', array(
		'label'       => __( 'Abilita Pagina Profilo Autore & Link nella Firma', 'cinephile' ),
		'description' => __( 'Se disattivato (consigliato per siti mono-autore o all\'avvio), la firma a fondo articolo rimane un badge grafico statico e i link sono disattivati. Se attivato, cliccando sull\'autore si apre la sua pagina biografica con tutte le sue recensioni.', 'cinephile' ),
		'section'     => 'cec_template_content_section',
		'type'        => 'checkbox',
	) );

	/* --------------------------------------------------------------------------
	   SEZIONE 8: SOCIAL NETWORK & PIÈ DI PAGINA (FOOTER)
	   Priorità: 50
	   -------------------------------------------------------------------------- */
	$wp_customize->add_section( 'cec_footer_advanced_section', array(
		'title'       => __( '8. Social Network & Piè di Pagina (Footer)', 'cinephile' ),
		'priority'    => 50,
		'description' => __( 'Collega i tuoi profili social, imposta il testo del copyright e i crediti a piè di pagina, scegli la scenografia Polaroid o ripristina il tema.', 'cinephile' ),
	) );

	// Social Links
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_footer_social', array(
		'label'    => __( '🌐 Canali & Profili Social Network', 'cinephile' ),
		'section'  => 'cec_footer_advanced_section',
		'settings' => array(),
	) ) );

	$socials = array(
		'social_letterboxd' => array( 'label' => __( 'Profilo Letterboxd', 'cinephile' ), 'desc' => __( 'Inserisci l\'URL completo al tuo profilo cinefilo su Letterboxd.', 'cinephile' ) ),
		'social_instagram'  => array( 'label' => __( 'Profilo Instagram', 'cinephile' ), 'desc' => __( 'URL completo della tua pagina o account Instagram.', 'cinephile' ) ),
		'social_youtube'    => array( 'label' => __( 'Canale YouTube', 'cinephile' ), 'desc' => __( 'URL completo al tuo canale YouTube.', 'cinephile' ) ),
		'social_x'          => array( 'label' => __( 'Profilo X (ex Twitter)', 'cinephile' ), 'desc' => __( 'URL completo del tuo profilo su X / Twitter.', 'cinephile' ) ),
	);

	foreach ( $socials as $id => $data ) {
		$wp_customize->add_setting( $id, array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( $id, array(
			'label'       => $data['label'],
			'description' => $data['desc'],
			'section'     => 'cec_footer_advanced_section',
			'type'        => 'url',
		) );
	}

	// Copyright & Credits Footer
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_footer_credits', array(
		'label'    => __( '📄 Testi di Copyright & Crediti a Piè di Pagina', 'cinephile' ),
		'section'  => 'cec_footer_advanced_section',
		'settings' => array(),
	) ) );

	$wp_customize->add_setting( 'footer_copyright_text', array(
		'default'           => $defaults['footer_copyright_text'],
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'footer_copyright_text', array(
		'label'       => __( 'Testo Copyright nel Footer', 'cinephile' ),
		'description' => __( 'Dicitura legale mostrata in fondo a ogni pagina (es. "© 2026 Nome Sito. Tutti i diritti riservati.").', 'cinephile' ),
		'section'     => 'cec_footer_advanced_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'footer_credits_text', array(
		'default'           => $defaults['footer_credits_text'],
		'sanitize_callback' => 'cinephile_sanitize_rich_text',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'footer_credits_text', array(
		'label'       => __( 'Motto / Crediti nel Footer', 'cinephile' ),
		'description' => __( 'Breve frase o menzione mostrata sotto la linea di copyright.', 'cinephile' ),
		'section'     => 'cec_footer_advanced_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'footer_show_credits', array(
		'default'           => $defaults['footer_show_credits'],
		'sanitize_callback' => 'wp_validate_boolean',
	) );
	$wp_customize->add_control( 'footer_show_credits', array(
		'label'       => __( 'Mostra Crediti nel Footer', 'cinephile' ),
		'description' => __( 'Spunta per attivare o nascondere la riga dei crediti a fondo pagina.', 'cinephile' ),
		'section'     => 'cec_footer_advanced_section',
		'type'        => 'checkbox',
	) );

	// Scenografia Galleria Cinema
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_footer_gallery', array(
		'label'       => __( '🎞️ Scenografia Cinematografica Galleria', 'cinephile' ),
		'description' => __( 'Effetti tattili con pellicole 35mm, ciak e rullini sul tavolo da lavoro.', 'cinephile' ),
		'section'     => 'cec_footer_advanced_section',
		'settings'    => array(),
	) ) );

	$wp_customize->add_setting( 'gallery_props_preset', array(
		'default'           => $defaults['gallery_props_preset'],
		'sanitize_callback' => 'cinephile_sanitize_select',
	) );
	$wp_customize->add_control( 'gallery_props_preset', array(
		'label'       => __( 'Scenografia Cinematografica della Galleria', 'cinephile' ),
		'description' => __( 'Scenografia tattile del tavolo da lavoro: pellicole e guide corrono sotto le foto, mentre oggetti autentici (pizze, rullini, ciak, forbici, lenti) poggiano sopra come fermacarte.', 'cinephile' ),
		'section'     => 'cec_footer_advanced_section',
		'type'        => 'select',
		'choices'     => array(
			'classico_master' => __( '🎞️ Classico Master (Pellicole + Pizze + Rullini)', 'cinephile' ),
			'classico_v1'     => __( '🎞️ Classico Var 1 (Solo Pellicole 35mm)', 'cinephile' ),
			'classico_v2'     => __( '🎞️ Classico Var 2 (Pizze & Rullini Vintage)', 'cinephile' ),
			'classico_v3'     => __( '🎞️ Classico Var 3 (Pellicola Essenziale)', 'cinephile' ),
			'regia_master'    => __( '📣 Regia Master (Sedia XL + Megafono + Ciak + Proiettore)', 'cinephile' ),
			'regia_v1'        => __( '📣 Regia Var 1 (Sedia XL & Megafono XL)', 'cinephile' ),
			'regia_v2'        => __( '📣 Regia Var 2 (Ciak & Taccuino)', 'cinephile' ),
			'regia_v3'        => __( '📣 Regia Var 3 (Audio Boom & Ciak)', 'cinephile' ),
			'moviola_master'  => __( '✂️ Moviola Master (Guide + Forbici XL + Lente XL + Fotogrammi)', 'cinephile' ),
			'moviola_v1'      => __( '✂️ Moviola Var 1 (Forbici XL & Nastro)', 'cinephile' ),
			'moviola_v2'      => __( '✂️ Moviola Var 2 (Lente XL & Timecode)', 'cinephile' ),
			'moviola_v3'      => __( '✂️ Moviola Var 3 (Taglio & Giunta Precisione)', 'cinephile' ),
			'none'            => __( '🚫 Nessuna Scenografia (Solo Foto Polaroid Semplice)', 'cinephile' ),
		),
	) );

	$wp_customize->add_setting( 'gallery_random_rot', array(
		'default'           => $defaults['gallery_random_rot'],
		'sanitize_callback' => 'wp_validate_boolean',
	) );
	$wp_customize->add_control( 'gallery_random_rot', array(
		'label'       => __( 'Effetto Inclinazione Polaroid Casuale', 'cinephile' ),
		'description' => __( 'Applica una leggera rotazione vintage variabile alle foto quando vengono aperte nella galleria.', 'cinephile' ),
		'section'     => 'cec_footer_advanced_section',
		'type'        => 'checkbox',
	) );

	// Reset Impostazioni Iniziali
	$wp_customize->add_control( new Cinephile_Customizer_Header_Control( $wp_customize, 'cec_head_footer_reset', array(
		'label'       => __( '⚠️ Manutenzione & Ripristino di Fabbrica', 'cinephile' ),
		'section'     => 'cec_footer_advanced_section',
		'settings'    => array(),
	) ) );

	$wp_customize->add_setting( 'customizer_reset_all', array(
		'default'           => false,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'customizer_reset_all', array(
		'label'       => __( '⚠️ Ripristina Valori di Fabbrica del Tema', 'cinephile' ),
		'description' => __( 'Spunta questa casella e fai clic su "Pubblica" solo se desideri cancellare tutte le personalizzazioni e ripristinare le impostazioni predefinite originali.', 'cinephile' ),
		'section'     => 'cec_footer_advanced_section',
		'type'        => 'checkbox',
	) );
}
add_action( 'customize_register', 'cinephile_customize_register', 99 );

/**
 * Registra lo script JavaScript per l'anteprima in tempo reale (postMessage).
 */
function cinephile_customizer_preview_js() {
	wp_enqueue_script(
		'cinephile-customizer-preview',
		get_template_directory_uri() . '/assets/js/customizer-preview.js',
		array( 'jquery', 'customize-preview' ),
		'1.1.0',
		true
	);
}
add_action( 'customize_preview_init', 'cinephile_customizer_preview_js' );

/**
 * Sincronizza il nome e il motto del brand con le opzioni native di WordPress (blogname/blogdescription).
 */
function cinephile_handle_customizer_sync() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	$brand_name = get_theme_mod( 'brand_name' );
	if ( ! empty( $brand_name ) ) {
		update_option( 'blogname', $brand_name );
	}
	$brand_tagline = get_theme_mod( 'brand_tagline' );
	if ( ! empty( $brand_tagline ) ) {
		update_option( 'blogdescription', $brand_tagline );
	}
}
add_action( 'customize_save_after', 'cinephile_handle_customizer_sync' );

/**
 * Stili CSS dedicati per la barra laterale del Customizer (Pannello Controlli).
 * Migliora la UX, distanzia i controlli, evidenzia le categorie e crea blocchi visivi coerenti.
 */
function cinephile_customizer_controls_styles() {
	?>
	<style type="text/css">
		/* Contenitore interno dei controlli: aria e respiro */
		#customize-theme-controls .accordion-section-content {
			padding: 18px 16px 32px !important;
		}

		/* Spaziatura più ariosa per ogni singolo controllo */
		#customize-theme-controls .customize-control {
			margin-bottom: 22px !important;
		}

		/* Titoli dei controlli più definiti, scuri e nitidi */
		#customize-theme-controls .customize-control-title {
			font-size: 12.5px !important;
			font-weight: 700 !important;
			color: #1e293b !important;
			margin-bottom: 6px !important;
			line-height: 1.35 !important;
			letter-spacing: -0.01em !important;
		}

		/* Descrizioni dei controlli più leggibili */
		#customize-theme-controls .customize-control-description {
			font-size: 11.5px !important;
			line-height: 1.5 !important;
			color: #64748b !important;
			margin-bottom: 9px !important;
			font-style: normal !important;
		}

		/* Campi input, select e textarea più moderni, morbidi e curati */
		#customize-theme-controls input[type="text"],
		#customize-theme-controls input[type="email"],
		#customize-theme-controls input[type="url"],
		#customize-theme-controls select,
		#customize-theme-controls textarea {
			border-radius: 6px !important;
			border: 1px solid #cbd5e1 !important;
			padding: 8px 10px !important;
			font-size: 12.5px !important;
			background-color: #ffffff !important;
			transition: border-color 0.15s ease, box-shadow 0.15s ease !important;
		}

		#customize-theme-controls input[type="text"]:focus,
		#customize-theme-controls input[type="email"]:focus,
		#customize-theme-controls input[type="url"]:focus,
		#customize-theme-controls select:focus,
		#customize-theme-controls textarea:focus {
			border-color: #d4af37 !important;
			box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.22) !important;
			outline: none !important;
		}

		/* Header e Badge divisori di gruppo */
		li.customize-control-cec_header {
			margin-top: 26px !important;
			margin-bottom: 14px !important;
			padding-top: 14px !important;
			border-top: 1px solid #e2e8f0 !important;
		}

		li.customize-control-cec_header:first-child {
			margin-top: 0 !important;
			padding-top: 0 !important;
			border-top: none !important;
		}

		.cec-customizer-header-badge {
			background: linear-gradient(135deg, #181c24 0%, #252c38 100%);
			color: #e5b95f;
			padding: 9px 12px;
			border-radius: 6px;
			border-left: 4px solid #c59b27;
			font-size: 11px;
			font-weight: 700;
			letter-spacing: 0.06em;
			text-transform: uppercase;
			display: flex;
			align-items: center;
			box-shadow: 0 2px 5px rgba(0,0,0,0.06);
		}

		.cec-header-desc {
			color: #64748b !important;
			font-size: 11.5px !important;
			line-height: 1.4 !important;
			margin-top: 6px !important;
			margin-bottom: 0 !important;
			padding-left: 4px;
		}

		/* Evidenziazione visiva e raggruppamento per i controlli speciali */
		[id*="custom_icon"],
		[id*="custom_title_file"],
		[id*="custom_title_name"],
		[id*="custom_body_file"],
		[id*="custom_body_name"] {
			background: #f8fafc !important;
			border: 1px solid #e2e8f0 !important;
			border-radius: 8px !important;
			padding: 12px 14px !important;
		}
	</style>
	<?php
}
add_action( 'customize_controls_print_styles', 'cinephile_customizer_controls_styles' );

/* ==========================================================================
   4. INIEZIONE DINAMICA DELLE VARIABILI CSS (:root)
   ========================================================================== */

/**
 * Inietta le variabili CSS personalizzate tramite wp_add_inline_style.
 * Conforme con Content Security Policy (CSP) senza tag <style> diretti nell'HTML.
 */
function cinephile_customizer_css_inline() {
	$defaults     = cinephile_get_customizer_defaults();
	$accent       = sanitize_hex_color( get_theme_mod( 'theme_color_accent', $defaults['theme_color_accent'] ) );
	$bg_canvas    = sanitize_hex_color( get_theme_mod( 'theme_bg_canvas', $defaults['theme_bg_canvas'] ) );
	$text_main    = sanitize_hex_color( get_theme_mod( 'theme_text_main', $defaults['theme_text_main'] ) );
	$bg_card      = sanitize_hex_color( get_theme_mod( 'theme_bg_card', $defaults['theme_bg_card'] ) );
	$text_muted   = sanitize_hex_color( get_theme_mod( 'theme_text_muted', $defaults['theme_text_muted'] ) );
	$border_line  = sanitize_hex_color( get_theme_mod( 'theme_border_line', $defaults['theme_border_line'] ) );

	$font_stacks = array(
		'playfair'     => '"Playfair Display", Georgia, serif',
		'cinzel'       => '"Cinzel", Georgia, serif',
		'lora'         => '"Lora", Georgia, serif',
		'plus_jakarta' => '"Plus Jakarta Sans", -apple-system, BlinkMacSystemFont, sans-serif',
		'inter'        => '"Inter", -apple-system, BlinkMacSystemFont, sans-serif',
		'outfit'       => '"Outfit", -apple-system, BlinkMacSystemFont, sans-serif',
		'system_serif' => 'Georgia, "Times New Roman", serif',
		'system_sans'  => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
	);

	$font_title_key         = get_theme_mod( 'font_family_title', $defaults['font_family_title'] );
	$font_custom_title_file = esc_url_raw( get_theme_mod( 'font_custom_title_file', $defaults['font_custom_title_file'] ) );
	$font_custom_title_name = sanitize_text_field( get_theme_mod( 'font_custom_title_name', $defaults['font_custom_title_name'] ) );

	$font_body_key          = get_theme_mod( 'font_family_body', $defaults['font_family_body'] );
	$font_custom_body_file  = esc_url_raw( get_theme_mod( 'font_custom_body_file', $defaults['font_custom_body_file'] ) );
	$font_custom_body_name  = sanitize_text_field( get_theme_mod( 'font_custom_body_name', $defaults['font_custom_body_name'] ) );

	$custom_font_faces = '';

	// Elaborazione Font Titoli (--font-title)
	if ( 'custom' === $font_title_key && ! empty( $font_custom_title_file ) ) {
		$clean_name  = preg_replace( '/[^a-zA-Z0-9_\-\s]/', '', $font_custom_title_name );
		$family_name = ! empty( trim( $clean_name ) ) ? trim( $clean_name ) : 'CustomTitleFont';
		$path        = wp_parse_url( $font_custom_title_file, PHP_URL_PATH );
		$ext         = strtolower( pathinfo( (string) $path, PATHINFO_EXTENSION ) );
		$format      = ( 'woff' === $ext ) ? 'woff' : ( ( 'ttf' === $ext ) ? 'truetype' : 'woff2' );

		$custom_font_faces .= sprintf(
			"@font-face{font-family:'%s';src:url('%s') format('%s');font-display:swap;font-weight:100 900;font-style:normal;}\n",
			esc_attr( $family_name ),
			esc_url( $font_custom_title_file ),
			esc_attr( $format )
		);
		$font_title = sprintf( "'%s', Georgia, serif", esc_attr( $family_name ) );
	} elseif ( isset( $font_stacks[ $font_title_key ] ) ) {
		$font_title = $font_stacks[ $font_title_key ];
	} else {
		// Fallback retrocompatibilità preset legacy
		$legacy_preset = get_theme_mod( 'theme_typography_preset', 'editorial' );
		$font_title    = ( 'modern' === $legacy_preset ) ? $font_stacks['inter'] : ( ( 'system' === $legacy_preset ) ? $font_stacks['system_sans'] : $font_stacks['playfair'] );
	}

	// Elaborazione Font Corpo / Contesto (--font-body)
	if ( 'custom' === $font_body_key && ! empty( $font_custom_body_file ) ) {
		$clean_name  = preg_replace( '/[^a-zA-Z0-9_\-\s]/', '', $font_custom_body_name );
		$family_name = ! empty( trim( $clean_name ) ) ? trim( $clean_name ) : 'CustomBodyFont';
		$path        = wp_parse_url( $font_custom_body_file, PHP_URL_PATH );
		$ext         = strtolower( pathinfo( (string) $path, PATHINFO_EXTENSION ) );
		$format      = ( 'woff' === $ext ) ? 'woff' : ( ( 'ttf' === $ext ) ? 'truetype' : 'woff2' );

		$custom_font_faces .= sprintf(
			"@font-face{font-family:'%s';src:url('%s') format('%s');font-display:swap;font-weight:100 900;font-style:normal;}\n",
			esc_attr( $family_name ),
			esc_url( $font_custom_body_file ),
			esc_attr( $format )
		);
		$font_body = sprintf( "'%s', -apple-system, BlinkMacSystemFont, sans-serif", esc_attr( $family_name ) );
	} elseif ( isset( $font_stacks[ $font_body_key ] ) ) {
		$font_body = $font_stacks[ $font_body_key ];
	} else {
		// Fallback retrocompatibilità preset legacy
		$legacy_preset = get_theme_mod( 'theme_typography_preset', 'editorial' );
		$font_body     = ( 'modern' === $legacy_preset ) ? $font_stacks['inter'] : ( ( 'system' === $legacy_preset ) ? $font_stacks['system_sans'] : $font_stacks['plus_jakarta'] );
	}

	$custom_css = $custom_font_faces . sprintf(
		':root{--color-accent:%s;--bg-canvas:%s;--text-main:%s;--bg-card:%s;--text-muted:%s;--border-line:%s;--font-title:%s;--font-body:%s;}',
		$accent,
		$bg_canvas,
		$text_main,
		$bg_card,
		$text_muted,
		$border_line,
		$font_title,
		$font_body
	);

	wp_add_inline_style( 'cinephile-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'cinephile_customizer_css_inline', 99 );

/* ==========================================================================
   5. LOGICA DI RIPRISTINO VALORI DI FABBRICA (RESET)
   ========================================================================== */

/**
 * Se l'utente ha spuntato il checkbox customizer_reset_all, ripristina
 * tutte le impostazioni registrate nella mappa cinephile_get_customizer_defaults().
 */
function cinephile_handle_customizer_reset() {
	// Difesa in profondità: verifica che l'utente abbia effettivamente il ruolo di modifica tema
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	if ( get_theme_mod( 'customizer_reset_all' ) ) {
		$defaults = cinephile_get_customizer_defaults();
		foreach ( $defaults as $key => $default_value ) {
			if ( 'customizer_reset_all' !== $key ) {
				set_theme_mod( $key, $default_value );
			}
		}
		set_theme_mod( 'customizer_reset_all', false );
	}
}
add_action( 'customize_save_after', 'cinephile_handle_customizer_reset' );
