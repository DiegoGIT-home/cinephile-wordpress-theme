<?php
/**
 * Pulizia Estratti ed Eliminazione URL Raw
 *
 * Sanitizzazione degli estratti automatici con soppressione degli URL video e formattazione pulita.
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

if ( ! function_exists( 'cinephile_clean_youtube_from_excerpt' ) ) :
	/**
	 * Filtra il testo del riassunto rimuovendo eventuali collegamenti testuali a YouTube.
	 *
	 * @param string $excerpt Testo dell'estratto.
	 * @return string Estratto ripulito.
	 */
	function cinephile_clean_youtube_from_excerpt( $excerpt ) {
		// Espressione regolare per identificare URL di YouTube (sia estesi che abbreviati youtu.be)
		$pattern = '/https?:\/\/(www\.)?(youtube\.com|youtu\.be)\/[^\s<]+/i';

		$excerpt_pulito = preg_replace( $pattern, '', $excerpt );

		return trim( $excerpt_pulito );
	}
endif;

// Applicazione filtri agli estratti
add_filter( 'get_the_excerpt', 'cinephile_clean_youtube_from_excerpt', 20 );
add_filter( 'the_excerpt', 'cinephile_clean_youtube_from_excerpt', 20 );
add_filter( 'wp_trim_excerpt', 'cinephile_clean_youtube_from_excerpt', 20 );
