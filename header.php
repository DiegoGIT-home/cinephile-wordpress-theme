<?php
/**
 * Template Header (Testata del Sito)
 *
 * Apertura documento HTML, meta tag, barra menu fixed superiore e branding con logo e motto.
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
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- BARRA MENU FIXED ASSOLUTA -->
<div class="header-top-fixed">
    <div class="header-top-flex">
        <nav class="main-navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'main-menu',
                'fallback_cb'    => false,
                'depth'          => 1,
            ) );
            ?>
        </nav>
        <div class="header-search">
            <?php get_search_form(); ?>
        </div>
    </div>
</div>

<header class="site-header">
    <div class="site-branding-container">
        <div class="site-branding">
            <?php
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $header_logo    = get_theme_mod( 'header_logo_url', '' );
            $brand_name     = get_theme_mod( 'brand_name', get_bloginfo( 'name' ) );
            $brand_tagline  = get_theme_mod( 'brand_tagline', get_bloginfo( 'description' ) );

            if ( $custom_logo_id ) {
                the_custom_logo();
            } elseif ( ! empty( $header_logo ) ) {
                echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="main-logo-link">';
                echo '<img src="' . esc_url( $header_logo ) . '" alt="' . esc_attr( $brand_name ) . '" class="main-brand-logo">';
                echo '</a>';
            } elseif ( file_exists( get_template_directory() . '/assets/img/cinephile-logo.webp' ) ) {
                $default_logo = get_theme_file_uri( '/assets/img/cinephile-logo.webp' );
                echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="main-logo-link">';
                echo '<img src="' . esc_url( $default_logo ) . '" alt="' . esc_attr( $brand_name ) . '" class="main-brand-logo">';
                echo '</a>';
            } else {
                echo '<h1 class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( $brand_name ) . '</a></h1>';
                if ( ! empty( $brand_tagline ) ) {
                    echo '<p class="site-description">' . esc_html( $brand_tagline ) . '</p>';
                }
            }
            ?>
        </div>
    </div>
</header>
