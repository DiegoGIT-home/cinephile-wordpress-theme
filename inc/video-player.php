<?php
/**
 * Modulo Player Video Cinematografico (Lite-Player Facade & Due Clic GDPR)
 *
 * Intercettazione degli embed di YouTube per garantire prestazioni estreme (Zero Cookie preventivi,
 * peso di 25KB invece di 1.2MB) ed estetica cinematografica responsive con supporto allo schermo intero.
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
 * Estrae l'identificativo univoco (Video ID a 11 caratteri) da qualsiasi URL o iframe di YouTube.
 *
 * Supporta formati standard:
 * - https://www.youtube.com/watch?v=VIDEO_ID
 * - https://youtu.be/VIDEO_ID
 * - https://www.youtube.com/embed/VIDEO_ID
 * - https://www.youtube-nocookie.com/embed/VIDEO_ID
 * - https://www.youtube.com/shorts/VIDEO_ID
 *
 * @param string $url_or_html URL o codice HTML contenente il link YouTube.
 * @return string|false ID del video se trovato, false altrimenti.
 */
function cinephile_extract_youtube_id( $url_or_html ) {
	$pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube-nocookie\.com\/embed\/)([a-zA-Z0-9_-]{11})/i';
	if ( preg_match( $pattern, $url_or_html, $matches ) ) {
		return sanitize_text_field( $matches[1] );
	}
	return false;
}

/**
 * Genera il markup HTML del Player Cinematografico Facade (Doppio Clic GDPR).
 *
 * @param string $video_id Identificativo del video YouTube.
 * @param string $caption  Didascalia opzionale del video.
 * @return string Markup HTML ottimizzato.
 */
