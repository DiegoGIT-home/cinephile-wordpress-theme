<?php
/**
 * Template Archivio Autore (Scheda Critico Cinematografico)
 *
 * Visualizzazione biografica del critico/redattore e catalogo delle recensioni pubblicate.
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

$author_obj  = get_queried_object();
$author_id   = $author_obj ? $author_obj->ID : get_the_author_meta( 'ID' );
$author_name = $author_obj ? $author_obj->display_name : get_the_author();
$author_bio  = get_the_author_meta( 'description', $author_id );
$post_count  = count_user_posts( $author_id, 'post', true );
$read_more   = get_theme_mod( 'archive_read_more_text', __( 'Leggi articolo', 'cinephile' ) );

// Recupera ruolo utente formattato
$author_user = get_userdata( $author_id );
$role_name   = '';
if ( $author_user && ! empty( $author_user->roles ) ) {
	$role_name = translate_user_role( wp_roles()->roles[ $author_user->roles[0] ]['name'] );
}
?>

<main class="site-main content-container author-main-container">
	
	<!-- SCHEDA BIOGRAFICA DEL CRITICO CINEMATOGRAFICO -->
	<header class="author-profile-header">
		<div class="author-profile-card">
			<div class="author-profile-avatar-wrap">
				<?php echo wp_kses_post( get_avatar( $author_id, 120, '', esc_attr( $author_name ), array( 'class' => 'author-profile-avatar' ) ) ); ?>
			</div>
			<div class="author-profile-info">
				<div class="author-profile-top">
					<span class="author-role-badge">✍️ <?php echo esc_html( ! empty( $role_name ) ? $role_name : __( 'Critico & Autore', 'cinephile' ) ); ?></span>
					<span class="author-count-badge">🎬 <?php printf( esc_html( _n( '%s Recensione Pubblicata', '%s Recensioni Pubblicate', $post_count, 'cinephile' ) ), number_format_i18n( $post_count ) ); ?></span>
				</div>
				<h1 class="author-profile-name"><?php echo esc_html( $author_name ); ?></h1>
				<?php if ( ! empty( $author_bio ) ) : ?>
					<p class="author-profile-bio"><?php echo esc_html( $author_bio ); ?></p>
				<?php else : ?>
					<p class="author-profile-bio author-bio-placeholder"><?php esc_html_e( 'Redattore e critico per la rivista.', 'cinephile' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</header>

	<!-- SEZIONE RECENSIONI E ARTICOLI DEL CRITICO -->
	<section class="author-articles-section">
		<h2 class="author-section-heading">
			<?php
			/* translators: %s: Nome autore */
			printf( esc_html__( 'Tutti gli articoli a cura di %s', 'cinephile' ), esc_html( $author_name ) );
			?>
		</h2>

		<?php if ( have_posts() ) : ?>
			<div class="articles-grid-clean">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'archive-card-clean' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php echo esc_url( get_permalink() ); ?>" class="archive-thumb-link">
								<?php the_post_thumbnail( 'medium_large', array( 'class' => 'archive-thumb-img' ) ); ?>
							</a>
						<?php endif; ?>

						<div class="archive-body-clean">
							<span class="entry-meta"><?php echo wp_kses_post( get_the_category_list( ', ' ) ); ?></span>
							<h3 class="archive-card-title">
								<a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
							</h3>
							<div class="archive-meta-clean">
								<?php if ( function_exists( 'cinephile_tempo_lettura' ) ) : ?>
									⏱️ <?php echo esc_html( cinephile_tempo_lettura() ); ?> min |
								<?php endif; ?>
								📅 <?php echo esc_html( get_the_date( 'j F Y' ) ); ?>
							</div>
							<div class="archive-excerpt-clean">
								<?php echo wp_kses_post( get_the_excerpt() ); ?>
							</div>
							<a href="<?php echo esc_url( get_permalink() ); ?>" class="archive-read-more"><?php echo esc_html( $read_more ); ?> &rarr;</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<div class="pagination-clean">
				<?php
				$pagination_args = array(
					'mid_size'  => 2,
					'prev_text' => '&larr; ' . esc_html__( 'Precedenti', 'cinephile' ),
					'next_text' => esc_html__( 'Successivi', 'cinephile' ) . ' &rarr;',
				);
				echo wp_kses_post( get_the_posts_pagination( $pagination_args ) );
				?>
			</div>
		<?php else : ?>
			<p class="no-posts-found"><?php esc_html_e( 'Nessun articolo pubblicato da questo autore.', 'cinephile' ); ?></p>
		<?php endif; ?>
	</section>

</main>

<?php get_footer(); ?>
