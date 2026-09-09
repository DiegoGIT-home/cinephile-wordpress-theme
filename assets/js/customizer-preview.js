/**
 * Script di Live Preview in Tempo Reale per il Customizer
 *
 * Gestione eventi postMessage per aggiornamento istantaneo del DOM e delle variabili CSS :root.
 *
 * Tema: Cinephile - Editorial Cinema Magazine
 * Ideatore: Diego Costanzo (Firenze, Italia)
 * Autore & Sviluppo: Antigravity & Gemini (Google DeepMind)
 * Realizzato con l'ausilio di Intelligenza Artificiale (AI)
 * Versione: 1.0.0 - Settembre 2026
 * Licenza: GNU General Public License v2 or later (Open Source)
 *
 * @package Cinephile
 */

( function( $ ) {
    'use strict';

    if ( ! wp || ! wp.customize ) {
        return;
    }

    // --- 1. PALETTE CROMATICA (CSS VARIABLES SU :ROOT) ---

    // Colore Primario di Accento
    wp.customize( 'theme_color_accent', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty( '--color-accent', newval );
        } );
    } );

    // Sfondo Generale (Canvas)
    wp.customize( 'theme_bg_canvas', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty( '--bg-canvas', newval );
        } );
    } );

    // Testo Principale ad Alto Contrasto
    wp.customize( 'theme_text_main', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty( '--text-main', newval );
        } );
    } );

    // Sfondo Schede / Card
    wp.customize( 'theme_bg_card', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty( '--bg-card', newval );
        } );
    } );

    // Testo Secondario / Muted
    wp.customize( 'theme_text_muted', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty( '--text-muted', newval );
        } );
    } );

    // Bordi e Linee Divisorie
    wp.customize( 'theme_border_line', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty( '--border-line', newval );
        } );
    } );

    // --- 2. IDENTITÀ DEL BRAND & TESTATA ---

    // Nome Brand / Testata
    wp.customize( 'brand_name', function( value ) {
        value.bind( function( newval ) {
            $( '.site-title a' ).text( newval );
            $( '.footer-logo-text' ).text( newval );
            $( '.footer-copyright-name' ).text( newval );
        } );
    } );

    // Motto / Sottotitolo
    wp.customize( 'brand_tagline', function( value ) {
        value.bind( function( newval ) {
            $( '.site-description' ).text( newval );
        } );
    } );

    // --- 3. PAGINA CONTATTI (LIVE TEXTS) ---

    // Kicker Hero Contatti
    wp.customize( 'contact_hero_kicker', function( value ) {
        value.bind( function( newval ) {
            $( '.page-contatti-hero .contact-kicker' ).text( newval );
        } );
    } );

    // Etichetta Pulsante Invio Form
    wp.customize( 'contact_button_label', function( value ) {
        value.bind( function( newval ) {
            $( '.contact-form-container .submit-btn, #submit-btn' ).text( newval );
        } );
    } );

    // --- 4. TESTI TEMPLATE & ARCHIVI ---

    // Testo Bottone "Leggi l'articolo"
    wp.customize( 'template_read_more_text', function( value ) {
        value.bind( function( newval ) {
            $( '.related-link, .read-more-link' ).each( function() {
                var $this = $( this );
                $this.text( newval + ' →' );
            } );
        } );
    } );

    // Titoli sezioni Home
    wp.customize( 'home_latest_title', function( value ) {
        value.bind( function( newval ) {
            $( '.latest-posts-section .section-title, .home-latest-title' ).text( newval );
        } );
    } );

    wp.customize( 'home_spotlight_title', function( value ) {
        value.bind( function( newval ) {
            $( '.spotlight-section .section-title, .home-spotlight-title' ).text( newval );
        } );
    } );

    wp.customize( 'home_gallery_title', function( value ) {
        value.bind( function( newval ) {
            $( '.gallery-section .section-title, .home-gallery-title' ).text( newval );
        } );
    } );

    // --- 5. TESTO COPYRIGHT FOOTER ---
    wp.customize( 'footer_custom_text', function( value ) {
        value.bind( function( newval ) {
            $( '.footer-custom-copy' ).text( newval );
        } );
    } );

} )( jQuery );
