<?php
/**
 * Template Homepage (Rivista Cinematografica)
 *
 * Layout editoriale per la testata: In Primo Piano (Hero), Focus e Percorsi, e Archivio Recensioni.
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
?>

<main class="site-main">
    <div class="content-container">

        <?php
        global $post;
        $slot_posts = function_exists( 'cinephile_get_home_slot_posts' ) ? cinephile_get_home_slot_posts() : array();
        ?>

        <?php if ( empty( $slot_posts ) ) : ?>
            <section class="section-empty-welcome">
                <div class="empty-welcome-card">
                    <div class="empty-welcome-icon">🎬</div>
                    <h2 class="empty-welcome-title"><?php esc_html_e( 'Benvenuto su Cinephile!', 'cinephile' ); ?></h2>
                    <p class="empty-welcome-desc">
                        <?php esc_html_e( 'Il tuo magazine cinematografico è pronto. Inizia a pubblicare le prime recensioni o saggi dal pannello di amministrazione per popolare automaticamente le sezioni In Primo Piano, Focus e gli archivi.', 'cinephile' ); ?>
                    </p>
                    <?php if ( current_user_can( 'edit_posts' ) ) : ?>
                        <a href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>" class="btn-primary-welcome">
                            <?php esc_html_e( '✍️ Scrivi il tuo primo articolo', 'cinephile' ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- 1. SEZIONE: IN PRIMO PIANO -->
        <?php if ( isset( $slot_posts['hero_main'] ) ) :
            $post = $slot_posts['hero_main'];
            setup_postdata( $post );
        ?>
            <section class="section-hero">
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'hero-card' ); ?>>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="hero-image">
                            <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
                        </div>
                    <?php endif; ?>
                    <div class="hero-body">
                        <span class="entry-meta"><?php echo wp_kses_post( get_the_category_list( ', ' ) ); ?></span>
                        <h2 class="hero-title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h2>
                        <div class="hero-excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></div>
                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="btn-link"><?php esc_html_e( 'Leggi articolo', 'cinephile' ); ?> &rarr;</a>
                    </div>
                </article>
            </section>
        <?php wp_reset_postdata(); endif; ?>

        <!-- 2. SEZIONE: FOCUS E PERCORSI -->
        <?php
        $focus_keys = array( 'hero_side_1', 'hero_side_2', 'hero_side_3' );
        $has_focus  = false;
        foreach ( $focus_keys as $fk ) { if ( isset( $slot_posts[$fk] ) ) { $has_focus = true; break; } }
        if ( $has_focus ) :
            $focus_title = get_theme_mod( 'home_section_focus_title', __( 'Focus e Percorsi', 'cinephile' ) );
        ?>
            <section class="section-secondari">
                <h3 class="section-heading"><?php echo esc_html( $focus_title ); ?></h3>
                <div class="secondari-grid">
                    <?php foreach ( $focus_keys as $fk ) :
                        if ( isset( $slot_posts[$fk] ) ) :
                            $post = $slot_posts[$fk];
                            setup_postdata( $post );
                    ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'secondary-card' ); ?>>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="card-image">
                                    <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_post_thumbnail( 'medium' ); ?></a>
                                </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <span class="entry-meta"><?php echo wp_kses_post( get_the_category_list( ', ' ) ); ?></span>
                                <h4 class="card-title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h4>
                                <div class="card-excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></div>
                            </div>
                        </article>
                    <?php endif; endforeach; wp_reset_postdata(); ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- 3. SEZIONE: DAL NOSTRO ARCHIVIO -->
        <?php
        $archivio_keys = array( 'horiz_1', 'horiz_2', 'horiz_3', 'horiz_4' );
        $has_archivio  = false;
        foreach ( $archivio_keys as $ak ) { if ( isset( $slot_posts[$ak] ) ) { $has_archivio = true; break; } }
        if ( $has_archivio ) :
            $archive_title = get_theme_mod( 'home_section_archive_title', __( 'Dal nostro archivio', 'cinephile' ) );
        ?>
            <section class="section-evidenza">
                <h3 class="section-heading"><?php echo esc_html( $archive_title ); ?></h3>
                <div class="evidenza-grid-horizontal">
                    <?php foreach ( $archivio_keys as $ak ) :
                        if ( isset( $slot_posts[$ak] ) ) :
                            $post = $slot_posts[$ak];
                            setup_postdata( $post );
                    ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'evidenza-card-horiz' ); ?>>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="evidenza-img-left">
                                    <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_post_thumbnail( 'medium' ); ?></a>
                                </div>
                            <?php endif; ?>
                            <div class="evidenza-body-horiz">
                                <span class="entry-meta"><?php echo wp_kses_post( get_the_category_list( ', ' ) ); ?></span>
                                <h4 class="evidenza-title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h4>
                                <p class="evidenza-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 14 ) ); ?></p>
                            </div>
                        </article>
                    <?php endif; endforeach; wp_reset_postdata(); ?>
                </div>
            </section>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
