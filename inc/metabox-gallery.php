<?php
/**
 * Metabox Scenografia Galleria Polaroid (12 Preset)
 *
 * Selezione dello stile scenografico cinematografico per la galleria fotografica del singolo post.
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

function cinephile_add_gallery_scenography_metabox() {
	add_meta_box(
		'cinephile_gallery_scenography_box',
		__( 'Scenografia Galleria Fotografie', 'cinephile' ),
		'cinephile_render_gallery_scenography_metabox',
		'post',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'cinephile_add_gallery_scenography_metabox' );

function cinephile_render_gallery_scenography_metabox( $post ) {
	wp_nonce_field( 'cinephile_save_gallery_scenography', 'cinephile_gallery_scenography_nonce' );
	$current_val = get_post_meta( $post->ID, '_cinephile_gallery_preset_override', true );
	if ( empty( $current_val ) ) {
		$current_val = get_post_meta( $post->ID, '_cinemaecritica_gallery_preset_override', true );
	}
	if ( empty( $current_val ) ) {
		$current_val = 'default';
	}
	?>
	<p class="mb-gallery-label-wrap">
		<label for="cinephile_gallery_preset_override"><strong><?php esc_html_e( 'Stile Scenografico:', 'cinephile' ); ?></strong></label>
	</p>
	<select name="cinephile_gallery_preset_override" id="cinephile_gallery_preset_override" class="widefat">
		<option value="default" <?php selected( $current_val, 'default' ); ?>><?php esc_html_e( '— Predefinito da Customizer —', 'cinephile' ); ?></option>

		<optgroup label="🎞️ CINEMA CLASSICO (PELLICOLE)">
			<option value="classico_master" <?php selected( $current_val, 'classico_master' ); ?>><?php esc_html_e( 'Classico Master (Tutti gli elementi)', 'cinephile' ); ?></option>
			<option value="classico_v1" <?php selected( $current_val, 'classico_v1' ); ?>><?php esc_html_e( 'Variante 1: Solo Pellicole 35mm', 'cinephile' ); ?></option>
			<option value="classico_v2" <?php selected( $current_val, 'classico_v2' ); ?>><?php esc_html_e( 'Variante 2: Pizze & Rullini', 'cinephile' ); ?></option>
			<option value="classico_v3" <?php selected( $current_val, 'classico_v3' ); ?>><?php esc_html_e( 'Variante 3: Pellicola Essenziale', 'cinephile' ); ?></option>
		</optgroup>

		<optgroup label="📣 SET REGIA (SET RIPRESA)">
			<option value="regia_master" <?php selected( $current_val, 'regia_master' ); ?>><?php esc_html_e( 'Regia Master (Tutti gli elementi)', 'cinephile' ); ?></option>
			<option value="regia_v1" <?php selected( $current_val, 'regia_v1' ); ?>><?php esc_html_e( 'Variante 1: Sedia XL & Megafono', 'cinephile' ); ?></option>
			<option value="regia_v2" <?php selected( $current_val, 'regia_v2' ); ?>><?php esc_html_e( 'Variante 2: Ciak & Taccuino', 'cinephile' ); ?></option>
			<option value="regia_v3" <?php selected( $current_val, 'regia_v3' ); ?>><?php esc_html_e( 'Variante 3: Audio Boom & Ciak', 'cinephile' ); ?></option>
		</optgroup>

		<optgroup label="✂️ BANCO MOVIOLA (MONTAGGIO)">
			<option value="moviola_master" <?php selected( $current_val, 'moviola_master' ); ?>><?php esc_html_e( 'Moviola Master (Tutti gli elementi)', 'cinephile' ); ?></option>
			<option value="moviola_v1" <?php selected( $current_val, 'moviola_v1' ); ?>><?php esc_html_e( 'Variante 1: Forbici XL & Nastro', 'cinephile' ); ?></option>
			<option value="moviola_v2" <?php selected( $current_val, 'moviola_v2' ); ?>><?php esc_html_e( 'Variante 2: Lente XL & Timecode', 'cinephile' ); ?></option>
			<option value="moviola_v3" <?php selected( $current_val, 'moviola_v3' ); ?>><?php esc_html_e( 'Variante 3: Taglio & Giunta Precisione', 'cinephile' ); ?></option>
		</optgroup>

		<option value="none" <?php selected( $current_val, 'none' ); ?>><?php esc_html_e( '🚫 Nessuna Scenografia (Solo Foto)', 'cinephile' ); ?></option>
	</select>
	<?php
}

function cinephile_save_gallery_scenography_meta( $post_id ) {
	if ( ! isset( $_POST['cinephile_gallery_scenography_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cinephile_gallery_scenography_nonce'] ) ), 'cinephile_save_gallery_scenography' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['cinephile_gallery_preset_override'] ) ) {
		$allowed = array_merge( array( 'default' ), cinephile_get_gallery_presets() );
		$val     = sanitize_key( wp_unslash( $_POST['cinephile_gallery_preset_override'] ) );
		if ( in_array( $val, $allowed, true ) ) {
			update_post_meta( $post_id, '_cinephile_gallery_preset_override', $val );
			update_post_meta( $post_id, '_cinemaecritica_gallery_preset_override', $val );
		}
	}
}
add_action( 'save_post', 'cinephile_save_gallery_scenography_meta' );
