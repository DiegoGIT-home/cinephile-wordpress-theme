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

/**
 * Imposta la larghezza massima globale del contenuto per WordPress.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}

if ( ! function_exists( 'cinephile_setup' ) ) :
	function cinephile_setup() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'align-wide' );

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

