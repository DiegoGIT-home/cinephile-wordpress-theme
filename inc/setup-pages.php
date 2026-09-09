<?php
/**
 * Inizializzazione Pagine Istituzionali e Privacy GDPR Dinamica
 *
 * Creazione automatica pagine di servizio al setup e rendering shortcode conforme al Regolamento UE 2016/679.
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
   1. SHORTCODE PRIVACY POLICY GDPR DINAMICA
   ========================================================================== */

/**
 * Renderizza l'informativa Privacy e Cookie Policy completa e conforme GDPR.
 * I dati del Titolare e del Fornitore Hosting sono sincronizzati in tempo reale
 * con i valori inseriti nel Customizer (Sezione 4. Dati Legali & Privacy).
 * Se l'utente desidera personalizzare il testo da WordPress, può modificare la pagina
 * sostituendo o integrando questo shortcode con il proprio testo nell'editor a blocchi.
 *
 * @return string HTML dell'informativa privacy.
 */
function cinephile_privacy_gdpr_shortcode() {
	$defaults = function_exists( 'cinephile_get_customizer_defaults' ) ? cinephile_get_customizer_defaults() : array();

	$owner_name         = get_theme_mod( 'owner_name', isset( $defaults['owner_name'] ) ? $defaults['owner_name'] : __( '[NOME E COGNOME / RAGIONE SOCIALE]', 'cinephile' ) );
	$owner_city         = get_theme_mod( 'owner_city', isset( $defaults['owner_city'] ) ? $defaults['owner_city'] : __( '[CITTÀ / SEDE DEL TITOLARE]', 'cinephile' ) );
	$owner_email        = get_theme_mod( 'owner_email', isset( $defaults['owner_email'] ) ? $defaults['owner_email'] : get_option( 'admin_email' ) );
	$hosting_name       = get_theme_mod( 'hosting_name', isset( $defaults['hosting_name'] ) ? $defaults['hosting_name'] : __( '[NOME FORNITORE HOSTING]', 'cinephile' ) );
	$hosting_address    = get_theme_mod( 'hosting_address', isset( $defaults['hosting_address'] ) ? $defaults['hosting_address'] : __( '[SEDE LEGALE FORNITORE HOSTING]', 'cinephile' ) );
	$hosting_privacy_url= get_theme_mod( 'hosting_privacy_url', isset( $defaults['hosting_privacy_url'] ) ? $defaults['hosting_privacy_url'] : 'https://example.com/privacy' );

	$site_name          = get_bloginfo( 'name' );
	$site_url           = home_url( '/' );
	$comments_enabled   = (bool) get_theme_mod( 'enable_comments_system', false );
	$sec_contact        = $comments_enabled ? 7 : 6;
	$sec_rights         = $comments_enabled ? 8 : 7;
	$sec_updates        = $comments_enabled ? 9 : 8;

	// Protezione email con antispambot nativo
	$safe_email = ! empty( $owner_email ) ? antispambot( $owner_email ) : 'info@' . wp_parse_url( home_url(), PHP_URL_HOST );

	ob_start();
	?>
	<div class="gdpr-privacy-document">

		<section class="privacy-section">
			<h3 class="wp-block-heading"><?php esc_html_e( '1. Titolare del Trattamento dei Dati', 'cinephile' ); ?></h3>
			<p class="wp-block-paragraph">
				<?php
				printf(
					/* translators: 1: Nome Titolare, 2: Sede Titolare, 3: Nome Sito, 4: URL Sito, 5: Email sicura */
					esc_html__( 'Il titolare del trattamento dei dati raccolti tramite questo sito web è %1$s (Sede: %2$s), gestore del sito web %3$s (%4$s). Per qualsiasi chiarimento o richiesta relativa alla protezione dei dati personali, è possibile contattare direttamente il Titolare all\'indirizzo email: ', 'cinephile' ),
					'<strong>' . esc_html( $owner_name ) . '</strong>',
					esc_html( $owner_city ),
					'<strong>' . esc_html( $site_name ) . '</strong>',
					'<code>' . esc_url( $site_url ) . '</code>'
				);
				?>
				<a href="mailto:<?php echo esc_attr( $safe_email ); ?>"><strong><?php echo wp_kses_post( $safe_email ); ?></strong></a>.
			</p>
		</section>

		<section class="privacy-section">
			<h3 class="wp-block-heading"><?php esc_html_e( '2. Fornitore del Servizio di Hosting & Infrastruttura', 'cinephile' ); ?></h3>
			<p class="wp-block-paragraph">
				<?php
				printf(
					/* translators: 1: Nome Provider Hosting, 2: Sede Provider Hosting */
					esc_html__( 'Il sito web, il database e il servizio di posta elettronica sono ospitati sui server del provider %1$s (%2$s). I dati di navigazione e i log di sicurezza risiedono e vengono elaborati all\'interno del territorio dell\'Unione Europea in piena conformità con il Regolamento UE 2016/679 (GDPR).', 'cinephile' ),
					'<strong>' . esc_html( $hosting_name ) . '</strong>',
					esc_html( $hosting_address )
				);
				?>
				<?php if ( ! empty( $hosting_privacy_url ) && 'https://example.com/privacy' !== $hosting_privacy_url ) : ?>
					<br>
					<a href="<?php echo esc_url( $hosting_privacy_url ); ?>" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( '→ Consulta l\'informativa sulla privacy del fornitore hosting', 'cinephile' ); ?>
					</a>
				<?php endif; ?>
			</p>
		</section>

		<section class="privacy-section">
			<h3 class="wp-block-heading"><?php esc_html_e( '3. Tipologia di Dati Trattati e Finalità', 'cinephile' ); ?></h3>
			<p class="wp-block-paragraph">
				<?php
				printf(
					/* translators: %s: Nome del sito web */
					esc_html__( '%s è una pubblicazione digitale indipendente a prevalente consultazione libera e aperta:', 'cinephile' ),
					'<strong>' . esc_html( $site_name ) . '</strong>'
				);
				?>
			</p>
			<ul class="wp-block-list">
				<li><?php esc_html_e( 'Nessuna registrazione utente obbligatoria per la consultazione degli articoli e delle recensioni.', 'cinephile' ); ?></li>
				<?php if ( $comments_enabled ) : ?>
					<li><strong><?php esc_html_e( 'Commenti agli articoli (Facoltativo):', 'cinephile' ); ?></strong> <?php esc_html_e( 'I lettori possono facoltativamente commentare gli articoli. Vengono trattati nome/nickname, email, testo del commento, indirizzo IP e user agent per le sole finalità di moderazione e pubblicazione (disciplinato in dettaglio al punto 6).', 'cinephile' ); ?></li>
				<?php else : ?>
					<li><strong><?php esc_html_e( 'Sistema commenti disabilitato:', 'cinephile' ); ?></strong> <?php esc_html_e( 'La funzione commenti è disattivata su tutti i contenuti del sito. Non vengono memorizzati commenti, opinioni né dati personali o indirizzi IP di visitatori per interazioni pubbliche.', 'cinephile' ); ?></li>
				<?php endif; ?>
				<li><?php esc_html_e( 'Non vengono raccolti né trattati dati particolari o sensibili.', 'cinephile' ); ?></li>
				<li><?php esc_html_e( 'Nessun dato viene ceduto a terzi per scopi promozionali, commerciali o di profilazione.', 'cinephile' ); ?></li>
			</ul>
		</section>

		<section class="privacy-section">
			<h3 class="wp-block-heading"><?php esc_html_e( '4. Dati di Navigazione e Sicurezza del Server', 'cinephile' ); ?></h3>
			<p class="wp-block-paragraph">
				<?php esc_html_e( 'I sistemi informatici e le procedure software preposte al funzionamento di questo sito web acquisiscono, nel corso del loro normale esercizio, alcuni dati tecnici la cui trasmissione è implicita nell\'uso dei protocolli di comunicazione di Internet (es. indirizzo IP, tipo di browser, orario di richiesta, pagina visitata). Questi dati vengono trattati al solo fine di controllare il corretto funzionamento del sito, prevenire attacchi informatici ed intrusioni malevole. Base giuridica: Legittimo interesse del Titolare alla sicurezza informatica e alla continuità operativa (Art. 6, par. 1, lett. f del GDPR).', 'cinephile' ); ?>
			</p>
		</section>

		<section class="privacy-section">
			<h3 class="wp-block-heading"><?php esc_html_e( '5. Gestione Cookie (Architettura Privacy Native)', 'cinephile' ); ?></h3>
			<p class="wp-block-paragraph">
				<?php esc_html_e( 'Questo sito adotta una rigorosa politica di minimizzazione della raccolta dati e NON fa uso di cookie di profilazione pubblicitaria, né di tracciamento comportamentale o pixel di conversione di terze parti.', 'cinephile' ); ?>
			</p>
			<ul class="wp-block-list">
				<li><strong><?php esc_html_e( 'Cookie tecnici essenziali di WordPress:', 'cinephile' ); ?></strong> <?php esc_html_e( 'Vengono utilizzati esclusivamente cookie tecnici di sessione generati nativamente dalla piattaforma WordPress per consentire il funzionamento sicuro del sito e la corretta visualizzazione delle pagine. Non memorizzano informazioni personali permanenti e scadono alla chiusura della sessione del browser.', 'cinephile' ); ?></li>
				<li><strong><?php esc_html_e( 'Esenzione da Cookie Banner preventivo:', 'cinephile' ); ?></strong> <?php esc_html_e( 'In conformità alle Linee Guida del Garante per la Protezione dei Dati Personali (Provvedimento del 10 giugno 2021) e all\'art. 122 del Codice Privacy (D.Lgs. 196/2003 s.m.i.), per l\'installazione di soli cookie tecnici e di sessione non è richiesto il consenso preventivo dell\'utente tramite banner o popup invasivi.', 'cinephile' ); ?></li>
				<li><strong><?php esc_html_e( 'Font tipografici locali (Zero CDN terze):', 'cinephile' ); ?></strong> <?php esc_html_e( 'I caratteri tipografici sono ospitati al 100% sul server del sito. Nessun dato di navigazione o indirizzo IP viene condiviso con Google Fonts o server esterni.', 'cinephile' ); ?></li>
				<li><strong><?php esc_html_e( 'Contenuti multimediali esterni e Video YouTube (Modalità Due-Clic GDPR):', 'cinephile' ); ?></strong> <?php esc_html_e( 'Gli eventuali trailer e video di YouTube incorporati negli articoli adottano la modalità "Doppio Clic" (Two-Click Solution). Al caricamento della pagina non viene effettuata alcuna connessione ai server di Google né installato alcun cookie. Solo nel momento in cui l\'utente clicca volontariamente sul pulsante di riproduzione (consenso granulare contestuale), viene stabilito il collegamento con la piattaforma YouTube tramite il dominio a protezione avanzata youtube-nocookie.com, preservando l\'esenzione del sito dall\'obbligo di banner cookie preventivi.', 'cinephile' ); ?></li>
			</ul>
		</section>

		<?php if ( $comments_enabled ) : ?>
		<section class="privacy-section">
			<h3 class="wp-block-heading"><?php esc_html_e( '6. Sistema Commenti agli Articoli e Moderazione (Attivo)', 'cinephile' ); ?></h3>
			<p class="wp-block-paragraph">
				<?php esc_html_e( 'Sul presente sito web è attiva la facoltà per i visitatori di commentare gli articoli ed interagire con i contenuti editoriali. L\'invio di un commento costituisce un\'azione puramente volontaria e facoltativa.', 'cinephile' ); ?>
			</p>
			<ul class="wp-block-list">
				<li><strong><?php esc_html_e( 'Dati Raccolti:', 'cinephile' ); ?></strong> <?php esc_html_e( 'Nome (o pseudonimo/nickname scelto dall\'utente), Indirizzo Email e Testo del commento inseriti nel modulo, nonché Indirizzo IP e identificativo del browser (User Agent) rilevati automaticamente dal server WordPress al momento dell\'invio.', 'cinephile' ); ?></li>
				<li><strong><?php esc_html_e( 'Visibilità Pubblica vs Dati Riservati:', 'cinephile' ); ?></strong> <?php esc_html_e( 'Il Nome/Pseudonimo e il Testo del commento sono resi pubblici sul sito web e visibili a chiunque legga l\'articolo. L\'Indirizzo Email e l\'Indirizzo IP NON vengono mai pubblicati sul sito, non sono visibili agli altri lettori né ceduti a soggetti terzi: rimangono archiviati nel database in area ad accesso riservato, consultabili unicamente dal Titolare del trattamento per finalità di moderazione tecnica e sicurezza.', 'cinephile' ); ?></li>
				<li><strong><?php esc_html_e( 'Basi Giuridiche del Trattamento:', 'cinephile' ); ?></strong> <?php esc_html_e( 'Per la pubblicazione del commento e del nome: il Consenso esplicito dell\'interessato (Art. 6, par. 1, lett. a del GDPR), manifestato inequivocabilmente con l\'azione positiva di invio del form. Per la memorizzazione dell\'indirizzo IP e dell\'email nel database di moderazione: il Legittimo Interesse del Titolare alla prevenzione di attacchi o spam (flood) e all\'eventuale accertamento di responsabilità in caso di commenti ingiuriosi, diffamatori, denigratori o penalmente rilevanti (Art. 6, par. 1, lett. f del GDPR).', 'cinephile' ); ?></li>
				<li><strong><?php esc_html_e( 'Tempi di Conservazione e Diritto alla Cancellazione (Art. 17 GDPR):', 'cinephile' ); ?></strong> <?php esc_html_e( 'I commenti rimangono pubblicati per l\'intera durata di permanenza online dell\'articolo associato. L\'utente che ha pubblicato un commento può in ogni momento revocare il consenso ed esercitare il diritto all\'oblio (cancellazione o anonimizzazione integrale del messaggio) inviando una richiesta via email al Titolare del trattamento.', 'cinephile' ); ?></li>
				<li><strong><?php esc_html_e( 'Assenza di Cookie di Profilazione:', 'cinephile' ); ?></strong> <?php esc_html_e( 'Il sistema di commenti non impiega cookie di profilazione o tracciamento pubblicitario. Eventuali dati tecnici di compilazione rimangono strettamente limitati alla sessione locale dell\'utente.', 'cinephile' ); ?></li>
			</ul>
		</section>
		<?php endif; ?>

		<section class="privacy-section">
			<h3 class="wp-block-heading"><?php printf( esc_html__( '%d. Modulo Contatti e Protezione Anti-Spam Temporanea', 'cinephile' ), (int) $sec_contact ); ?></h3>
			<p class="wp-block-paragraph">
				<?php esc_html_e( 'I dati inviati volontariamente compilando il modulo contatti (Nome, Indirizzo Email, Oggetto, Messaggio) vengono impiegati esclusivamente per evadere la richiesta dell\'utente.', 'cinephile' ); ?>
			</p>
			<ul class="wp-block-list">
				<li><strong><?php esc_html_e( 'Base Giuridica:', 'cinephile' ); ?></strong> <?php esc_html_e( 'Esecuzione di misure precontrattuali o riscontro a una specifica richiesta formulata dall\'interessato (Art. 6, par. 1, lett. b del GDPR). Il conferimento dei dati contrassegnati con asterisco è facoltativo, ma l\'eventuale rifiuto rende tecnicamente impossibile per il Titolare rispondere al messaggio.', 'cinephile' ); ?></li>
				<li><strong><?php esc_html_e( 'Protezione Anti-Spam e Rate Limiting (15 minuti):', 'cinephile' ); ?></strong> <?php esc_html_e( 'Per proteggere l\'infrastruttura di posta e il server da attacchi automatizzati e invii ripetuti di spam (flood), al momento dell\'invio riuscito l\'indirizzo IP viene memorizzato in una tabella cache temporanea e protetta (WordPress Transient API) per un massimo di 15 minuti, trascorsi i quali viene eliminato in modo automatico ed irreversibile. Base giuridica: Legittimo interesse alla sicurezza informatica (Art. 6, par. 1, lett. f del GDPR).', 'cinephile' ); ?></li>
				<li><strong><?php esc_html_e( 'Tempi di conservazione del messaggio:', 'cinephile' ); ?></strong> <?php esc_html_e( 'I dati del messaggio rimangono nella casella di posta per il solo tempo necessario a completare la corrispondenza con il mittente e non vengono inseriti in alcuna newsletter o lista di marketing senza esplicito e separato consenso.', 'cinephile' ); ?></li>
			</ul>
		</section>

		<section class="privacy-section">
			<h3 class="wp-block-heading"><?php printf( esc_html__( '%d. Diritti dell\'Interessato (Artt. 15-22 GDPR)', 'cinephile' ), (int) $sec_rights ); ?></h3>
			<p class="wp-block-paragraph">
				<?php
				printf(
					/* translators: %s: Email del titolare */
					esc_html__( 'In qualità di interessato, l\'utente può esercitare in qualsiasi momento i diritti previsti dagli articoli 15 e seguenti del Regolamento UE 2016/679: diritto di accesso ai dati personali, rettifica, cancellazione (diritto all\'oblio), limitazione del trattamento, portabilità e opposizione al trattamento per motivi legittimi. Per qualsiasi richiesta è possibile scrivere al Titolare all\'indirizzo: %s.', 'cinephile' ),
					'<a href="mailto:' . esc_attr( $safe_email ) . '"><strong>' . wp_kses_post( $safe_email ) . '</strong></a>'
				);
				?>
			</p>
			<p class="wp-block-paragraph">
				<?php esc_html_e( 'L\'interessato ha inoltre il diritto di proporre formale reclamo all\'Autorità Garante per la Protezione dei Dati Personali (Piazza Venezia 11, 00187 Roma, protocollo@gpdp.it - www.garanteprivacy.it) qualora ritenga che il trattamento dei dati violi la normativa vigente.', 'cinephile' ); ?>
			</p>
		</section>

		<section class="privacy-section">
			<h3 class="wp-block-heading"><?php printf( esc_html__( '%d. Modifiche e Aggiornamenti', 'cinephile' ), (int) $sec_updates ); ?></h3>
			<p class="wp-block-paragraph">
				<?php esc_html_e( 'La presente informativa è aggiornata alla data corrente e rispecchia fedelmente le funzionalità tecniche del sito. Eventuali future modifiche normative o integrazioni ai servizi offerti saranno tempestivamente pubblicate su questa pagina.', 'cinephile' ); ?>
			</p>
		</section>

	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'cinephile_privacy_gdpr', 'cinephile_privacy_gdpr_shortcode' );
