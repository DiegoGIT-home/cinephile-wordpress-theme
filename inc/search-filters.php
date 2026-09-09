<?php
/**
 * Modulo Filtri di Ricerca Frontend
 *
 * Esclusione dinamica delle pagine istituzionali dai risultati di ricerca per preservare l'archivio recensioni.
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
 * Modifica la query principale di ricerca per escludere le pagine istituzionali dinamiche.
 *
 * @param WP_Query $query Istanza della query di WordPress.
 * @return WP_Query
 */
function cinephile_exclude_institutional_pages_from_search( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
		// Recupera dinamicamente gli ID salvati nelle opzioni del tema
		$about_id    = (int) get_option( 'cinephile_page_about_id' );
		$contacts_id = (int) get_option( 'cinephile_page_contacts_id' );
		$privacy_id  = (int) get_option( 'cinephile_page_privacy_id' );

		$ids_to_exclude = array_filter( array( $about_id, $contacts_id, $privacy_id ) );

		if ( ! empty( $ids_to_exclude ) ) {
			$query->set( 'post__not_in', $ids_to_exclude );
		}
	}

	return $query;
}
add_filter( 'pre_get_posts', 'cinephile_exclude_institutional_pages_from_search' );
