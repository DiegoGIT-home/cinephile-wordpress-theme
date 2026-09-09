<?php
/**
 * Template Risultati della Ricerca
 *
 * Presentazione degli articoli e saggi corrispondenti ai termini di ricerca con evidenziazione parole chiave.
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

$kicker_header = get_theme_mod( 'search_hero_kicker', __( 'ARCHIVIO RICERCA', 'cinephile' ) );
$badge_no_res  = get_theme_mod( 'search_no_results_badge', __( 'FUORI PROGRAMMA', 'cinephile' ) );

$citazioni_no_results = array(
    esc_html__( 'Io ne ho viste cose che voi umani... ma questo non c\'è in archivio!', 'cinephile' ),
    esc_html__( 'Ho setacciato ogni singolo fotogramma: di questo titolo non c\'è traccia.', 'cinephile' ),
    esc_html__( 'Cercare l\'introvabile è il nostro mestiere, ma qui neanche la pellicola ne ha memoria.', 'cinephile' ),
    esc_html__( 'Abbiamo cercato in lungo e in largo, ma la proiezione per questa parola chiave è annullata.', 'cinephile' ),
    esc_html__( 'Cercavamo un capolavoro, ma ci siamo trovati di fronte a una pellicola bianca.', 'cinephile' ),
    esc_html__( 'Elementare: quello che cerchi non è ancora stato scritto nei nostri archivi.', 'cinephile' )
);

$frase_casuale = $citazioni_no_results[ array_rand( $citazioni_no_results ) ];
?>

<main id="main-content" class="site-main">
    <div class="content-container">

        <?php if ( have_posts() ) : ?>

            <header class="page-hero-section search-results-header">
                <?php if ( ! empty( $kicker_header ) ) : ?>
                    <span class="hero-kicker"><?php echo esc_html( $kicker_header ); ?></span>
                <?php endif; ?>
                <h1 class="page-title">
                    <?php esc_html_e( 'Risultati per:', 'cinephile' ); ?> <mark class="search-query-highlight">"<?php echo esc_html( get_search_query() ); ?>"</mark>
                </h1>
            </header>

            <div class="evidenza-grid-vertical search-results-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'evidenza-card-vert' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="evidenza-img-top">
                                <a href="<?php echo esc_url( get_permalink() ); ?>">
                                    <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="evidenza-body-vert">
                            <span class="entry-meta"><?php echo wp_kses_post( get_the_category_list( ', ' ) ); ?></span>
                            <h3 class="evidenza-title">
                                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                            </h3>
                            <div class="evidenza-excerpt">
                                <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="search-pagination">
                <?php
                $pagination_args = array(
                    'prev_text' => '&larr; ' . esc_html__( 'Precedenti', 'cinephile' ),
                    'next_text' => esc_html__( 'Successivi', 'cinephile' ) . ' &rarr;',
                );
                echo wp_kses_post( get_the_posts_pagination( $pagination_args ) );
                ?>
            </div>

        <?php else : ?>

            <section class="no-results-box">

                <div class="no-results-icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 5-3 3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/>
                        <path d="m6 5 3 3"/>
                        <path d="m12 5 3 3"/>
                    </svg>
                </div>

                <h2 class="no-results-title">
                    "<?php echo esc_html( $frase_casuale ); ?>"
                </h2>

                <p class="no-results-subtext">
                   <?php esc_html_e( 'Nessun contenuto trovato per', 'cinephile' ); ?> <mark class="search-query-highlight">"<?php echo esc_html( get_search_query() ); ?>"</mark>.<br>
                    <?php esc_html_e( "Verifica l'ortografia oppure riprova con parole chiave più brevi.", 'cinephile' ); ?>
                </p>

                <div class="hero-search-wrapper">
                    <p class="no-results-search-label"><?php esc_html_e( "Riprova con un'altra parola chiave:", 'cinephile' ); ?></p>
                    <?php get_search_form(); ?>
                </div>

                <div class="no-results-divider"></div>

                <?php
                $random_query = new WP_Query( array(
                    'post_type'              => 'post',
                    'posts_per_page'         => 3,
                    'orderby'                => 'date',
                    'no_found_rows'          => true,
                    'ignore_sticky_posts'    => true,
                    'update_post_term_cache' => false,
                    'update_post_meta_cache' => false,
                ) );

                if ( $random_query->have_posts() ) : ?>
                    <div class="random-suggestions">
                        <?php if ( ! empty( $badge_no_res ) ) : ?>
                            <span class="badge-tag">
                                <span class="badge-dot"></span> <?php echo esc_html( $badge_no_res ); ?>
                            </span>
                        <?php endif; ?>
                        <h3 class="suggestions-title"><?php esc_html_e( 'Ecco 3 spunti di lettura dal nostro archivio:', 'cinephile' ); ?></h3>

                        <div class="secondari-grid">
                            <?php while ( $random_query->have_posts() ) : $random_query->the_post(); ?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class( 'secondary-card' ); ?>>
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <div class="card-image">
                                            <a href="<?php echo esc_url( get_permalink() ); ?>">
                                                <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <span class="entry-meta"><?php echo wp_kses_post( get_the_category_list( ', ' ) ); ?></span>
                                        <h4 class="card-title">
                                            <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                                        </h4>
                                    </div>
                                </article>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>
                    </div>
                <?php endif; ?>

            </section>

        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
