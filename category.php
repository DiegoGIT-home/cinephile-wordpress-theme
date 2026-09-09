<?php
/**
 * Template Archivio Categorie Tematiche
 *
 * Visualizzazione verticale e strutturata degli articoli suddivisi per categoria cinematografica.
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

$default_thumb = get_theme_mod( 'default_fallback_image', '' );
?>

<main id="main-content" class="site-main content-container page-custom-template">

    <header class="page-hero-section">
        <h1 class="page-title"><?php echo esc_html( single_cat_title( '', false ) ); ?></h1>
        <?php if ( category_description() ) : ?>
            <div class="page-intro"><?php echo wp_kses_post( category_description() ); ?></div>
        <?php endif; ?>
    </header>

    <?php if ( have_posts() ) : ?>

        <div class="evidenza-grid-vertical">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'evidenza-card-vert' ); ?>>

                    <?php if ( has_post_thumbnail() || ! empty( $default_thumb ) ) : ?>
                        <div class="evidenza-img-top">
                            <a href="<?php echo esc_url( get_permalink() ); ?>">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'medium_large' ); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url( $default_thumb ); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="evidenza-body-vert">
                        <span class="entry-meta"><?php echo esc_html( get_the_date() ); ?></span>
                        <h2 class="evidenza-title">
                            <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                        </h2>
                        <div class="evidenza-excerpt">
                            <?php echo wp_kses_post( get_the_excerpt() ); ?>
                        </div>
                    </div>

                </article>
            <?php endwhile; ?>
        </div>

        <div class="pagination-wrapper">
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

        <div class="no-results-box">
            <h2 class="no-results-title"><?php esc_html_e( 'Nessun articolo trovato', 'cinephile' ); ?></h2>
            <p class="no-results-subtext"><?php esc_html_e( 'Non ci sono ancora contenuti pubblicati in questa categoria.', 'cinephile' ); ?></p>
        </div>

    <?php endif; ?>

</main>

<?php get_footer(); ?>
