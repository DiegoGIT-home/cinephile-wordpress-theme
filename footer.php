<?php
/**
 * Template Footer (Piè di Pagina)
 *
 * Chiusura del documento HTML, navigazione secondaria, crediti di legge e copyright dinamico.
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
?>
<footer class="site-footer">
    <div class="content-container footer-container">

        <div class="footer-brand">
            <?php
            $brand_name    = get_theme_mod( 'brand_name', get_bloginfo( 'name' ) );
            $brand_tagline = get_theme_mod( 'brand_tagline', get_bloginfo( 'description' ) );
            ?>
            <h4 class="footer-logo-text"><?php echo wp_kses_post( $brand_name ); ?></h4>
            <?php if ( ! empty( $brand_tagline ) ) : ?>
                <p class="footer-tagline"><?php echo esc_html( $brand_tagline ); ?></p>
            <?php endif; ?>
        </div>

        <nav class="footer-nav">
            <?php
            if ( has_nav_menu( 'footer-menu' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'footer-menu',
                    'container'      => false,
                    'menu_class'     => 'footer-menu-ul',
                    'depth'          => 1,
                ) );
            } else {
                echo '<ul class="footer-menu-ul">';
                echo '<li><a href="' . esc_url( get_privacy_policy_url() ) . '">' . esc_html__( 'Privacy & Cookie Policy', 'cinephile' ) . '</a></li>';
                echo '<li><a href="' . esc_url( home_url( '/chi-siamo/' ) ) . '">' . esc_html__( 'Chi siamo', 'cinephile' ) . '</a></li>';
                echo '<li><a href="' . esc_url( home_url( '/contatti/' ) ) . '">' . esc_html__( 'Contatti', 'cinephile' ) . '</a></li>';
                echo '</ul>';
            }
            ?>
        </nav>

        <div class="footer-top-action">
            <button type="button" class="btn-back-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">
                &uarr; <?php esc_html_e( 'Torna in cima', 'cinephile' ); ?>
            </button>
        </div>

    </div>

    <div class="footer-bottom">
        <div class="content-container footer-bottom-flex">
            <?php
            $copyright = get_theme_mod( 'footer_copyright_text', '' );
            if ( empty( $copyright ) ) {
                $copyright = sprintf(
                    /* translators: 1: Anno, 2: Nome brand */
                    esc_html__( '© %1$s %2$s. Tutti i diritti riservati.', 'cinephile' ),
                    date_i18n( 'Y' ),
                    ! empty( $brand_name ) ? $brand_name : get_bloginfo( 'name' )
                );
            }
            $credits   = get_theme_mod( 'footer_credits_text', __( 'Progetto editoriale didattico GDPR Native', 'cinephile' ) );
            $show_cred = get_theme_mod( 'footer_show_credits', true );
            ?>
            <p class="copyright-text"><?php echo esc_html( $copyright ); ?></p>
            <?php if ( $show_cred && ! empty( $credits ) ) : ?>
                <p class="credits-text"><?php echo wp_kses_post( $credits ); ?></p>
            <?php endif; ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
