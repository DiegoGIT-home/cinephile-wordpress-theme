<?php
/**
 * Template Modulo e Lista Commenti
 *
 * Gestione discussione e moderazione commenti nel rispetto della privacy e delle linee guida GDPR.
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

// Controllo attivazione globale commenti da Customizer (Default: Disattivato per sicurezza)
if ( ! get_theme_mod( 'enable_comments_system', false ) ) {
    return;
}

// Blocco esecuzione se il post richiede password
if ( post_password_required() ) {
    return;
}
?>

<section id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>
        <h3 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ( '1' === $comment_count ) {
                echo esc_html__( '1 Commento', 'cinephile' );
            } else {
                printf(
                    /* translators: %1$s: Numero commenti */
                    esc_html( _nx( '%1$s Commento', '%1$s Commenti', $comment_count, 'comments title', 'cinephile' ) ),
                    number_format_i18n( $comment_count )
                );
            }
            ?>
        </h3>

        <ul class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ul',
                'short_ping'  => true,
                'avatar_size' => 56,
            ) );
            ?>
        </ul>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <nav class="comment-navigation">
                <?php
                $pagination_args = array(
                    'prev_text' => '&larr; ' . esc_html__( 'Commenti Precedenti', 'cinephile' ),
                    'next_text' => esc_html__( 'Commenti Successivi', 'cinephile' ) . ' &rarr;',
                );
                echo wp_kses_post( get_the_comments_pagination( $pagination_args ) );
                ?>
            </nav>
        <?php endif; ?>

    <?php endif; ?>

    <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="no-comments"><?php esc_html_e( 'I commenti sono disabilitati per questo contenuto.', 'cinephile' ); ?></p>
    <?php endif; ?>

    <?php
    // Form Commenti Blindato con Campo Spam Honeypot Integrato
    $commenter = wp_get_current_commenter();

    $fields = array(
        'author' => '<p class="comment-form-author"><label for="author">' . esc_html__( 'Nome *', 'cinephile' ) . '</label> ' .
                    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required placeholder="' . esc_attr__( 'Il tuo nome', 'cinephile' ) . '" /></p>',
        'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email *', 'cinephile' ) . '</label> ' .
                    '<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" required placeholder="' . esc_attr__( 'tua@email.it', 'cinephile' ) . '" /></p>',
        // CAMPO HONEYPOT INVISIBILE ANTI-SPAM (Se compilato dai bot, il commento viene scartato)
        'hp'     => '<div class="hp-hidden" aria-hidden="true"><input type="text" name="real_user_comment_hp" tabindex="-1" value="" autocomplete="off" /></div>',
    );

    comment_form( array(
        'title_reply'          => esc_html__( 'Lascia un commento', 'cinephile' ),
        'title_reply_to'       => esc_html__( 'Rispondi a %s', 'cinephile' ),
        'cancel_reply_link'    => esc_html__( 'Annulla risposta', 'cinephile' ),
        'label_submit'         => esc_attr__( 'Invia Commento', 'cinephile' ),
        'class_submit'         => 'submit-btn',
        'fields'               => $fields,
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Commento *', 'cinephile' ) . '</label><textarea id="comment" name="comment" cols="45" rows="5" required placeholder="' . esc_attr__( 'Scrivi qui la tua opinione...', 'cinephile' ) . '"></textarea></p>',
    ) );
    ?>

</section>
