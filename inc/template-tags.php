<?php
/**
 * Modulo Template Tags e Helper per il Layout
 *
 * Funzioni ausiliarie per tempo di lettura, regolazione estratti, icone SVG scalabili e fallback grafici.
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
   1. REGOLAZIONE LUNGHEZZA ESTRATTO (EXCERPT)
   ========================================================================== */
if ( ! function_exists( 'cinephile_custom_excerpt_length' ) ) :
	function cinephile_custom_excerpt_length( $length ) {
		return 25;
	}
endif;
add_filter( 'excerpt_length', 'cinephile_custom_excerpt_length', 999 );


/* ==========================================================================
   2. CALCOLO DINAMICO DEL TEMPO DI LETTURA
   ========================================================================== */
if ( ! function_exists( 'cinephile_tempo_lettura' ) ) :
	/**
	 * Calcola il tempo di lettura stimato (in minuti) basandosi su una media di 200 parole al minuto.
	 *
	 * @param int|null $post_id ID dell'articolo.
	 * @return string Minuti stimati.
	 */
	function cinephile_tempo_lettura( $post_id = null ) {
		$post_id = $post_id ? $post_id : get_the_ID();
		if ( ! $post_id ) {
			return '1';
		}

		$content      = get_post_field( 'post_content', $post_id );
		$testo_pulito = wp_strip_all_tags( strip_shortcodes( $content ) );

		if ( empty( trim( $testo_pulito ) ) ) {
			return '1';
		}

		$numero_parole = count( preg_split( '/\s+/', trim( $testo_pulito ) ) );
		$minuti        = ceil( $numero_parole / 200 );

		return (string) max( 1, $minuti );
	}
endif;


/* ==========================================================================
   3. FALLBACK GLOBALE PER GLI ESTRATTI
   ========================================================================== */
if ( ! function_exists( 'cinephile_global_excerpt_fallback' ) ) :
	/**
	 * Garantisce la presenza di un estratto pulito anche se l'autore non ne ha inserito uno manuale.
	 */
	function cinephile_global_excerpt_fallback( $excerpt, $post ) {
		if ( ! empty( trim( $excerpt ) ) ) {
			return $excerpt;
		}

		$post_obj = get_post( $post );
		if ( ! $post_obj || empty( $post_obj->post_content ) ) {
			return '';
		}

		$content = strip_shortcodes( $post_obj->post_content );
		$content = wp_strip_all_tags( $content );
		$content = preg_replace( '/\s+/', ' ', $content );

		return wp_trim_words( trim( $content ), 22, '&hellip;' );
	}
endif;
add_filter( 'get_the_excerpt', 'cinephile_global_excerpt_fallback', 10, 2 );

if ( ! function_exists( 'cinephile_excerpt_more' ) ) :
	function cinephile_excerpt_more( $more ) {
		return '&hellip;';
	}
endif;
add_filter( 'excerpt_more', 'cinephile_excerpt_more' );


/* ==========================================================================
   4. RENDERING ICONE SVG PER RECAPITI E CONTATTI
   ========================================================================== */
if ( ! function_exists( 'cinephile_render_contact_icon' ) ) :
	/**
	 * Restituisce l'SVG inline corrispondente alla chiave dell'icona selezionata.
	 *
	 * @param string $icon_key Identificatore icona.
	 * @param int    $size     Dimensione viewBox (default: 22).
	 * @return string Markup SVG.
	 */
	function cinephile_render_contact_icon( $icon_key = 'email', $size = 22 ) {
		$size = absint( $size );
		$attr = sprintf( 'width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="contact-svg-icon"', $size );

		switch ( $icon_key ) {
			case 'pec':
				return sprintf( '<svg %s><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>', $attr );

			case 'chat':
				return sprintf( '<svg %s><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>', $attr );

			case 'send':
				return sprintf( '<svg %s><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>', $attr );

			case 'phone':
				return sprintf( '<svg %s><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>', $attr );

			case 'whatsapp':
				return sprintf( '<svg %s><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>', $attr );

			case 'clock':
				return sprintf( '<svg %s><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>', $attr );

			case 'location':
				return sprintf( '<svg %s><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>', $attr );

			case 'building':
				return sprintf( '<svg %s><rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="10" x2="16" y2="10"/><line x1="8" y1="14" x2="16" y2="14"/><line x1="9" y1="22" x2="9" y2="22.01"/><line x1="15" y1="22" x2="15" y2="22.01"/></svg>', $attr );

			case 'star':
				return sprintf( '<svg %s><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>', $attr );

			case 'email':
			default:
				return sprintf( '<svg %s><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>', $attr );
		}
	}