function cinephile_render_cinema_video_player( $video_id, $caption = '' ) {
	if ( empty( $video_id ) ) {
		return '';
	}

	// Immagine di copertina: priorità all'immagine in evidenza locale del post per garantire conformità GDPR assoluta.
	// Zero chiamate terze preventive prima del consenso/clic dell'utente.
	$thumb_style = '';
	if ( has_post_thumbnail() ) {
		$featured_img_url = get_the_post_thumbnail_url( get_the_ID(), 'cinephile-hero-large' );
		if ( ! $featured_img_url ) {
			$featured_img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		}
		if ( $featured_img_url ) {
			$thumb_style = 'background-image: url(\'' . esc_url( $featured_img_url ) . '\');';
		}
	}

	// Filtro opzionale per consentire la miniatura remota di YouTube solo se espressamente autorizzata
	$allow_remote_thumb = apply_filters( 'cinephile_allow_remote_youtube_thumb', false, $video_id );
	if ( empty( $thumb_style ) && $allow_remote_thumb ) {
		$thumb_style = 'background-image: url(\'' . esc_url( 'https://i.ytimg.com/vi/' . rawurlencode( $video_id ) . '/hqdefault.jpg' ) . '\');';
	}

	ob_start();
	?>
	<div class="cinephile-cinema-player-wrapper">
		<div class="cinephile-cinema-player" data-video-id="<?php echo esc_attr( $video_id ); ?>">
			<div class="cinema-player-poster" <?php if ( ! empty( $thumb_style ) ) : ?>style="<?php echo esc_attr( $thumb_style ); ?>"<?php endif; ?> role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Riproduci trailer cinematografico', 'cinephile' ); ?>">
				
				<!-- Badge Cinematografico Superiore -->
				<div class="cinema-player-badge">
					<span class="cinema-badge-icon">🎬</span>
					<span class="cinema-badge-text"><?php esc_html_e( 'TRAILER UFFICIALE', 'cinephile' ); ?></span>
				</div>

				<!-- Pulsante Play Centrale d'Autore con Alone Luminoso -->
				<button type="button" class="cinema-player-btn" aria-label="<?php esc_attr_e( 'Avvia riproduzione video', 'cinephile' ); ?>">
					<span class="cinema-play-icon">
						<svg viewBox="0 0 24 24" width="30" height="30" fill="currentColor" aria-hidden="true">
							<polygon points="6 3 20 12 6 21 6 3"></polygon>
						</svg>
					</span>
					<span class="cinema-play-ripple" aria-hidden="true"></span>
				</button>

				<!-- Micro-Avviso di Trasparenza GDPR (Two-Click Solution) -->
				<div class="cinema-player-gdpr-notice">
					<span class="gdpr-lock-icon">🔒</span>
					<span class="gdpr-text"><?php esc_html_e( 'Cliccando su Play visualizzi il video tramite YouTube (youtube-nocookie.com)', 'cinephile' ); ?></span>
				</div>
			</div>

			<!-- Fallback per utenti con JavaScript disattivato (Zero connessioni esterne automatiche) -->
			<noscript>
				<div class="cinema-player-noscript" style="padding: 1.5rem; text-align: center; background: rgba(0,0,0,0.85); border-radius: 8px; margin-top: 1rem;">
					<p style="margin-bottom: 0.75rem; color: #cbd5e1;"><?php esc_html_e( 'JavaScript è disattivato nel browser. Per visualizzare il trailer su YouTube:', 'cinephile' ); ?></p>
					<a href="<?php echo esc_url( 'https://www.youtube-nocookie.com/embed/' . rawurlencode( $video_id ) ); ?>" target="_blank" rel="noopener noreferrer" style="display: inline-block; padding: 0.6rem 1.2rem; background: #e50914; color: #ffffff; border-radius: 4px; font-weight: 600; text-decoration: none;">
						▶ <?php esc_html_e( 'Guarda il video (apre YouTube in una nuova scheda)', 'cinephile' ); ?>
					</a>
				</div>
			</noscript>
		</div>

		<?php if ( ! empty( $caption ) ) : ?>
			<div class="cinema-player-caption"><?php echo wp_kses_post( $caption ); ?></div>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Intercetta l'embed classico di WordPress (URL incollato nel testo o [embed])
 * e lo trasforma nel Player Cinematografico ad alte prestazioni.
 *
 * @param string $html    Codice HTML dell'iframe originale generato da WordPress.
 * @param string $url     URL originale del video.
 * @param array  $attr    Attributi dell'embed.
 * @param int    $post_id ID del post.
 * @return string Codice HTML modificato.
 */
function cinephile_filter_oembed_youtube( $html, $url, $attr, $post_id ) {
	$video_id = cinephile_extract_youtube_id( $url );
	if ( $video_id ) {
		return cinephile_render_cinema_video_player( $video_id );
	}
	return $html;
}
add_filter( 'embed_oembed_html', 'cinephile_filter_oembed_youtube', 10, 4 );

/**
 * Intercetta i blocchi Gutenberg di tipo YouTube (core/embed)
 * e li sostituisce con il Player Cinematografico ad alta efficienza.
 *
 * @param string $block_content Contenuto renderizzato del blocco.
 * @param array  $block         Dati del blocco Gutenberg.
 * @return string Contenuto ottimizzato.
 */
function cinephile_filter_youtube_blocks( $block_content, $block ) {
	if ( 'core/embed' === $block['blockName'] ) {
		$url = isset( $block['attrs']['url'] ) ? $block['attrs']['url'] : '';
		if ( empty( $url ) && preg_match( '/src=["\']([^"\']+)["\']/i', $block_content, $matches ) ) {
			$url = $matches[1];
		}

		$video_id = cinephile_extract_youtube_id( $url );
		if ( $video_id ) {
			// Recupera eventuale didascalia (figcaption)
			$caption = '';
			if ( preg_match( '/<figcaption[^>]*>(.*?)<\/figcaption>/is', $block_content, $cap_matches ) ) {
				$caption = trim( $cap_matches[1] );
			}
			return cinephile_render_cinema_video_player( $video_id, $caption );
		}
	}
	return $block_content;
}
add_filter( 'render_block', 'cinephile_filter_youtube_blocks', 10, 2 );

/**
 * Registra e carica lo script Vanilla JS dedicato al video player nelle pagine singole.
 */
function cinephile_enqueue_video_player_script() {
	if ( is_singular() ) {
		$theme_version = wp_get_theme()->get( 'Version' );
		$js_file       = get_template_directory() . '/assets/js/video-player.js';
		$js_ver        = file_exists( $js_file ) ? (string) filemtime( $js_file ) : $theme_version;

		wp_enqueue_script(
			'cinephile-video-player',
			get_template_directory_uri() . '/assets/js/video-player.js',
			array(),
			$js_ver,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'cinephile_enqueue_video_player_script' );
