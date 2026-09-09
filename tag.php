<?php
/**
 * Template Archivio Tag (Layout Bento Box)
 *
 * Template Name: Bento Tag Archive
 * Description: Griglia editoriale asimmetrica a gerarchia dinamica (Lead 16:9, Duo e Poster 2:3).
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

global $wp_query;
$total_posts   = $wp_query->found_posts;
$is_first_page = ! is_paged();

$kicker        = get_theme_mod( 'tag_hero_kicker', __( 'DOSSIER TEMATICO', 'cinephile' ) );
$default_thumb = get_theme_mod( 'default_fallback_image', '' );
?>

<main class="site-main content-container tag-bento-container">

    <header class="page-hero-section tag-hero-header">
        <span class="tag-kicker-meta">
            <?php echo esc_html( $kicker ); ?> &bull; <?php echo esc_html( $total_posts ); ?> <?php echo ( 1 === $total_posts ) ? esc_html__( 'ARTICOLO', 'cinephile' ) : esc_html__( 'ARTICOLI', 'cinephile' ); ?>
        </span>
        <h1 class="page-title tag-page-title">
            #<?php echo esc_html( single_tag_title( '', false ) ); ?>
        </h1>
        <div class="tag-description-wrapper">
            <?php if ( tag_description() ) : ?>
                <div class="page-intro tag-description-text">
                    <?php echo wp_kses_post( tag_description() ); ?>
                </div>
            <?php else : ?>
                <p class="page-intro tag-description-text">
                    <?php esc_html_e( 'Tutti gli articoli, i saggi e le analisi critiche dedicati a questo tema.', 'cinephile' ); ?>
                </p>
            <?php endif; ?>
        </div>
    </header>

    <?php if ( have_posts() ) : ?>

        <?php if ( $is_first_page ) : ?>
            <div class="bento-layout-wrapper">

                <?php
                $post_idx    = 0;
                $duo_opened  = false;
                $grid_opened = false;

                while ( have_posts() ) : the_post();
                    $post_idx++;
                    $post_id   = get_the_ID();
                    $voto      = get_post_meta( $post_id, '_film_voto', true );
                    $regista   = get_post_meta( $post_id, '_film_regista', true );
                    $reading_t = function_exists( 'cinephile_tempo_lettura' ) ? cinephile_tempo_lettura() : '3';
                    ?>

                    <?php if ( 1 === $post_idx ) : ?>
                        <section class="bento-lead-section">
                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'bento-card bento-card-lead' ); ?>>
                                <div class="bento-lead-media">
                                    <a href="<?php echo esc_url( get_permalink() ); ?>">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <?php the_post_thumbnail( 'large', array( 'class' => 'bento-img-lead', 'decoding' => 'async' ) ); ?>
                                        <?php elseif ( ! empty( $default_thumb ) ) : ?>
                                            <img src="<?php echo esc_url( $default_thumb ); ?>" alt="<?php the_title_attribute(); ?>" class="bento-img-lead">
                                        <?php endif; ?>
                                    </a>
                                    <?php if ( ! empty( $voto ) ) : ?>
                                        <span class="bento-voto-badge">⭐ <?php echo esc_html( $voto ); ?>/5</span>
                                    <?php endif; ?>
                                </div>
                                <div class="bento-lead-content">
                                    <div class="bento-meta-top">
                                        <span class="entry-meta-cat"><?php echo wp_kses_post( get_the_category_list( ', ' ) ); ?></span>
                                        <span class="entry-meta-date">📅 <?php echo esc_html( get_the_date( 'j F Y' ) ); ?></span>
                                    </div>
                                    <h2 class="bento-lead-title">
                                        <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                                    </h2>
                                    <?php if ( ! empty( $regista ) ) : ?>
                                        <p class="bento-director">🎬 <?php esc_html_e( 'Regia di', 'cinephile' ); ?> <strong><?php echo esc_html( $regista ); ?></strong></p>
                                    <?php endif; ?>
                                    <div class="bento-lead-excerpt">
                                        <?php echo esc_html( wp_trim_words( get_the_excerpt(), 26 ) ); ?>
                                    </div>
                                    <div class="bento-card-footer">
                                        <span class="bento-read-time">⏱️ <?php echo esc_html( $reading_t ); ?> <?php esc_html_e( 'min lettura', 'cinephile' ); ?></span>
                                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="bento-link-btn"><?php esc_html_e( "Leggi l'articolo", 'cinephile' ); ?> &rarr;</a>
                                    </div>
                                </div>
                            </article>
                        </section>

                    <?php elseif ( 2 === $post_idx || 3 === $post_idx ) : ?>
                        <?php if ( 2 === $post_idx ) : $duo_opened = true; ?>
                            <section class="bento-duo-section">
                                <div class="bento-duo-grid">
                        <?php endif; ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'bento-card bento-card-duo' ); ?>>
                            <div class="bento-duo-media">
                                <a href="<?php echo esc_url( get_permalink() ); ?>">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'medium_large', array( 'class' => 'bento-img-duo', 'decoding' => 'async' ) ); ?>
                                    <?php elseif ( ! empty( $default_thumb ) ) : ?>
                                        <img src="<?php echo esc_url( $default_thumb ); ?>" alt="<?php the_title_attribute(); ?>" class="bento-img-duo">
                                    <?php endif; ?>
                                </a>
                                <?php if ( ! empty( $voto ) ) : ?>
                                    <span class="bento-voto-badge">⭐ <?php echo esc_html( $voto ); ?>/5</span>
                                <?php endif; ?>
                            </div>
                            <div class="bento-duo-content">
                                <span class="entry-meta-cat"><?php echo wp_kses_post( get_the_category_list( ', ' ) ); ?></span>
                                <h3 class="bento-duo-title">
                                    <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                                </h3>
                                <?php if ( ! empty( $regista ) ) : ?>
                                    <span class="bento-director">🎬 <?php echo esc_html( $regista ); ?></span>
                                <?php endif; ?>
                                <p class="bento-duo-excerpt">
                                    <?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?>
                                </p>
                                <div class="bento-card-footer">
                                    <span class="bento-read-time">⏱️ <?php echo esc_html( $reading_t ); ?> <?php esc_html_e( 'min', 'cinephile' ); ?></span>
                                    <a href="<?php echo esc_url( get_permalink() ); ?>" class="bento-link-btn"><?php esc_html_e( 'Leggi', 'cinephile' ); ?> &rarr;</a>
                                </div>
                            </div>
                        </article>

                        <?php if ( 3 === $post_idx || $wp_query->post_count === $post_idx ) : $duo_opened = false; ?>
                                </div>
                            </section>
                        <?php endif; ?>

                    <?php else : ?>
                        <?php if ( 4 === $post_idx ) : $grid_opened = true; ?>
                            <section class="bento-grid-section">
                                <h3 class="section-heading bento-grid-heading"><?php esc_html_e( 'Altri titoli in questo percorso', 'cinephile' ); ?></h3>
                                <div class="bento-poster-grid">
                        <?php endif; ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'bento-card bento-card-poster' ); ?>>
                            <div class="bento-poster-media">
                                <a href="<?php echo esc_url( get_permalink() ); ?>">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'medium', array( 'class' => 'bento-img-poster', 'decoding' => 'async' ) ); ?>
                                    <?php elseif ( ! empty( $default_thumb ) ) : ?>
                                        <img src="<?php echo esc_url( $default_thumb ); ?>" alt="<?php the_title_attribute(); ?>" class="bento-img-poster">
                                    <?php endif; ?>
                                </a>
                                <?php if ( ! empty( $voto ) ) : ?>
                                    <span class="bento-voto-badge badge-sm">⭐ <?php echo esc_html( $voto ); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="bento-poster-content">
                                <h4 class="bento-poster-title">
                                    <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                                </h4>
                                <?php if ( ! empty( $regista ) ) : ?>
                                    <span class="bento-director-sm"><?php esc_html_e( 'Regia:', 'cinephile' ); ?> <?php echo esc_html( $regista ); ?></span>
                                <?php endif; ?>
                                <span class="bento-poster-date">📅 <?php echo esc_html( get_the_date( 'j M Y' ) ); ?></span>
                            </div>
                        </article>

                        <?php if ( $wp_query->post_count === $post_idx ) : $grid_opened = false; ?>
                                </div>
                            </section>
                        <?php endif; ?>

                    <?php endif; ?>

                <?php endwhile; ?>

                <?php
                if ( $duo_opened ) { echo '</div></section>'; }
                if ( $grid_opened ) { echo '</div></section>'; }
                ?>

            </div>

        <?php else : ?>

            <section class="bento-grid-section bento-paged-section">
                <div class="bento-poster-grid">
                    <?php while ( have_posts() ) : the_post();
                        $post_id   = get_the_ID();
                        $voto      = get_post_meta( $post_id, '_film_voto', true );
                        $regista   = get_post_meta( $post_id, '_film_regista', true );
                    ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'bento-card bento-card-poster' ); ?>>
                            <div class="bento-poster-media">
                                <a href="<?php echo esc_url( get_permalink() ); ?>">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'medium', array( 'class' => 'bento-img-poster', 'decoding' => 'async' ) ); ?>
                                    <?php elseif ( ! empty( $default_thumb ) ) : ?>
                                        <img src="<?php echo esc_url( $default_thumb ); ?>" alt="<?php the_title_attribute(); ?>" class="bento-img-poster">
                                    <?php endif; ?>
                                </a>
                                <?php if ( ! empty( $voto ) ) : ?>
                                    <span class="bento-voto-badge badge-sm">⭐ <?php echo esc_html( $voto ); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="bento-poster-content">
                                <h4 class="bento-poster-title">
                                    <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                                </h4>
                                <?php if ( ! empty( $regista ) ) : ?>
                                    <span class="bento-director-sm"><?php esc_html_e( 'Regia:', 'cinephile' ); ?> <?php echo esc_html( $regista ); ?></span>
                                <?php endif; ?>
                                <span class="bento-poster-date">📅 <?php echo esc_html( get_the_date( 'j M Y' ) ); ?></span>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
            </section>

        <?php endif; ?>

        <div class="pagination-wrapper tag-pagination">
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
            <h2 class="no-results-title"><?php esc_html_e( 'Nessun contenuto trovato per questo tag', 'cinephile' ); ?></h2>
            <p class="no-results-subtext"><?php esc_html_e( 'Non ci sono ancora articoli associati a questo tema.', 'cinephile' ); ?></p>
        </div>

    <?php endif; ?>

</main>

<?php get_footer(); ?>
