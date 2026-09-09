<?php
/**
 * Template Indice Principale (Fallback Core)
 *
 * Template di fallback obbligatorio della gerarchia WordPress per elenchi articoli.
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

$show_thumb  = get_theme_mod( 'show_featured_images', true );
$page_title  = get_theme_mod( 'archive_main_title', __( 'Ultimi Articoli', 'cinephile' ) );
?>

<main id="main-content" class="site-main content-container archive-main-container">

    <header class="archive-header-clean">
        <h1 class="archive-title-clean"><?php echo esc_html( $page_title ); ?></h1>
    </header>

    <?php if ( have_posts() ) : ?>
        <div class="articles-grid-clean evidenza-grid-vertical">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'evidenza-card-vert' ); ?>>

                    <?php if ( $show_thumb && has_post_thumbnail() ) : ?>
                        <div class="evidenza-img-top">
                            <a href="<?php echo esc_url( get_permalink() ); ?>">
                                <?php the_post_thumbnail( 'medium_large' ); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="evidenza-body-vert">
                        <span class="entry-meta"><?php echo wp_kses_post( get_the_category_list( ', ' ) ); ?></span>
                        <h2 class="evidenza-title">
                            <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                        </h2>
                        <div class="evidenza-excerpt">
                            <?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?>
                        </div>
                    </div>

                </article>
            <?php endwhile; ?>
        </div>

        <div class="pagination-clean">
            <?php
            $pagination_args = array(
                'mid_size'  => 2,
                'prev_text' => '&larr; ' . esc_html__( 'Precedenti', 'cinephile' ),
                'next_text' => esc_html__( 'Successivi', 'cinephile' ) . ' &rarr;'
            );
            echo wp_kses_post( get_the_posts_pagination( $pagination_args ) );
            ?>
        </div>

    <?php else : ?>
        <div class="no-results-box">
            <h2 class="no-results-title"><?php esc_html_e( 'Nessun contenuto disponibile.', 'cinephile' ); ?></h2>
            <p class="no-results-subtext"><?php esc_html_e( 'Sembra che non ci siano articoli da mostrare in questa sezione.', 'cinephile' ); ?></p>
        </div>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