// Alias retrocompatibile trasparente per installazioni con pagine create in precedenza
add_shortcode( 'cinemaecritica_privacy_gdpr', 'cinephile_privacy_gdpr_shortcode' );

/* ==========================================================================
   2. CREAZIONE AUTOMATICA DELLE PAGINE ALL'ATTIVAZIONE DEL TEMA
   ========================================================================== */

/**
 * Crea o aggiorna le pagine istituzionali all'attivazione del tema o al setup.
 */
function cinephile_create_default_pages() {
	// Calcola dinamicamente se la testata ha uno o più autori per il titolo di Chi siamo
	$authors = get_users( array(
		'capability' => 'edit_posts',
		'fields'     => 'ID',
	) );

	$about_title = ( count( $authors ) > 1 ) ? __( 'Chi siamo', 'cinephile' ) : __( 'Chi sono', 'cinephile' );

	$pages_config = array(
		'about'    => array(
			'slug'     => 'chi-siamo',
			'title'    => $about_title,
			'template' => 'page-chi-siamo.php',
			'content'  => "<!-- wp:paragraph -->\n<p>" . __( 'Benvenuti nella nostra rivista digitale. Scopri il nostro manifesto e la nostra visione critica.', 'cinephile' ) . "</p>\n<!-- /wp:paragraph -->",
			'option'   => 'cinephile_page_about_id',
		),
		'contacts' => array(
			'slug'     => 'contatti',
			'title'    => __( 'Contatti', 'cinephile' ),
			'template' => 'page-contatti.php',
			'content'  => "<!-- wp:paragraph -->\n<p>" . __( 'Compila il modulo per metterti in contatto con la nostra redazione.', 'cinephile' ) . "</p>\n<!-- /wp:paragraph -->",
			'option'   => 'cinephile_page_contacts_id',
		),
		'privacy'  => array(
			'slug'     => 'privacy-e-cookie-policy',
			'title'    => __( 'Privacy e Cookie Policy', 'cinephile' ),
			'template' => '',
			'content'  => "<!-- wp:paragraph -->\n<p>" . __( 'Informativa sul trattamento dei dati personali ai sensi del Regolamento UE 2016/679 (GDPR).', 'cinephile' ) . "</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:shortcode -->\n[cinephile_privacy_gdpr]\n<!-- /wp:shortcode -->",
			'option'   => 'cinephile_page_privacy_id',
		),
	);

	foreach ( $pages_config as $key => $data ) {
		$saved_id = get_option( $data['option'] );
		if ( ! $saved_id ) {
			$legacy_option = str_replace( 'cinephile_page_', 'cinemaecritica_page_', $data['option'] );
			$saved_id      = get_option( $legacy_option );
			if ( $saved_id ) {
				update_option( $data['option'], $saved_id );
			}
		}
		$existing_page = get_page_by_path( $data['slug'] );

		// Se la pagina non esiste né in opzione né tra i post pubblicati, la crea
		if ( ! $saved_id && ! $existing_page ) {
			$page_id = wp_insert_post( array(
				'post_title'     => sanitize_text_field( $data['title'] ),
				'post_content'   => $data['content'],
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'post_name'      => $data['slug'],
				'comment_status' => 'closed',
			) );

			if ( ! is_wp_error( $page_id ) && $page_id > 0 ) {
				update_option( $data['option'], $page_id );

				// Assegna il template grafico se definito
				if ( ! empty( $data['template'] ) ) {
					update_post_meta( $page_id, '_wp_page_template', $data['template'] );
				}

				// Se è la pagina privacy, aggiorna anche l'opzione nativa core di WordPress
				if ( 'privacy' === $key ) {
					update_option( 'wp_page_for_privacy_policy', $page_id );
				}
			}
		} elseif ( $existing_page ) {
			// Se la pagina esiste già, assicuriamoci che l'ID e il template siano salvati
			update_option( $data['option'], $existing_page->ID );

			if ( ! empty( $data['template'] ) ) {
				$current_template = get_post_meta( $existing_page->ID, '_wp_page_template', true );
				if ( empty( $current_template ) || 'default' === $current_template ) {
					update_post_meta( $existing_page->ID, '_wp_page_template', $data['template'] );
				}
			}

			if ( 'privacy' === $key ) {
				$current_wp_privacy = get_option( 'wp_page_for_privacy_policy' );
				if ( empty( $current_wp_privacy ) ) {
					update_option( 'wp_page_for_privacy_policy', $existing_page->ID );
				}
			}
		}
	}
}
add_action( 'after_switch_theme', 'cinephile_create_default_pages' );