endif;

/* ==========================================================================
   5. RENDERING ICONE PER I PILASTRI ("CHI SIAMO")
   ========================================================================== */
if ( ! function_exists( 'cinephile_render_pillar_icon' ) ) :
	/**
	 * Renderizza l'icona per le schede valori/pilastri della pagina Chi Siamo.
	 * Supporta icone SVG vettoriali native e immagini personalizzate caricate dall'utente.
	 *
	 * @param string $icon_key        Identificatore icona (compass, film, book, ecc.).
	 * @param string $custom_icon_url URL dell'immagine personalizzata (se caricata).
	 * @param int    $size            Dimensione in pixel (default: 28).
	 * @param string $alt_text        Testo alternativo per l'immagine.
	 * @return string Markup HTML/SVG pronto per il rendering.
	 */
	function cinephile_render_pillar_icon( $icon_key = 'compass', $custom_icon_url = '', $size = 28, $alt_text = '' ) {
		$size = absint( $size );
		if ( $size <= 0 ) {
			$size = 28;
		}

		// 1. Se è stata fornita un'icona personalizzata (URL valido), usala con priorità
		if ( ! empty( $custom_icon_url ) ) {
			return sprintf(
				'<img src="%s" alt="%s" width="%d" height="%d" loading="lazy" decoding="async" class="pillar-custom-img" />',
				esc_url( $custom_icon_url ),
				esc_attr( ! empty( $alt_text ) ? $alt_text : __( 'Icona pilastro', 'cinephile' ) ),
				$size,
				$size
			);
		}

		// 2. Altrimenti renderizza l'SVG inline vettoriale corrispondente
		$attr = sprintf( 'width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="pillar-svg-icon"', $size );

		switch ( $icon_key ) {
			case 'film':
				return sprintf( '<svg %s><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/><line x1="7" y1="2" x2="7" y2="22"/><line x1="17" y1="2" x2="17" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/></svg>', $attr );

			case 'book':
				return sprintf( '<svg %s><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>', $attr );

			case 'clapperboard':
				return sprintf( '<svg %s><path d="M20.2 6 3 11l-.9-2.4c-.4-1.1.2-2.4 1.3-2.8l13.5-5c1.1-.4 2.4.2 2.8 1.3l.5 1.9Z"/><path d="m6.2 5.3 3.1 4"/><path d="m12.4 3 3.1 4"/><path d="M3 11h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V11Z"/></svg>', $attr );

			case 'camera':
				return sprintf( '<svg %s><path d="m16 8 5-3v14l-5-3V8Z"/><rect x="2" y="6" width="14" height="12" rx="2"/></svg>', $attr );

			case 'award':
				return sprintf( '<svg %s><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>', $attr );

			case 'star':
				return sprintf( '<svg %s><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>', $attr );

			case 'eye':
				return sprintf( '<svg %s><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>', $attr );

			case 'feather':
				return sprintf( '<svg %s><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"/><line x1="16" y1="8" x2="2" y2="22"/><line x1="17.5" y1="15" x2="9" y2="15"/></svg>', $attr );

			case 'ticket':
				return sprintf( '<svg %s><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><line x1="13" y1="5" x2="13" y2="19" stroke-dasharray="2 2"/></svg>', $attr );

			case 'projector':
				return sprintf( '<svg %s><rect x="2" y="10" width="16" height="10" rx="2"/><circle cx="10" cy="15" r="3"/><path d="m18 13 4-2v6l-4-2"/><circle cx="6" cy="6" r="3"/><circle cx="14" cy="6" r="3"/></svg>', $attr );

			case 'flame':
				return sprintf( '<svg %s><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>', $attr );

			case 'heart':
				return sprintf( '<svg %s><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>', $attr );

			case 'sparkles':
				return sprintf( '<svg %s><path d="m12 3-1.9 5.8a2 2 0 0 1-1.3 1.3L3 12l5.8 1.9a2 2 0 0 1 1.3 1.3L12 21l1.9-5.8a2 2 0 0 1 1.3-1.3L21 12l-5.8-1.9a2 2 0 0 1-1.3-1.3Z"/><path d="M5 3v4"/><path d="M19 17v4"/><path d="M3 5h4"/><path d="M17 19h4"/></svg>', $attr );

			case 'compass':
			default:
				return sprintf( '<svg %s><path d="M2 12h20M12 2v20M20 6L4 18M4 6l16 12"/></svg>', $attr );
		}
	}
endif;
