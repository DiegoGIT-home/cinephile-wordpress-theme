<?php
/**
 * Setup del Tema e Caricamento Risorse Principali
 *
 * Registrazione supporti core di WordPress, menu di navigazione, fogli di stile e script frontend/admin.
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

if ( ! function_exists( 'cinephile_setup' ) ) :
	function cinephile_setup() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 300,
				'width'       => 1200,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'editor-styles' );
		add_editor_style( array( 'assets/fonts/local-fonts.css', 'assets/css/editor-style.css' ) );

		register_nav_menus(
			array(
				'main-menu'   => __( 'Menu Principale', 'cinephile' ),
				'footer-menu' => __( 'Menu Footer', 'cinephile' ),
			)
		);

		load_theme_textdomain( 'cinephile', get_template_directory() . '/languages' );
	}
endif;
add_action( 'after_setup_theme', 'cinephile_setup' );

/**
 * Abilita il caricamento sicuro di file font (.woff, .woff2, .ttf) nella Media Library
 * per gli utenti con privilegi di gestione del tema.
 */
function cinephile_mime_types( $mimes ) {
	if ( current_user_can( 'edit_theme_options' ) ) {
		$mimes['woff']  = 'font/woff';
		$mimes['woff2'] = 'font/woff2';
		$mimes['ttf']   = 'font/ttf';
	}
	return $mimes;
}
add_filter( 'upload_mimes', 'cinephile_mime_types' );

if ( ! function_exists( 'cinephile_scripts' ) ) :
	function cinephile_scripts() {
		$theme_version = wp_get_theme()->get( 'Version' );

		// 1. Font Locali
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
		// Caricati ovunque: le gallerie WP possono comparire in home, archivi,
		// singoli post e pagine. Lo script/Gli stili non fanno nulla se manca una galleria.
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
			$preset_global   = cinephile_sanitize_gallery_preset( get_theme_mod( 'gallery_props_preset', 'classico_master' ) );
			$preset_override = sanitize_key( get_post_meta( $post_id, '_cinephile_gallery_preset_override', true ) );

			$allowed      = cinephile_get_gallery_presets();
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
 * Carica gli stili CSS custom per il pannello amministrativo (metabox, ecc.)
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
 * Favicon predefinita del tema (emblema lente cinematografica con ciak dorato).
 * Viene caricata automaticamente solo se l'utente non ha impostato una propria Icona del Sito in WordPress.
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

