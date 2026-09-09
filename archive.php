<?php
/**
 * Template Archivio Generale (Date, Autore)
 *
 * Visualizzazione cronologica e per autore degli articoli e saggi critici.
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

$read_more = get_theme_mod( 'archive_read_more_text', __( 'Leggi articolo', 'cinephile' ) );
?>

<main id="main-content" class="site-main content-container archive-main-container">
    <header class="archive-header-clean">
        <h1 class="archive-title-clean">
            <?php echo wp_kses_post( get_the_archive_title() ); ?>
        </h1>
        <?php echo wp_kses_post( get_the_archive_description( '<div class="archive-description-clean">', '</div>' ) ); ?>
    </header>

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
                        <h2 class="archive-card-title">
                            <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                        </h2>
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
        <p class="no-posts-found"><?php esc_html_e( 'Nessun articolo trovato per questo archivio.', 'cinephile' ); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
