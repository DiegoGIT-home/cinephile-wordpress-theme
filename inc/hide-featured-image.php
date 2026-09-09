<?php
/**
 * Modulo Funzionalità Nascondi Cover
 *
 * Tag di servizio per sopprimere la copertina in evidenza nel singolo articolo con filtro frontend trasparente.
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

if ( ! function_exists( 'cinephile_create_utility_tag' ) ) :
	/**
	 * Inserisce il tag di servizio se non ancora presente nel database.
	 */
	function cinephile_create_utility_tag() {
		if ( current_user_can( 'manage_categories' ) && ! term_exists( 'nascondi-cover', 'post_tag' ) ) {
			wp_insert_term(
				'Nascondi Cover',
				'post_tag',
				array(
					'slug'        => 'nascondi-cover',
					'description' => __( 'Tag di servizio per nascondere l\'immagine in evidenza nel singolo articolo.', 'cinephile' ),
				)
			);
		}
	}
endif;
add_action( 'after_switch_theme', 'cinephile_create_utility_tag' );
add_action( 'admin_init', 'cinephile_create_utility_tag' );

/**
 * Intercetta la presenza del miniatura post e restituisce false se il tag di servizio è applicato all'articolo.
 */
function cinephile_filter_thumbnail_visibility( $has_thumbnail, $post ) {
	if ( ! $has_thumbnail || ! is_single() ) {
		return $has_thumbnail;
	}

	return has_tag( 'nascondi-cover', $post ) ? false : $has_thumbnail;
}
add_filter( 'has_post_thumbnail', 'cinephile_filter_thumbnail_visibility', 10, 2 );

/**
 * Rimuove il tag di servizio dall'elenco visibile dei tag nel frontend, rendendolo invisibile agli utenti.
 */
function cinephile_hide_utility_tag_from_frontend( $terms, $post_id, $taxonomy ) {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return $terms;
	}

	if ( 'post_tag' !== $taxonomy || empty( $terms ) || is_wp_error( $terms ) ) {
		return $terms;
	}

	$filtered = array_filter( $terms, function( $term ) {
		return is_object( $term ) && isset( $term->slug ) && 'nascondi-cover' !== $term->slug;
	} );

	return array_values( $filtered );
}
add_filter( 'get_the_terms', 'cinephile_hide_utility_tag_from_frontend', 10, 3 );
