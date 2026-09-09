<?php
/**
 * Template Articolo Singolo (Recensione & Critica)
 *
 * Visualizzazione del singolo articolo, scheda tecnica film, galleria polaroid, tag e articoli correlati.
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

$show_thumb = get_theme_mod( 'single_show_featured_image', true );
?>

<main class="site-main content-container single-main-container">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article-card' ); ?>>
            <header class="entry-header">
                <div class="single-category-header">
                    <?php echo wp_kses_post( get_the_category_list( ', ' ) ); ?>
                </div>
                <h1 class="entry-title">
                    <?php echo esc_html( get_the_title() ); ?>
                </h1>
                <div class="entry-meta-single">
                    <span><?php esc_html_e( 'Pubblicato il', 'cinephile' ); ?> <strong><?php echo esc_html( get_the_date() ); ?></strong></span>
                    <span>&bull;</span>
                    <span class="reading-time-badge">⏱️ <?php esc_html_e( 'Lettura:', 'cinephile' ); ?> <?php echo esc_html( cinephile_tempo_lettura() ); ?> <?php esc_html_e( 'min', 'cinephile' ); ?></span>
                </div>
            </header>

            <?php if ( $show_thumb && has_post_thumbnail() ) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail( 'large', array( 'fetchpriority' => 'high', 'loading' => 'eager' ) ); ?>
                </div>
            <?php endif; ?>

            <?php
            $regista       = get_post_meta( get_the_ID(), '_film_regista', true );
            $anno          = get_post_meta( get_the_ID(), '_film_anno', true );
            $durata        = get_post_meta( get_the_ID(), '_film_durata', true );
            $genere        = get_post_meta( get_the_ID(), '_film_genere', true );
            $cast          = get_post_meta( get_the_ID(), '_film_cast', true );
            $distribuzione = get_post_meta( get_the_ID(), '_film_distribuzione', true );
            $voto          = get_post_meta( get_the_ID(), '_film_voto', true );

            $has_info = ! empty( $regista ) || ! empty( $anno ) || ! empty( $durata ) || ! empty( $genere ) || ! empty( $cast ) || ! empty( $distribuzione ) || ! empty( $voto );

            if ( $has_info ) : ?>
                <div class="scheda-film-card">
                    <div class="scheda-film-header">
                        <span class="scheda-badge">🎬 <?php esc_html_e( 'Scheda Tecnica', 'cinephile' ); ?></span>

                        <?php if ( ! empty( $voto ) ) : ?>
                            <div class="scheda-voto">
                                <?php echo esc_html( $voto ); ?> / 5 ⭐
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="scheda-film-grid">
                        <?php if ( ! empty( $regista ) ) : ?>
                            <div class="scheda-item">🎬 <strong><?php esc_html_e( 'Regia:', 'cinephile' ); ?></strong> <?php echo esc_html( $regista ); ?></div>
                        <?php endif; ?>

                        <?php if ( ! empty( $anno ) ) : ?>
                            <div class="scheda-item">📅 <strong><?php esc_html_e( 'Anno:', 'cinephile' ); ?></strong> <?php echo esc_html( $anno ); ?></div>
                        <?php endif; ?>

                        <?php if ( ! empty( $durata ) ) : ?>
                            <div class="scheda-item">⏱️ <strong><?php esc_html_e( 'Durata:', 'cinephile' ); ?></strong> <?php echo esc_html( $durata ); ?> <?php esc_html_e( 'min', 'cinephile' ); ?></div>
                        <?php endif; ?>

                        <?php if ( ! empty( $genere ) ) : ?>
                            <div class="scheda-item">🎭 <strong><?php esc_html_e( 'Genere:', 'cinephile' ); ?></strong> <?php echo esc_html( $genere ); ?></div>
                        <?php endif; ?>
                    </div>

                    <?php if ( ! empty( $cast ) || ! empty( $distribuzione ) ) : ?>
                        <div class="scheda-film-extended">
                            <?php if ( ! empty( $cast ) ) : ?>
                                <div class="scheda-ext-block">
                                    <span class="scheda-ext-label">👥 <?php esc_html_e( 'Cast:', 'cinephile' ); ?></span>
                                    <span class="scheda-ext-val"><?php echo esc_html( $cast ); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $distribuzione ) ) : ?>
                                <div class="scheda-ext-block">
                                    <span class="scheda-ext-label">🍿 <?php esc_html_e( 'Dove vederlo:', 'cinephile' ); ?></span>
                                    <span class="scheda-ext-val"><?php echo esc_html( $distribuzione ); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php
            $gallery_preset = get_post_meta( get_the_ID(), '_cinephile_gallery_preset_override', true );
            if ( empty( $gallery_preset ) ) {
                $gallery_preset = get_post_meta( get_the_ID(), '_cinemaecritica_gallery_preset_override', true );
            }
            if ( empty( $gallery_preset ) || 'default' === $gallery_preset ) {
                $gallery_preset = get_theme_mod( 'gallery_props_preset', 'classico_master' );
            }
            $gallery_random_rot = (bool) get_theme_mod( 'gallery_random_rot', true );
            ?>
            <script>
                window.ccGalleryConfig = {
                    preset: '<?php echo esc_js( $gallery_preset ); ?>',
                    randomRot: <?php echo wp_json_encode( $gallery_random_rot ); ?>
                };
            </script>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <?php
            $post_tags = get_the_tags();
            if ( $post_tags && ! is_wp_error( $post_tags ) ) : ?>
                <div class="entry-tags-wrapper">
                    <span class="tags-label">🏷️ <?php esc_html_e( 'Temi & Tag:', 'cinephile' ); ?></span>
                    <div class="tags-pills-list">
                        <?php foreach ( $post_tags as $tag_item ) : ?>
                            <a href="<?php echo esc_url( get_tag_link( $tag_item->term_id ) ); ?>" class="tag-pill-link">
                                #<?php echo esc_html( $tag_item->name ); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <footer class="entry-footer author-signature-wrapper">
                <?php if ( get_theme_mod( 'enable_author_archive_links', false ) ) : ?>
                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author-signature-badge" title="<?php printf( esc_attr__( 'Tutte le recensioni di %s', 'cinephile' ), esc_attr( get_the_author() ) ); ?>">
                        <div class="author-avatar">
                            <?php echo wp_kses_post( get_avatar( get_the_author_meta( 'ID' ), 88, '', esc_attr( get_the_author() ) ) ); ?>
                        </div>
                        <div class="author-details">
                            <span class="author-label"><?php esc_html_e( 'A cura di', 'cinephile' ); ?></span>
                            <span class="author-name"><?php echo esc_html( get_the_author() ); ?></span>
                        </div>
                    </a>
                <?php else : ?>
                    <div class="author-signature-badge">
                        <div class="author-avatar">
                            <?php echo wp_kses_post( get_avatar( get_the_author_meta( 'ID' ), 88, '', esc_attr( get_the_author() ) ) ); ?>
                        </div>
                        <div class="author-details">
                            <span class="author-label"><?php esc_html_e( 'A cura di', 'cinephile' ); ?></span>
                            <span class="author-name"><?php echo esc_html( get_the_author() ); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </footer>
        </article>

        <?php
        // Area Commenti (se abilitata dal Customizer e attiva sul post)
        if ( get_theme_mod( 'enable_comments_system', false ) && ( comments_open() || get_comments_number() ) ) {
            comments_template();
        }
        ?>

<?php
$current_post_id = get_the_ID();
$related_posts   = array();
$tags            = get_the_tags( $current_post_id );

if ( $tags && ! is_wp_error( $tags ) ) {
    $tag_ids   = array_map( 'absint', wp_list_pluck( $tags, 'term_id' ) );
    $tag_query = new WP_Query( array(
        'tag__in'                => $tag_ids,
        'post__not_in'           => array( absint( $current_post_id ) ),
        'posts_per_page'         => 3,
        'ignore_sticky_posts'    => 1,
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'no_found_rows'          => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
    ) );
    $related_posts = $tag_query->posts;
}

$needed = 3 - count( $related_posts );

if ( $needed > 0 ) {
    $categories = get_the_category( $current_post_id );
    if ( $categories && ! is_wp_error( $categories ) ) {
        $category_ids    = array_map( 'absint', wp_list_pluck( $categories, 'term_id' ) );
        $already_fetched = array_map( 'absint', array_merge( array( $current_post_id ), wp_list_pluck( $related_posts, 'ID' ) ) );

        $cat_query = new WP_Query( array(
            'category__in'           => $category_ids,
            'post__not_in'           => $already_fetched,
            'posts_per_page'         => absint( $needed ),
            'ignore_sticky_posts'    => 1,
            'orderby'                => 'date',
            'order'                  => 'DESC',
            'no_found_rows'          => true,
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false,
        ) );

        $related_posts = array_merge( $related_posts, $cat_query->posts );
    }
}

if ( ! empty( $related_posts ) ) : ?>
    <section class="related-posts">
        <div class="related-header">
            <span class="kicker-badge"><?php esc_html_e( 'Consigli di lettura', 'cinephile' ); ?></span>
            <h3 class="related-title"><?php esc_html_e( 'Potrebbero interessarti anche:', 'cinephile' ); ?></h3>
        </div>

        <div class="related-grid">
            <?php
            global $post;
            foreach ( $related_posts as $related_item ) :
                $post = $related_item;
                setup_postdata( $post );
            ?>
            <article class="related-card">
                <div>
                    <?php if ( $show_thumb && has_post_thumbnail() ) : ?>
                        <div class="related-thumb">
                            <a href="<?php echo esc_url( get_permalink() ); ?>">
                                <?php the_post_thumbnail( 'medium' ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="related-cat">
                        <?php
                        $cats = get_the_category();
                        if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
                            echo esc_html( $cats[0]->name );
                        }
                        ?>
                    </div>
                    <h4 class="related-card-title">
                        <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                    </h4>
                </div>
                <a href="<?php echo esc_url( get_permalink() ); ?>" class="related-link"><?php esc_html_e( "Leggi l'articolo", 'cinephile' ); ?> &rarr;</a>
            </article>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>
    </section>
<?php endif; ?>

    <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
