<?php
/**
 * Modulo Gestione Asset e Risorse Statiche (CSS, JS, Favicon)
 *
 * Registrazione ed enqueue controllato di stili, script Vanilla JS e favicon predefinita.
 * Conformità GDPR 100%: caricamento esclusivo di risorse locali (.woff2, .css, .js).
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

if ( ! function_exists( 'cinephile_scripts' ) ) :
	/**
	 * Registra e accoda i fogli di stile e gli script JavaScript sul frontend del tema.
	 *
	 * Include:
	 * 1. Font WOFF2 locali ad alte prestazioni (zero CDN terze)
	 * 2. style.css principale con Design System cinematografico
	 * 3. Script Vanilla JS per navigazione accessibile, sottomenu e skip-link
	 * 4. CSS e JS dedicati al lightbox e alle gallerie polaroid con configurazione unificata
	 */
	function cinephile_scripts() {
		$theme_version = wp_get_theme()->get( 'Version' );

		// 1. Font Locali (100% GDPR Native)
		wp_enqueue_style(
			'cinephile-local-fonts',
			get_template_directory_uri() . '/assets/fonts/local-fonts.css',
			array(),
			$theme_version
		);

		// 2. CSS Principale
		wp_enqueue_style(
			'cinephile-style',
			get_stylesheet_uri(),
			array( 'cinephile-local-fonts' ),
			$theme_version
		);

		// 3. Script Navigazione & Accessibilità
		wp_enqueue_script(
			'cinephile-navigation',
			get_template_directory_uri() . '/assets/js/navigation.js',
			array(),
			$theme_version,
			true
		);

		// 4. Script & Stili Lightbox Condizionali
		// Caricati con fallback alla versione del file (cache busting intelligente)
		$css_file = get_template_directory() . '/assets/css/lightbox.css';
		$js_file  = get_template_directory() . '/assets/js/lightbox.js';
		$css_ver  = file_exists( $css_file ) ? (string) filemtime( $css_file ) : $theme_version;
		$js_ver   = file_exists( $js_file ) ? (string) filemtime( $js_file ) : $theme_version;

		wp_enqueue_style(
			'cinephile-lightbox',
			get_template_directory_uri() . '/assets/css/lightbox.css',
			array( 'cinephile-style' ),
			$css_ver
		);

		wp_enqueue_script(
			'cinephile-lightbox',
			get_template_directory_uri() . '/assets/js/lightbox.js',
			array(),
			$js_ver,
			true
		);

		// Gestione centralizzata Unificata Customizer / Post Meta Override.
		// Priorità: override per post (post_meta) → fallback globale (theme_mod).
		$post_id         = get_queried_object_id();
		$preset_global   = function_exists( 'cinephile_sanitize_gallery_preset' ) ? cinephile_sanitize_gallery_preset( get_theme_mod( 'gallery_props_preset', 'classico_master' ) ) : 'classico_master';
		$preset_override = sanitize_key( get_post_meta( $post_id, '_cinephile_gallery_preset_override', true ) );
		if ( empty( $preset_override ) ) {
			$preset_override = sanitize_key( get_post_meta( $post_id, '_cinemaecritica_gallery_preset_override', true ) );
		}

		$allowed      = function_exists( 'cinephile_get_gallery_presets' ) ? cinephile_get_gallery_presets() : array( 'classico_master' );
		$final_preset = in_array( $preset_override, $allowed, true ) ? $preset_override : $preset_global;

		wp_localize_script(
			'cinephile-lightbox',
			'ccGalleryConfig',
			array(
				'preset'    => $final_preset,
				'randomRot' => (bool) get_theme_mod( 'gallery_random_rot', true ),
			)
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'cinephile_scripts' );

/**
 * Carica gli stili CSS personalizzati per l'area amministrativa di WordPress
 * (metabox cinematografici per film, gallerie e posizionamento).
 *
 * @param string $hook_suffix Identificativo della schermata amministrativa corrente.
 */
function cinephile_admin_scripts( $hook_suffix ) {
	if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php', 'edit.php' ), true ) ) {
		return;
	}

	$theme_version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style(
		'cinephile-admin',
		get_template_directory_uri() . '/assets/css/admin.css',
		array(),
		$theme_version
	);
}
add_action( 'admin_enqueue_scripts', 'cinephile_admin_scripts' );

/**
 * Inietta la Favicon predefinita del tema (emblema lente cinematografica dorata).
 * Viene iniettata su wp_head, admin_head e login_head solo se l'utente non ha impostato un'icona personalizzata.
 */
function cinephile_default_favicon() {
	if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
		$icon_32  = get_theme_file_uri( '/assets/img/favicon-32x32.png' );
		$icon_180 = get_theme_file_uri( '/assets/img/apple-touch-icon.png' );
		$icon_192 = get_theme_file_uri( '/assets/img/favicon-192x192.png' );
		$icon_ico = get_theme_file_uri( '/favicon.ico' );

		echo '<link rel="shortcut icon" href="' . esc_url( $icon_ico ) . '" />' . "\n";
		echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url( $icon_32 ) . '" />' . "\n";
		echo '<link rel="icon" type="image/png" sizes="192x192" href="' . esc_url( $icon_192 ) . '" />' . "\n";
		echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url( $icon_180 ) . '" />' . "\n";
	}
}
add_action( 'wp_head', 'cinephile_default_favicon', 2 );
add_action( 'admin_head', 'cinephile_default_favicon', 2 );
add_action( 'login_head', 'cinephile_default_favicon', 2 );
