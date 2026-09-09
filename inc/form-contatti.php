<?php
/**
 * Modulo Elaborazione Form Contatti (Sicurezza & Rate Limiting)
 *
 * Validazione lato server, protezione honeypot/nonce, limitazione transient anti-spam e invio via wp_mail.
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

if ( ! function_exists( 'cinephile_get_client_ip' ) ) :
	/**
	 * Recupera l'indirizzo IP del client in modo sicuro escludendo header spoofabili.
	 *
	 * @return string Indirizzo IP validato.
	 */
	function cinephile_get_client_ip() {
		// Se il sito è dietro Cloudflare, l'header CF-CONNECTING-IP contiene l'IP reale
		// del visitatore ed è considerato sicuro (non spoofabile quando valido il proxy).
		if ( isset( $_SERVER['HTTP_CF_CONNECTING_IP'] ) ) {
			$cf_ip = wp_unslash( $_SERVER['HTTP_CF_CONNECTING_IP'] );
			if ( filter_var( $cf_ip, FILTER_VALIDATE_IP ) ) {
				return $cf_ip;
			}
		}

		$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? wp_unslash( $_SERVER['REMOTE_ADDR'] ) : '127.0.0.1';
		return filter_var( $ip, FILTER_VALIDATE_IP ) ? $ip : '127.0.0.1';
	}
endif;

if ( ! function_exists( 'cinephile_process_contact_form' ) ) :
	/**
	 * Elabora le richieste inviate dal form contatti.
	 *
	 * @return string Messaggio HTML di risposta per il frontend.
	 */
	function cinephile_process_contact_form() {
		if ( 'POST' !== $_SERVER['REQUEST_METHOD'] || ! isset( $_POST['contact_form_nonce_field'] ) ) {
			return '';
		}

		// 1. Controllo Anti-CSRF (Nonce)
		$nonce_field = sanitize_text_field( wp_unslash( $_POST['contact_form_nonce_field'] ) );
		if ( empty( $nonce_field ) || ! wp_verify_nonce( $nonce_field, 'submit_contact_form_action' ) ) {
			return '<div class="form-alert alert-error">' . esc_html__( 'Sessione non valida o pagina scaduta. Ricarica la pagina e riprova.', 'cinephile' ) . '</div>';
		}

		// 2. Controllo Honeypot (Trappola per Bot)
		$hp_check = isset( $_POST['check_real_user_hp'] ) ? sanitize_text_field( wp_unslash( $_POST['check_real_user_hp'] ) ) : '';
		if ( ! empty( $hp_check ) ) {
			return '<div class="form-alert alert-error">' . esc_html__( 'Invio bloccato dal filtro di sicurezza anti-bot.', 'cinephile' ) . '</div>';
		}

		// 3. Controllo Time-Gate (Minimo 6 secondi di permanenza prima dell'invio)
		$time_check = isset( $_POST['form_time_check'] ) ? absint( wp_unslash( $_POST['form_time_check'] ) ) : 0;
		if ( ( time() - $time_check ) < 6 ) {
			return '<div class="form-alert alert-error">' . esc_html__( 'Invio troppo rapido. Attendi qualche secondo prima di inviare.', 'cinephile' ) . '</div>';
		}

		// 4. Rate Limiting via IP (Blocco invii multipli entro 15 minuti)
		$user_ip      = cinephile_get_client_ip();
		$ip_transient = 'cc_form_limit_' . md5( $user_ip );

		if ( get_transient( $ip_transient ) ) {
			return '<div class="form-alert alert-error">' . esc_html__( 'Limite di invii raggiunto per il tuo indirizzo IP. Riprova tra 15 minuti.', 'cinephile' ) . '</div>';
		}

		// 5. Sanitizzazione dei campi in ingresso
		$nome      = isset( $_POST['nome'] ) ? sanitize_text_field( wp_unslash( $_POST['nome'] ) ) : '';
		$email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		$oggetto   = isset( $_POST['oggetto'] ) ? sanitize_text_field( wp_unslash( $_POST['oggetto'] ) ) : '';
		$messaggio = isset( $_POST['messaggio'] ) ? sanitize_textarea_field( wp_unslash( $_POST['messaggio'] ) ) : '';

		// 6. Prevenzione Link Spam (Massimo 1 URL ammesso nel testo)
		$lower_msg     = strtolower( $messaggio );
		$conteggio_url = substr_count( $lower_msg, 'http://' ) + substr_count( $lower_msg, 'https://' );
		if ( $conteggio_url > 1 ) {
			return '<div class="form-alert alert-error">' . esc_html__( 'Il messaggio non può contenere più di un link esterno.', 'cinephile' ) . '</div>';
		}

		// 7. Validazione Campi Obbligatori
		if ( ! is_email( $email ) || empty( $nome ) || empty( $messaggio ) ) {
			return '<div class="form-alert alert-error">' . esc_html__( 'Compila tutti i campi obbligatori inserendo un indirizzo email valido.', 'cinephile' ) . '</div>';
		}

		// Prepara la mail
		$contact_target = get_theme_mod( 'contact_email', get_option( 'admin_email' ) );
		$to             = sanitize_email( ! empty( $contact_target ) ? $contact_target : get_option( 'admin_email' ) );
		$site_title     = get_bloginfo( 'name' );
		$subject        = sprintf(
			/* translators: 1: Nome sito, 2: Oggetto messaggio */
			__( 'Nuovo messaggio da %1$s: %2$s', 'cinephile' ),
			! empty( $site_title ) ? $site_title : __( 'Sito Web', 'cinephile' ),
			( ! empty( $oggetto ) ? $oggetto : __( 'Senza oggetto', 'cinephile' ) )
		);

		$body  = "Hai ricevuto un messaggio dal modulo contatti del sito.\n\n";
		$body .= "Nome: " . $nome . "\n";
		$body .= "Email: " . $email . "\n";
		$body .= "Oggetto: " . ( ! empty( $oggetto ) ? $oggetto : 'N/D' ) . "\n\n";
		$body .= "Messaggio:\n" . $messaggio . "\n";

		// Protezione Header Injection
		$clean_nome  = sanitize_text_field( str_replace( array( "\r", "\n", '"', "'", '<', '>' ), '', $nome ) );
		$clean_email = sanitize_email( str_replace( array( "\r", "\n", '%0a', '%0d' ), '', $email ) );

		$headers = array(
			'Content-Type: text/plain; charset=UTF-8',
			'Reply-To: "' . $clean_nome . '" <' . $clean_email . '>',
		);

		// 8. Invio effettivo
		if ( wp_mail( $to, $subject, $body, $headers ) ) {
			set_transient( $ip_transient, true, 15 * MINUTE_IN_SECONDS );
			return '<div class="form-alert alert-success">' . esc_html__( 'Messaggio inviato con successo! Ti risponderemo al più presto.', 'cinephile' ) . '</div>';
		}

		return '<div class="form-alert alert-error">' . esc_html__( 'Si è verificato un errore tecnico durante l\'invio. Riprova più tardi.', 'cinephile' ) . '</div>';
	}
endif;
