<?php
/**
 * Funzioni ed estensioni personalizzate per Cinephile Child Theme
 *
 * Consente di aggiungere hook, filtri e funzioni PHP personalizzate senza
 * modificare i file del tema genitore, proteggendo il sito dagli aggiornamenti futuri.
 *
 * Tema Genitore: Cinephile - Editorial Cinema Magazine
 * Ideatore: Diego Costanzo (Firenze, Italia)
 * Licenza: GNU General Public License v2 or later
 *
 * @package Cinephile_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Accoda lo stile del tema child dopo lo stile principale del tema genitore.
 */
function cinephile_child_enqueue_styles() {
	wp_enqueue_style(
		'cinephile-child-style',
		get_stylesheet_uri(),
		array( 'cinephile-style' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'cinephile_child_enqueue_styles', 20 );

/* ==========================================================================
   AGGIUNGI QUI SOTTO LE TUE FUNZIONI, FILTRI O HOOK PERSONALIZZATI (PHP)
   ========================================================================== */

