<?php
/**
 * Metabox Dati Strutturati Film e Valutazione
 *
 * Registrazione, rendering e salvataggio metadati cinematografici (regista, anno, cast, voto, distribuzione).
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

/**
 * Registra il metabox per la scheda film all'interno della schermata di modifica degli articoli.
 */
function cinephile_add_film_metabox() {
	add_meta_box(
		'cinephile_film_box',
		__( '🎬 Scheda Film & Dati Strutturati SEO', 'cinephile' ),
		'cinephile_film_metabox_html',
		'post',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'cinephile_add_film_metabox' );

/* Gli stili del metabox sono ora caricati via assets/css/admin.css in setup.php (cinephile_admin_scripts). */

/**
 * Renderizza il codice HTML del metabox nel backend editor.
 *
 * @param WP_Post $post Oggetto post corrente.
 */
function cinephile_film_metabox_html( $post ) {
	// Recupero dei metadati esistenti con fallback stringa vuota
	$regista       = get_post_meta( $post->ID, '_film_regista', true );
	$anno          = get_post_meta( $post->ID, '_film_anno', true );
	$durata        = get_post_meta( $post->ID, '_film_durata', true );
	$genere        = get_post_meta( $post->ID, '_film_genere', true );
	$cast          = get_post_meta( $post->ID, '_film_cast', true );
	$distribuzione = get_post_meta( $post->ID, '_film_distribuzione', true );
	$voto          = get_post_meta( $post->ID, '_film_voto', true );

	// Campo di sicurezza Nonce per validare la provenienza della richiesta al salvataggio
	wp_nonce_field( 'cinephile_save_film_meta', 'cinephile_film_nonce' );
	?>

	<div class="film-metabox-wrapper">
		<div class="film-metabox-notice">
			ℹ️ <?php echo wp_kses_post( __( '<strong>Campi Facoltativi:</strong> Se compilati, generano automaticamente la Card visibile nell\'articolo e i microdati Schema.org SEO per i motori di ricerca.', 'cinephile' ) ); ?>
		</div>

		<div class="film-metabox-grid">
			<div class="film-meta-field">
				<label for="film_regista"><?php esc_html_e( '🎬 Regista:', 'cinephile' ); ?></label>
				<input type="text" id="film_regista" name="film_regista" value="<?php echo esc_attr( $regista ); ?>" placeholder="<?php esc_attr_e( 'Es. Christopher Nolan', 'cinephile' ); ?>">
			</div>

			<div class="film-meta-field">
				<label for="film_anno"><?php esc_html_e( '📅 Anno di Uscita:', 'cinephile' ); ?></label>
				<input type="text" id="film_anno" name="film_anno" value="<?php echo esc_attr( $anno ); ?>" placeholder="<?php esc_attr_e( 'Es. 2026', 'cinephile' ); ?>">
			</div>

			<div class="film-meta-field">
				<label for="film_durata"><?php esc_html_e( '⏱️ Durata (in minuti):', 'cinephile' ); ?></label>
				<input type="text" id="film_durata" name="film_durata" value="<?php echo esc_attr( $durata ); ?>" placeholder="<?php esc_attr_e( 'Es. 124', 'cinephile' ); ?>">
			</div>

			<div class="film-meta-field">
				<label for="film_genere"><?php esc_html_e( '🎭 Genere:', 'cinephile' ); ?></label>
				<input type="text" id="film_genere" name="film_genere" value="<?php echo esc_attr( $genere ); ?>" placeholder="<?php esc_attr_e( 'Es. Drammatico, Fantascienza', 'cinephile' ); ?>">
			</div>

			<div class="film-meta-field">
				<label for="film_voto"><?php esc_html_e( '⭐ Valutazione Film:', 'cinephile' ); ?></label>
				<select id="film_voto" name="film_voto">
					<option value=""><?php esc_html_e( '-- Nessun Voto --', 'cinephile' ); ?></option>
					<?php
					// Array esplicito: evita problemi di precisione float nelle etichette dei valori.
					foreach ( array( '1', '1.5', '2', '2.5', '3', '3.5', '4', '4.5', '5' ) as $voto_val ) :
					?>
						<option value="<?php echo esc_attr( $voto_val ); ?>" <?php selected( $voto, $voto_val ); ?>><?php echo esc_html( $voto_val ); ?> ⭐</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="film-meta-field film-meta-full">
			<label for="film_cast"><?php esc_html_e( '👥 Cast Principale:', 'cinephile' ); ?></label>
			<input type="text" id="film_cast" name="film_cast" value="<?php echo esc_attr( $cast ); ?>" placeholder="<?php esc_attr_e( 'Es. Cillian Murphy, Emily Blunt', 'cinephile' ); ?>">
		</div>

		<div class="film-meta-field film-meta-full">
			<label for="film_distribuzione"><?php esc_html_e( '🍿 Distribuzione / Piattaforma:', 'cinephile' ); ?></label>
			<input type="text" id="film_distribuzione" name="film_distribuzione" value="<?php echo esc_attr( $distribuzione ); ?>" placeholder="<?php esc_attr_e( 'Es. Cinema, Netflix, Prime Video', 'cinephile' ); ?>">
		</div>
	</div>
	<?php
}

/**
 * Gestisce il salvataggio dei campi del metabox previa sanitizzazione e controlli di sicurezza.
 *
 * @param int $post_id ID del post salvato.
 */
function cinephile_save_film_metabox( $post_id ) {
	// 1. Verifica Nonce Security Token
	if ( ! isset( $_POST['cinephile_film_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cinephile_film_nonce'] ) ), 'cinephile_save_film_meta' ) ) {
		return;
	}

	// 2. Esclude autosalvataggi e revisioni
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) || 'post' !== get_post_type( $post_id ) ) {
		return;
	}

	// 3. Controllo Permessi Utente
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// 4. Sanitizzazione e salvataggio dei campi di testo
	$text_fields = array( 'film_regista', 'film_anno', 'film_genere', 'film_cast', 'film_distribuzione' );
	foreach ( $text_fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, '_' . $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	// 5. Sanitizzazione valore intero della durata
	if ( isset( $_POST['film_durata'] ) ) {
		update_post_meta( $post_id, '_film_durata', absint( wp_unslash( $_POST['film_durata'] ) ) );
	}

	// 6. Whitelist per il voto
	if ( isset( $_POST['film_voto'] ) ) {
		$voto_raw     = sanitize_text_field( wp_unslash( $_POST['film_voto'] ) );
		$allowed_voti = array( '1', '1.5', '2', '2.5', '3', '3.5', '4', '4.5', '5' );

		if ( in_array( $voto_raw, $allowed_voti, true ) ) {
			update_post_meta( $post_id, '_film_voto', $voto_raw );
		} else {
			delete_post_meta( $post_id, '_film_voto' );
		}
	}
}
add_action( 'save_post', 'cinephile_save_film_metabox' );
