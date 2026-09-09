<?php
/**
 * Gestione e Ottimizzazione Immagini (WebP Native)
 *
 * Definizione taglie personalizzate, soppressione dimensioni ridondanti e conversione ritagli in WebP.
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
 * Registra le dimensioni delle immagini necessarie al layout del tema.
 */
function cinephile_setup_image_sizes() {
	// Immagine in Evidenza (1200x630px - Rapporto 16:9 con crop centrale per Hero e Open Graph)
	set_post_thumbnail_size( 1200, 630, true );

	// Taglia specifica per immagini nel corpo degli articoli (800px larghezza, altezza proporzionale)
	add_image_size( 'foto_articolo', 800, 9999, false );

	// Taglia ad alta definizione per Lightbox e gallerie (1600px larghezza max)
	add_image_size( 'foto_galleria_hd', 1600, 1600, false );
}
add_action( 'after_setup_theme', 'cinephile_setup_image_sizes' );

/**
 * Disabilita le dimensioni ridondanti generate di default da WordPress per evitare spreco di spazio disco.
 *
 * @param array $sizes Array delle dimensioni attive.
 * @return array Array ridotto con le sole dimensioni utilizzate.
 */
function cinephile_disable_unused_image_sizes( $sizes ) {
	// Mantiene medium, medium_large e large: i template li richiamano
	// costantemente (the_post_thumbnail) e rimuoverli causa layout rotti.
	unset( $sizes['thumbnail'] );
	unset( $sizes['1536x1536'] );
	unset( $sizes['2048x2048'] );

	return $sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'cinephile_disable_unused_image_sizes' );

// Disattiva la creazione automatica dell'immagine ridimensionata soglia (-scaled) per file sopra i 2560px
add_filter( 'big_image_size_threshold', '__return_false' );

/**
 * Limita le opzioni di selezione dimensioni all'interno dell'editor di testo Gutenberg ai soli formati approvati.
 */
function cinephile_editor_image_sizes( $sizes ) {
	return array(
		'foto_articolo'    => __( 'Foto Articolo (Standard 800px)', 'cinephile' ),
		'foto_galleria_hd' => __( 'Foto Galleria HD (Grande 1600px)', 'cinephile' ),
	);
}
add_filter( 'image_size_names_choose', 'cinephile_editor_image_sizes' );

/**
 * Forza il salvataggio dei ritagli intermedi direttamente nel formato di compressione WebP.
 */
function cinephile_force_webp_output( $formats ) {
	$formats['image/jpeg'] = 'image/webp';
	$formats['image/png']  = 'image/webp';
	return $formats;
}
add_filter( 'image_editor_output_format', 'cinephile_force_webp_output' );
