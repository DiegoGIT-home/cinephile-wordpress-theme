<?php
/**
 * Template di Errore 404 (Pellicola Smarrita)
 *
 * Gestione pagina 404 non trovato con citazioni cinematografiche tematiche e ricerca d'emergenza.
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

$kicker_404   = get_theme_mod( 'error_404_kicker', __( 'Scena Tagliata in Montaggio', 'cinephile' ) );
$button_label = get_theme_mod( 'error_404_button_label', __( 'Torna alla Home Page', 'cinephile' ) );

$citazioni_cinema = array(
    array(
        'quote' => __( 'Noi vogliamo sapere: per andare dove dobbiamo andare, per dove dobbiamo andare?', 'cinephile' ),
        'film'  => __( 'Totò, Peppino e la... malafemmina', 'cinephile' ),
        'anno'  => '1956',
        'regia' => __( 'Camillo Mastrocinque', 'cinephile' ),
    ),
    array(
        'quote' => __( 'Ho come la sensazione che non siamo più nel Kansas...', 'cinephile' ),
        'film'  => __( 'Il Mago di Oz', 'cinephile' ),
        'anno'  => '1939',
        'regia' => 'Victor Fleming',
    ),
    array(
        'quote' => __( 'Questi non sono i droidi che state cercando.', 'cinephile' ),
        'film'  => __( 'Star Wars: Una nuova speranza', 'cinephile' ),
        'anno'  => '1977',
        'regia' => 'George Lucas',
    ),
    array(
        'quote' => __( 'Strade? Dove andiamo noi non servono strade!', 'cinephile' ),
        'film'  => __( 'Ritorno al futuro', 'cinephile' ),
        'anno'  => '1985',
        'regia' => 'Robert Zemeckis',
    ),
    array(
        'quote' => __( 'Se non sai dove vuoi andare, poco importa quale strada prendi.', 'cinephile' ),
        'film'  => __( 'Alice nel Paese delle Meraviglie', 'cinephile' ),
        'anno'  => '1951',
        'regia' => 'C. Geronimi, H. Luske, W. Jackson',
    ),
    array(
        'quote' => __( 'Fermati! Chi siete? Cosa portate? Un fiorino!', 'cinephile' ),
        'film'  => __( 'Non ci resta che piangere', 'cinephile' ),
        'anno'  => '1984',
        'regia' => 'Massimo Troisi, Roberto Benigni',
    ),
);

$citazione_attiva = $citazioni_cinema[ array_rand( $citazioni_cinema ) ];

get_header();
?>

<main id="main-content" class="site-main content-container template-404-container">
    <div class="template-404-box">

        <span class="template-404-number">404</span>
        <?php if ( ! empty( $kicker_404 ) ) : ?>
            <p class="template-404-kicker"><?php echo esc_html( $kicker_404 ); ?></p>
        <?php endif; ?>

        <h1 class="template-404-title">
            "<?php echo esc_html( $citazione_attiva['quote'] ); ?>"
        </h1>
        <p class="template-404-quote">
            &mdash; <?php echo esc_html( $citazione_attiva['film'] ); ?> (<?php echo esc_html( $citazione_attiva['anno'] ); ?>), <?php esc_html_e( 'regia di', 'cinephile' ); ?> <?php echo esc_html( $citazione_attiva['regia'] ); ?>
        </p>

        <p class="template-404-description">
            <?php esc_html_e( 'La pagina che stavi cercando è stata spostata, rimossa oppure l\'indirizzo inserito non è corretto.', 'cinephile' ); ?>
        </p>

        <div class="template-404-search">
            <p class="template-404-search-label"><?php esc_html_e( "Cerca un titolo o un regista nell'archivio:", 'cinephile' ); ?></p>
            <?php get_search_form(); ?>
        </div>

        <?php
        $random_posts = new WP_Query( array(
            'posts_per_page'         => 3,
            'post_status'            => 'publish',
            'orderby'                => 'date',
            'no_found_rows'          => true,
            'ignore_sticky_posts'    => true,
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false,
        ) );

        if ( $random_posts->have_posts() ) : ?>
            <div class="template-404-recent">
                <h3 class="template-404-recent-title"><?php esc_html_e( "Invece di tornare a mani vuote, lasciati ispirare dall'archivio:", 'cinephile' ); ?></h3>
                <br>
                <div class="template-404-recent-grid">
                    <?php while ( $random_posts->have_posts() ) : $random_posts->the_post(); ?>
                        <article class="template-404-recent-card">
                            <div class="template-404-card-body">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="template-404-recent-thumb">
                                        <a href="<?php echo esc_url( get_permalink() ); ?>">
                                            <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <?php
                                $categories = get_the_category();
                                if ( ! empty( $categories ) ) : ?>
                                    <span class="template-404-recent-cat"><?php echo esc_html( $categories[0]->name ); ?></span>
                                <?php endif; ?>

                                <h4 class="template-404-recent-post-title">
                                    <a href="<?php echo esc_url( get_permalink() ); ?>">
                                        <?php echo esc_html( get_the_title() ); ?>
                                    </a>
                                </h4>
                            </div>
                            <a href="<?php echo esc_url( get_permalink() ); ?>" class="template-404-recent-link"><?php esc_html_e( "Leggi l'articolo", 'cinephile' ); ?> &rarr;</a>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="template-404-action">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-return-home">
                &larr; <?php echo esc_html( $button_label ); ?>
            </a>
        </div>

    </div>
</main>

<?php get_footer(); ?>
