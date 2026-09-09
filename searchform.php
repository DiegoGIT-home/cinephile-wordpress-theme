<?php
/**
 * Template Modulo di Ricerca Personalizzato
 *
 * Form di ricerca accessibile e integrato nella testata e nelle pagine del tema.
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
<form role="search" method="get" class="search-form-custom" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="search-input-wrapper">
        <input type="search" class="search-field-custom" placeholder="<?php echo esc_attr__( 'Cerca nel sito...', 'cinephile' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
        <button type="submit" class="search-submit-custom" aria-label="<?php echo esc_attr__( 'Cerca', 'cinephile' ); ?>">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </button>
    </div>
</form>
