<?php
/**
 * Protezione Indirizzi Email (Anti-Spam GDPR Native)
 *
 * Offuscamento dinamico in Base64 via PHP e ricostruzione client-side con JavaScript.
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

if ( ! function_exists( 'cinephile_proteggi_email_js' ) ) :
	/**
	 * Scansiona il contenuto e converte gli indirizzi email in elementi HTML2Base64
	 * per impedire la scansione automatica da parte degli spambot.
	 *
	 * @param string $content Contenuto HTML da filtrare.
	 * @return string Contenuto con email offuscate.
	 */
	function cinephile_proteggi_email_js( $content ) {
		$pattern = '/([a-zA-Z0-9._%+-]+)@([a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/';

		return preg_replace_callback( $pattern, function( $matches ) {
			$user_b64   = base64_encode( $matches[1] );
			$domain_b64 = base64_encode( $matches[2] );

			return sprintf(
				'<span class="js-email-protect" data-u="%s" data-d="%s"></span>',
				esc_attr( $user_b64 ),
				esc_attr( $domain_b64 )
			);
		}, $content );
	}
endif;

if ( ! function_exists( 'cinephile_render_protected_email' ) ) :
	/**
	 * Restituisce il markup offuscato in Base64 per un singolo indirizzo email,
	 * con fallback antispambot nativo di WordPress per utenti senza JS attivo.
	 *
	 * @param string $email Indirizzo email da mascherare.
	 * @return string Elemento HTML protetto.
	 */
	function cinephile_render_protected_email( $email ) {
		if ( empty( $email ) || ! is_email( $email ) ) {
			return '';
		}

		$parts = explode( '@', $email, 2 );
		if ( 2 !== count( $parts ) ) {
			$safe = antispambot( $email );
			return '<a href="mailto:' . esc_attr( $safe ) . '">' . esc_html( $safe ) . '</a>';
		}

		$user_b64   = base64_encode( $parts[0] );
		$domain_b64 = base64_encode( $parts[1] );
		$fallback   = antispambot( $email );

		return sprintf(
			'<span class="js-email-protect" data-u="%s" data-d="%s"></span><noscript><a href="mailto:%s">%s</a></noscript>',
			esc_attr( $user_b64 ),
			esc_attr( $domain_b64 ),
			esc_attr( $fallback ),
			esc_html( $fallback )
		);
	}
endif;

// Applicazione filtri sul contenuto degli articoli, widget e riassunti
add_filter( 'the_content', 'cinephile_proteggi_email_js', 20 );
add_filter( 'widget_text', 'cinephile_proteggi_email_js', 20 );
add_filter( 'the_excerpt', 'cinephile_proteggi_email_js', 20 );

/**
 * Decodifica ed emette il link mailto dinamico via JavaScript nel footer.
 */
add_action( 'wp_footer', function() {
	?>
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		document.querySelectorAll('.js-email-protect').forEach(function(el) {
			var u = atob(el.getAttribute('data-u'));
			var d = atob(el.getAttribute('data-d'));
			var email = u + '@' + d;

			var a = document.createElement('a');
			a.href = 'mailto:' + email;
			a.textContent = email;

			el.parentNode.replaceChild(a, el);
		});
	});
	</script>
	<?php
}, 99 );
