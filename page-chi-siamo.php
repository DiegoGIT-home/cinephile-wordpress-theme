<?php
/**
 * Template Pagina Chi Siamo / Manifesto Editoriale
 *
 * Template Name: Chi Siamo
 * Description: Presentazione della linea editoriale, dei 3 pilastri di valore e del comitato redazionale.
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

get_header();

$kicker      = get_theme_mod( 'about_hero_kicker', __( 'IL PROGETTO EDITORIALE', 'cinephile' ) );
$intro_text  = get_theme_mod( 'about_hero_intro', sprintf( __( '%s è una rivista digitale indipendente. Nasce per offrire uno sguardo analitico, slegato da logiche commerciali, sul cinema di oggi, di ieri e sui principali festival.', 'cinephile' ), '<strong>' . esc_html( get_bloginfo( 'name' ) ) . '</strong>' ) );
$cover_img   = get_theme_mod( 'about_cover_image', '' );
if ( empty( $cover_img ) && has_post_thumbnail() ) {
	$cover_img = get_the_post_thumbnail_url( get_the_ID(), 'full' );
}
if ( empty( $cover_img ) ) {
	$cover_img = get_theme_file_uri( '/assets/img/about-hero-banner.webp' );
}

// Pilastri
$pillar1_title  = get_theme_mod( 'about_pillar1_title', __( 'Indipendenza', 'cinephile' ) );
$pillar1_desc   = get_theme_mod( 'about_pillar1_desc', __( 'Nessun condizionamento commerciale. Analisi critiche dirette, sincere e imparziali.', 'cinephile' ) );
$pillar1_icon   = get_theme_mod( 'about_pillar1_icon', 'compass' );
$pillar1_custom = get_theme_mod( 'about_pillar1_custom_icon', '' );

$pillar2_title  = get_theme_mod( 'about_pillar2_title', __( 'Copertura Festival', 'cinephile' ) );
$pillar2_desc   = get_theme_mod( 'about_pillar2_desc', __( 'Presenza costante nelle principali rassegne cinematografiche nazionali ed internazionali.', 'cinephile' ) );
$pillar2_icon   = get_theme_mod( 'about_pillar2_icon', 'film' );
$pillar2_custom = get_theme_mod( 'about_pillar2_custom_icon', '' );

$pillar3_title  = get_theme_mod( 'about_pillar3_title', __( 'Approfondimento', 'cinephile' ) );
$pillar3_desc   = get_theme_mod( 'about_pillar3_desc', __( 'Saggi, monografie e percorsi tematici pensati per durare nel tempo.', 'cinephile' ) );
$pillar3_icon   = get_theme_mod( 'about_pillar3_icon', 'book' );
$pillar3_custom = get_theme_mod( 'about_pillar3_custom_icon', '' );
?>

<main id="main-content" class="site-main content-container page-custom-template">

	<section class="page-hero-section">
		<?php if ( ! empty( $kicker ) ) : ?>
			<span class="hero-kicker"><?php echo esc_html( $kicker ); ?></span>
		<?php endif; ?>
		<h1 class="page-title"><?php echo esc_html( get_the_title() ); ?></h1>
		<div class="page-intro">
			<?php echo wp_kses_post( wpautop( $intro_text ) ); ?>
		</div>
	</section>

	<?php if ( ! empty( $cover_img ) ) : ?>
		<div class="page-featured-banner">
			<img src="<?php echo esc_url( $cover_img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" width="1200" height="320" loading="lazy" decoding="async">
		</div>
	<?php endif; ?>

	<section class="values-grid-section">
		<h2 class="section-block-title"><?php esc_html_e( 'I Nostri Pilastri', 'cinephile' ); ?></h2>
		<div class="values-grid">
			<div class="value-card">
				<div class="value-icon">
					<?php echo cinephile_render_pillar_icon( $pillar1_icon, $pillar1_custom, 28, $pillar1_title ); ?>
				</div>
				<h3><?php echo esc_html( $pillar1_title ); ?></h3>
				<p><?php echo esc_html( $pillar1_desc ); ?></p>
			</div>

			<div class="value-card">
				<div class="value-icon">
					<?php echo cinephile_render_pillar_icon( $pillar2_icon, $pillar2_custom, 28, $pillar2_title ); ?>
				</div>
				<h3><?php echo esc_html( $pillar2_title ); ?></h3>
				<p><?php echo esc_html( $pillar2_desc ); ?></p>
			</div>

			<div class="value-card">
				<div class="value-icon">
					<?php echo cinephile_render_pillar_icon( $pillar3_icon, $pillar3_custom, 28, $pillar3_title ); ?>
				</div>
				<h3><?php echo esc_html( $pillar3_title ); ?></h3>
				<p><?php echo esc_html( $pillar3_desc ); ?></p>
			</div>
		</div>
	</section>

	<!-- SCHEDA AUTORE / GRIGLIA MULTI-AUTORE DINAMICA -->
	<section class="team-section">
		<?php
		$authors = function_exists( 'cinephile_get_about_team_users' ) ? cinephile_get_about_team_users() : get_users( array(
			'role__in' => array( 'administrator', 'editor', 'author' ),
			'orderby'  => 'post_count',
			'order'    => 'DESC',
		) );

		$author_count  = count( $authors );
		$section_title = ( $author_count > 1 ) ? __( 'Gli Autori', 'cinephile' ) : __( "L'Autore", 'cinephile' );
		?>
		<h2 class="section-block-title"><?php echo esc_html( $section_title ); ?></h2>

		<?php if ( $author_count > 1 ) : ?>
			<div class="authors-grid">
				<?php foreach ( $authors as $user ) : ?>
					<div class="author-card-single">
						<?php echo wp_kses_post( get_avatar( $user->ID, 100, '', esc_attr( $user->display_name ), array( 'class' => 'author-avatar' ) ) ); ?>
						<h3 class="author-name"><?php echo esc_html( $user->display_name ); ?></h3>
						<span class="author-role"><?php echo esc_html( translate_user_role( $user->roles[0] ) ); ?></span>
						<p class="author-bio"><?php echo esc_html( get_the_author_meta( 'description', $user->ID ) ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else :
			$single_author_name = get_theme_mod( 'about_author_name', get_bloginfo( 'name' ) );
			$single_author_role = get_theme_mod( 'about_author_role', __( 'Fondatore & Direttore Editoriale', 'cinephile' ) );
			$single_author_bio  = get_theme_mod( 'about_author_bio', __( 'Curatore del progetto e della linea editoriale.', 'cinephile' ) );
			$single_author_img  = get_theme_mod( 'about_author_avatar', '' );
		?>
			<div class="author-card-single">
				<?php if ( ! empty( $single_author_img ) ) : ?>
					<img src="<?php echo esc_url( $single_author_img ); ?>" alt="<?php echo esc_attr( $single_author_name ); ?>" class="author-avatar" width="100" height="100" loading="lazy" decoding="async">
				<?php else : ?>
					<?php echo wp_kses_post( get_avatar( get_option( 'admin_email' ), 100, '', esc_attr( $single_author_name ), array( 'class' => 'author-avatar' ) ) ); ?>
				<?php endif; ?>
				<h3 class="author-name"><?php echo esc_html( $single_author_name ); ?></h3>
				<span class="author-role"><?php echo esc_html( $single_author_role ); ?></span>
				<p class="author-bio"><?php echo esc_html( $single_author_bio ); ?></p>
			</div>
		<?php endif; ?>
	</section>

</main>

<?php get_footer(); ?>