/**
 * Controllo di garanzia: se le pagine essenziali mancano ancora (es. tema già attivo o prima installazione),
 * le crea una sola volta al primo caricamento utile.
 */
function cinephile_ensure_default_pages() {
	$contacts_id = get_option( 'cinephile_page_contacts_id' );
	$privacy_id  = get_option( 'cinephile_page_privacy_id' );

	if ( ! $contacts_id || ! $privacy_id ) {
		cinephile_create_default_pages();
	}
}
add_action( 'init', 'cinephile_ensure_default_pages' );

/* ==========================================================================
   3. FILTRI TITOLO DINAMICO PER "CHI SIAMO" / "CHI SONO"
   ========================================================================== */

/**
 * Filtro per aggiornare dinamicamente il titolo della pagina 'Chi siamo' / 'Chi sono' nel Frontend.
 */
function cinephile_dynamic_about_title( $title, $post_id = null ) {
	if ( is_admin() || ! in_the_loop() || ! $post_id ) {
		return $title;
	}

	$about_page_id = (int) get_option( 'cinephile_page_about_id' );

	if ( (int) $post_id === $about_page_id ) {
		$authors = get_users( array(
			'capability' => 'edit_posts',
			'fields'     => 'ID',
		) );

		return ( count( $authors ) > 1 ) ? __( 'Chi siamo', 'cinephile' ) : __( 'Chi sono', 'cinephile' );
	}

	return $title;
}
add_filter( 'the_title', 'cinephile_dynamic_about_title', 10, 2 );
