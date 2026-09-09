<?php
/**
 * Modulo Sicurezza Nativa WP (Zero-Plugin)
 *
 * Disabilitazione vettori di attacco (XML-RPC, Pingback, Enumerazione Utenti) e pulizia header HTTP.
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
   1. DISABILITAZIONE XML-RPC E PINGBACK (Anti-DDoS e Spam)
   ========================================================================== */

// Disabilita la libreria XML-RPC utilizzata storicamente per attacchi Brute-Force e DDoS
add_filter( 'xmlrpc_enabled', '__return_false' );

// Disabilita i pingback di default per prevenire attacchi di tipo Amplification
add_filter( 'pre_option_default_pingback_flag', '__return_zero' );

/**
 * Rimuove l'header HTTP 'X-Pingback' dalle risposte del server.
 *
 * @param array $headers Array degli header HTTP inviati da WordPress.
 * @return array Header modificati.
 */
function cinephile_remove_x_pingback_header( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
}
add_filter( 'wp_headers', 'cinephile_remove_x_pingback_header' );


/* ==========================================================================
   2. FIREWALL NATIVO LEGGERO (Filtro Zero-Plugin per Query Malevole)
   ========================================================================== */

/**
 * Analizza le richieste HTTP in ingresso ed esegue il blocco istantaneo (403 Forbidden)
 * in presenza di pattern tipici di XSS, SQL Injection o Directory Traversal.
 */
function cinephile_native_lightweight_firewall() {
	global $pagenow;

	// Salta i controlli per gli utenti autenticati, l'area admin, le API REST e i cron job
	if ( is_admin() || is_user_logged_in() || 'wp-login.php' === $pagenow || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || ( defined( 'DOING_CRON' ) && DOING_CRON ) ) {
		return;
	}

	$request_uri  = isset( $_SERVER['REQUEST_URI'] ) ? rawurldecode( $_SERVER['REQUEST_URI'] ) : '';
	$query_string = isset( $_SERVER['QUERY_STRING'] ) ? rawurldecode( $_SERVER['QUERY_STRING'] ) : '';

	// Pattern di stringhe potenzialmente dannose
	$bad_patterns = array(
		'eval\(',
		'base64_decode',
		'UNION\s+SELECT',
		'concat\(',
		'<script',
		'document\.cookie',
		'\.\.\/\.\.',
		'etc\/passwd',
		'boot\.ini',
		'GLOBALS\(',
		'REQUEST\(',
		'_POST\['
	);

	foreach ( $bad_patterns as $pattern ) {
		if ( preg_match( '#' . $pattern . '#i', $request_uri ) || preg_match( '#' . $pattern . '#i', $query_string ) ) {
			wp_die(
				esc_html__( 'Richiesta non autorizzata bloccata dal sistema di sicurezza.', 'cinephile' ),
				esc_html__( 'Accesso Negato', 'cinephile' ),
				array( 'response' => 403 )
			);
		}
	}
}
add_action( 'init', 'cinephile_native_lightweight_firewall', 1 );


/* ==========================================================================
   3. PREVENZIONE ENUMERAZIONE UTENTI ED AUTORI
   ========================================================================== */

/**
 * Blocca i tentativi di rilevare gli username degli amministratori tramite la query GET `?author=N`.
 */
function cinephile_block_author_enumeration() {
	global $pagenow;

	if ( is_admin() || is_user_logged_in() || 'wp-login.php' === $pagenow || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || ( defined( 'DOING_CRON' ) && DOING_CRON ) ) {
		return;
	}

	if ( isset( $_GET['author'] ) || ( isset( $_SERVER['REQUEST_URI'] ) && preg_match( '/\/(wp-json\/wp\/v2\/users|author-sitemap)/i', $_SERVER['REQUEST_URI'] ) ) ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'cinephile_block_author_enumeration' );

/**
 * Rstringe l'accesso all'endpoint REST API `/wp/v2/users` ai soli utenti autenticati.
 */
function cinephile_restrict_rest_users_endpoint( $response, $server, $request ) {
	$route = $request->get_route();
	if ( ( 0 === strpos( $route, '/wp/v2/users' ) ) && ! is_user_logged_in() ) {
		return new WP_Error(
			'rest_forbidden',
			__( 'Accesso non autorizzato all\'elenco utenti.', 'cinephile' ),
			array( 'status' => 401 )
		);
	}
	return $response;
}
add_filter( 'rest_pre_dispatch', 'cinephile_restrict_rest_users_endpoint', 10, 3 );


/* ==========================================================================
   4. PULIZIA HEADER WP E RIMOZIONE INFO VERSIONI
   ========================================================================== */

// Rimuove tag meta con versione di WordPress (scelta utile per ridurre le impronte digitali di versione)
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

/**
 * Rimuove la query string `?ver=` da asset CSS/JS per migliorare l'incapsulamento del tema.
 *
 * @param string $src URL della risorsa.
 * @return string URL pulito.
 */
function cinephile_remove_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
if ( ! is_admin() ) {
	add_filter( 'style_loader_src', 'cinephile_remove_ver_css_js', 9999 );
	add_filter( 'script_loader_src', 'cinephile_remove_ver_css_js', 9999 );
}
