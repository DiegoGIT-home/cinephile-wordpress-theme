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

	// Immagine di copertina ad alta risoluzione da YouTube CDN (fallback a hqdefault se non presente maxres)
	$thumb_url = 'https://i.ytimg.com/vi/' . rawurlencode( $video_id ) . '/hqdefault.jpg';

	ob_start();
	?>
	<div class="cinephile-cinema-player-wrapper">
		<div class="cinephile-cinema-player" data-video-id="<?php echo esc_attr( $video_id ); ?>">
			<div class="cinema-player-poster" style="background-image: url('<?php echo esc_url( $thumb_url ); ?>');" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Riproduci trailer cinematografico', 'cinephile' ); ?>">
				
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

			<!-- Fallback per utenti con JavaScript disattivato -->
			<noscript>
				<iframe class="cinema-player-iframe" src="<?php echo esc_url( 'https://www.youtube-nocookie.com/embed/' . $video_id . '?rel=0&iv_load_policy=3&playsinline=1' ); ?>" title="<?php esc_attr_e( 'Riproduttore video YouTube', 'cinephile' ); ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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
