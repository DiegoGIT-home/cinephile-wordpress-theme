<?php
/**
 * Template Pagina Contatti & Relazioni con il Pubblico
 *
 * Template Name: Contatti
 * Description: Scheda referente, recapiti diretti e modulo con protezione anti-spam.
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

$form_feedback = function_exists( 'cinephile_process_contact_form' ) ? cinephile_process_contact_form() : '';

get_header();

// 1. Recupero parametri dal Customizer (con fallback dinamici puliti)
$site_name       = get_bloginfo( 'name' );
$admin_email     = get_option( 'admin_email' );

$kicker          = get_theme_mod( 'contact_hero_kicker', __( 'PARLA CON LA REDAZIONE', 'cinephile' ) );
$hero_intro      = get_theme_mod( 'contact_hero_intro', '' );

$author_name     = get_theme_mod( 'contact_author_name', ! empty( $site_name ) ? $site_name : __( 'La Redazione', 'cinephile' ) );
$author_role     = get_theme_mod( 'contact_author_role', __( 'Fondatore & Redazione', 'cinephile' ) );
$author_desc     = get_theme_mod( 'contact_author_desc', __( 'Gestione dei contenuti, cura editoriale e contatti con la stampa e il pubblico.', 'cinephile' ) );
$author_avatar   = get_theme_mod( 'contact_author_avatar', '' );

// Recapito 1 (Email)
$card1_title     = get_theme_mod( 'contact_card1_title', __( 'Email Diretta', 'cinephile' ) );
$card1_email     = get_theme_mod( 'contact_card1_email', $admin_email );
$card1_icon      = get_theme_mod( 'contact_card1_icon', 'email' );

// Recapito 2 (Secondario opzionale)
$card2_enable    = (bool) get_theme_mod( 'contact_card2_enable', false );
$card2_title     = get_theme_mod( 'contact_card2_title', __( 'Telefono / WhatsApp', 'cinephile' ) );
$card2_text      = get_theme_mod( 'contact_card2_text', '' );
$card2_icon      = get_theme_mod( 'contact_card2_icon', 'phone' );

// Recapito 3 (Sede/Altro opzionale)
$card3_enable    = (bool) get_theme_mod( 'contact_card3_enable', false );
$card3_title     = get_theme_mod( 'contact_card3_title', __( 'Sede Operativa', 'cinephile' ) );
$card3_text      = get_theme_mod( 'contact_card3_text', '' );
$card3_icon      = get_theme_mod( 'contact_card3_icon', 'location' );

// Form & Privacy Notice
$button_label    = get_theme_mod( 'contact_button_label', __( 'Invia Messaggio', 'cinephile' ) );
$privacy_notice  = get_theme_mod( 'contact_privacy_notice', __( "I dati inseriti e l'indirizzo IP di connessione vengono temporaneamente elaborati per un massimo di 15 minuti al solo fine di proteggere il sistema da invii spam automatizzati.", 'cinephile' ) );
?>

<main id="main-content" class="site-main content-container page-custom-template">

	<!-- HERO SECTION -->
	<section class="page-hero-section">
		<?php if ( ! empty( $kicker ) ) : ?>
			<span class="hero-kicker"><?php echo esc_html( $kicker ); ?></span>
		<?php endif; ?>

		<h1 class="page-title"><?php echo esc_html( get_the_title() ); ?></h1>

		<div class="page-intro">
			<?php if ( ! empty( $hero_intro ) ) : ?>
				<?php echo wp_kses_post( wpautop( $hero_intro ) ); ?>
			<?php else : ?>
				<p>
					<?php
					printf(
						/* translators: 1: Nome sito, 2: Nome autore/redazione */
						esc_html__( '%1$s è curato da %2$s. Hai un feedback, un suggerimento o una proposta di collaborazione? Scrivi direttamente.', 'cinephile' ),
						'<strong>' . esc_html( $site_name ) . '</strong>',
						'<strong>' . esc_html( $author_name ) . '</strong>'
					);
					?>
				</p>
			<?php endif; ?>
		</div>
	</section>

	<?php
	// Contenuto personalizzato inserito dall'utente nell'editor WordPress (se presente)
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			$page_content = get_the_content();
			// Mostra solo se non è un paragrafo vuoto o di default
			if ( ! empty( trim( strip_tags( $page_content ) ) ) && false === strpos( $page_content, 'Compila il modulo per metterti in contatto con la nostra redazione' ) ) :
				?>
				<div class="page-editor-content" style="margin-bottom: 2rem;">
					<?php the_content(); ?>
				</div>
				<?php
			endif;
		endwhile;
	endif;
	?>

	<!-- LAYOUT A DUE COLONNE: CARDS INFORMATIVE + FORM DI INVIO -->
	<div class="contact-layout-grid">

		<!-- COLONNA SINISTRA: SCHEDE PROFILO E RECAPITI -->
		<div class="contact-info-cards">

			<!-- SCHEDA PROFILO REFERENTE / REDAZIONE -->
			<div class="author-contact-profile">
				<?php if ( ! empty( $author_avatar ) ) : ?>
					<img src="<?php echo esc_url( $author_avatar ); ?>" alt="<?php echo esc_attr( $author_name ); ?>" class="profile-avatar" loading="lazy" decoding="async">
				<?php elseif ( ! empty( $card1_email ) ) : ?>
					<?php echo wp_kses_post( get_avatar( $card1_email, 100, '', esc_attr( $author_name ), array( 'class' => 'profile-avatar' ) ) ); ?>
				<?php endif; ?>
				<h3><?php echo esc_html( $author_name ); ?></h3>
				<?php if ( ! empty( $author_role ) ) : ?>
					<span class="profile-role"><?php echo esc_html( $author_role ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $author_desc ) ) : ?>
					<p><?php echo esc_html( $author_desc ); ?></p>
				<?php endif; ?>
			</div>

			<!-- RECAPITO 1: EMAIL PRINCIPALE -->
			<div class="contact-card">
				<div class="card-icon">
					<?php
					if ( function_exists( 'cinephile_render_contact_icon' ) ) {
						echo cinephile_render_contact_icon( $card1_icon, 22 );
					}
					?>
				</div>
				<div class="card-text">
					<h4><?php echo esc_html( $card1_title ); ?></h4>
					<?php
					if ( function_exists( 'cinephile_render_protected_email' ) ) {
						echo cinephile_render_protected_email( $card1_email );
					} else {
						$email_sicura = antispambot( $card1_email );
						echo '<a href="mailto:' . esc_attr( $email_sicura ) . '">' . wp_kses_post( $email_sicura ) . '</a>';
					}
					?>
				</div>
			</div>

			<!-- RECAPITO 2: SECONDARIO OPZIONALE (Telefono / Orari / Chat) -->
			<?php if ( $card2_enable && ! empty( $card2_text ) ) : ?>
				<div class="contact-card">
					<div class="card-icon">
						<?php
						if ( function_exists( 'cinephile_render_contact_icon' ) ) {
							echo cinephile_render_contact_icon( $card2_icon, 22 );
						}
						?>
					</div>
					<div class="card-text">
						<h4><?php echo esc_html( $card2_title ); ?></h4>
						<span><?php echo esc_html( $card2_text ); ?></span>
					</div>
				</div>
			<?php endif; ?>

			<!-- RECAPITO 3: SEDE / COLLABORAZIONI OPZIONALE -->
			<?php if ( $card3_enable && ! empty( $card3_text ) ) : ?>
				<div class="contact-card">
					<div class="card-icon">
						<?php
						if ( function_exists( 'cinephile_render_contact_icon' ) ) {
							echo cinephile_render_contact_icon( $card3_icon, 22 );
						}
						?>
					</div>
					<div class="card-text">
						<h4><?php echo esc_html( $card3_title ); ?></h4>
						<span><?php echo esc_html( $card3_text ); ?></span>
					</div>
				</div>
			<?php endif; ?>

			<!-- AVVISO PRIVACY & RATE LIMITING SPAM -->
			<?php if ( ! empty( $privacy_notice ) ) : ?>
				<br>
				<p class="form-privacy-notice">
					ℹ️ <?php echo esc_html( $privacy_notice ); ?>
				</p>
			<?php endif; ?>

		</div>

		<!-- COLONNA DESTRA: MODULO DI INVIO SICURO -->
		<div class="contact-form-wrapper">
			<?php if ( ! empty( $form_feedback ) ) echo wp_kses_post( $form_feedback ); ?>

			<form class="custom-contact-form" action="" method="post">
				<?php wp_nonce_field( 'submit_contact_form_action', 'contact_form_nonce_field' ); ?>

				<input type="hidden" name="form_time_check" value="<?php echo esc_attr( time() ); ?>">

				<!-- Honeypot anti-bot nascosto via CSS -->
				<div class="hp-hidden" aria-hidden="true">
					<input type="text" name="check_real_user_hp" id="check_real_user_hp" tabindex="-1" autocomplete="new-password" value="">
				</div>

				<div class="form-group">
					<label for="nome"><?php esc_html_e( 'Il tuo nome *', 'cinephile' ); ?></label>
					<input type="text" id="nome" name="nome" required placeholder="<?php echo esc_attr__( 'Es. Mario Rossi', 'cinephile' ); ?>">
				</div>

				<div class="form-group">
					<label for="email"><?php esc_html_e( 'Indirizzo Email *', 'cinephile' ); ?></label>
					<input type="email" id="email" name="email" required placeholder="<?php echo esc_attr__( 'nome@dominio.it', 'cinephile' ); ?>">
				</div>

				<div class="form-group">
					<label for="oggetto"><?php esc_html_e( 'Oggetto', 'cinephile' ); ?></label>
					<input type="text" id="oggetto" name="oggetto" placeholder="<?php echo esc_attr__( 'Richiesta info, collaborazione, press...', 'cinephile' ); ?>">
				</div>

				<div class="form-group">
					<label for="messaggio"><?php esc_html_e( 'Messaggio *', 'cinephile' ); ?></label>
					<textarea id="messaggio" name="messaggio" rows="5" required placeholder="<?php echo esc_attr__( 'Scrivi qui il tuo messaggio...', 'cinephile' ); ?>"></textarea>
				</div>

				<button type="submit" class="submit-btn"><?php echo esc_html( $button_label ); ?></button>
			</form>
		</div>

	</div>

</main>

<?php get_footer(); ?>
