<?php
/**
 * Metabox Posizionamento in Homepage & Filtri Backend
 *
 * Assegnazione degli slot posizionali esclusivi della Home Page e gestione colonne personalizzate in edit.php.
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
 * Registra il metabox posizionale sulla barra laterale dell'editor.
 */
function cinephile_add_position_metabox() {
		add_meta_box(
				'cinephile_home_position',
				__( '📌 Slot Home Page', 'cinephile' ), // Titolo pulito e su singola riga
				'cinephile_position_metabox_html',
				'post',
				'side',
				'high'
			);
}
add_action( 'add_meta_boxes', 'cinephile_add_position_metabox' );

/**
 * Renderizza il selettore posizionale.
 */
function cinephile_position_metabox_html( $post ) {
	$slot = get_post_meta( $post->ID, '_home_slot', true );
	wp_nonce_field( 'cinephile_save_pos_meta', 'cinephile_pos_nonce' );

	$occupied_slots = cinephile_get_occupied_home_slots();

	$options = array(
		'primo_piano' => array(
			'label' => __( '1° Sezione: In Primo Piano', 'cinephile' ),
			'items' => array(
				'hero_main' => __( '⭐ In Primo Piano (Hero)', 'cinephile' ),
			),
		),
		'focus'       => array(
			'label' => __( '2° Sezione: Focus e Percorsi', 'cinephile' ),
			'items' => array(
				'hero_side_1' => __( '📌 Focus & Percorsi - 1° Slot', 'cinephile' ),
				'hero_side_2' => __( '📌 Focus & Percorsi - 2° Slot', 'cinephile' ),
				'hero_side_3' => __( '📌 Focus & Percorsi - 3° Slot', 'cinephile' ),
			),
		),
		'archivio'    => array(
			'label' => __( '3° Sezione: Dal nostro archivio', 'cinephile' ),
			'items' => array(
				'horiz_1' => __( '🔹 Archivio - 1° Slot', 'cinephile' ),
				'horiz_2' => __( '🔹 Archivio - 2° Slot', 'cinephile' ),
				'horiz_3' => __( '🔹 Archivio - 3° Slot', 'cinephile' ),
				'horiz_4' => __( '🔹 Archivio - 4° Slot', 'cinephile' ),
			),
		),
	);
	?>
	<div class="slot-metabox-container">
		<label for="home_slot_select" class="slot-label"><?php esc_html_e( 'Assegna Slot Home:', 'cinephile' ); ?></label>
		<select name="home_slot_select" id="home_slot_select" class="slot-select">
			<option value="" <?php selected( $slot, '' ); ?>><?php esc_html_e( '-- Normale (Flusso Cronologico) --', 'cinephile' ); ?></option>
			<?php foreach ( $options as $group ) : ?>
				<optgroup label="<?php echo esc_attr( $group['label'] ); ?>">
					<?php foreach ( $group['items'] as $key => $label ) :
						$is_current = ( $slot === $key && ! empty( $slot ) );
						$is_occ     = isset( $occupied_slots[ $key ] ) && (int) $occupied_slots[ $key ]['post_id'] !== (int) $post->ID;

						$suffix = '';
						if ( $is_current ) {
							$suffix = ' ' . __( '📍 [ATTUALE]', 'cinephile' );
						} elseif ( $is_occ ) {
							/* translators: %s: titolo dell'articolo che occupa lo slot */
							$suffix = ' ' . sprintf( __( '⚠️ [OCCUPATO: "%s"]', 'cinephile' ), $occupied_slots[ $key ]['title'] );
						}
						?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $slot, $key ); ?>>
							<?php echo esc_html( $label . $suffix ); ?>
						</option>
					<?php endforeach; ?>
				</optgroup>
			<?php endforeach; ?>
		</select>
		<p class="description slot-description"><?php esc_html_e( 'Se selezioni uno slot occupato, l\'articolo precedente verrà automaticamente riportato allo stato standard.', 'cinephile' ); ?></p>
	</div>
	<?php
}

/**
 * Salva la posizione, risolvendo i conflitti di assegnazione unica.
 */
function cinephile_save_position_metabox( $post_id ) {
	if ( ! isset( $_POST['cinephile_pos_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cinephile_pos_nonce'] ) ), 'cinephile_save_pos_meta' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) || 'post' !== get_post_type( $post_id ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['home_slot_select'] ) ) {
		$new_slot = sanitize_text_field( wp_unslash( $_POST['home_slot_select'] ) );

		if ( ! empty( $new_slot ) ) {
			$allowed_slots = cinephile_get_allowed_home_slots();
			if ( ! in_array( $new_slot, $allowed_slots, true ) ) {
				return;
			}

			// Rimuove lo slot da articoli precedenti per mantenere l'assegnazione singola
			$conflicts = get_posts( array(
				'post_type'              => 'post',
				'posts_per_page'         => 100,
				'fields'                 => 'ids',
				'post__not_in'           => array( $post_id ),
				'meta_key'               => '_home_slot',
				'meta_value'             => $new_slot,
				'no_found_rows'          => true,
				'update_post_term_cache' => false,
			) );

			foreach ( $conflicts as $conflict_id ) {
				if ( current_user_can( 'edit_post', $conflict_id ) ) {
					delete_post_meta( $conflict_id, '_home_slot' );
				}
			}
			update_post_meta( $post_id, '_home_slot', $new_slot );
		} else {
			delete_post_meta( $post_id, '_home_slot' );
		}
	}
}
add_action( 'save_post', 'cinephile_save_position_metabox' );

/**
 * Aggiunge la colonna custom nella tabella backend degli articoli.
 */
function cinephile_add_admin_column( $columns ) {
	$new_columns = array();
	foreach ( $columns as $key => $title ) {
		$new_columns[ $key ] = $title;
		if ( 'title' === $key ) {
			$new_columns['home_slot_col'] = __( 'Posizione Home', 'cinephile' );
		}
	}
	return $new_columns;
}
add_filter( 'manage_posts_columns', 'cinephile_add_admin_column' );

function cinephile_show_admin_column_content( $column_name, $post_ID ) {
	if ( 'home_slot_col' === $column_name ) {
		$slot   = get_post_meta( $post_ID, '_home_slot', true );
		$labels = array(
			'hero_main'   => __( '⭐ Primo Piano', 'cinephile' ),
			'hero_side_1' => __( '📌 Focus 1°', 'cinephile' ),
			'hero_side_2' => __( '📌 Focus 2°', 'cinephile' ),
			'hero_side_3' => __( '📌 Focus 3°', 'cinephile' ),
			'horiz_1'     => __( '🔹 Archivio 1°', 'cinephile' ),
			'horiz_2'     => __( '🔹 Archivio 2°', 'cinephile' ),
			'horiz_3'     => __( '🔹 Archivio 3°', 'cinephile' ),
			'horiz_4'     => __( '🔹 Archivio 4°', 'cinephile' ),
		);
		if ( ! empty( $slot ) && isset( $labels[ $slot ] ) ) {
			echo '<strong>' . esc_html( $labels[ $slot ] ) . '</strong>';
		} else {
			echo '<span class="slot-status-standard">' . esc_html__( 'Standard', 'cinephile' ) . '</span>';
		}
	}
}
add_action( 'manage_posts_custom_column', 'cinephile_show_admin_column_content', 10, 2 );

/**
 * Menu a tendina per filtrare la tabella articoli in base alla posizione Home.
 */
function cinephile_filter_by_home_slot_dropdown() {
	global $typenow;

	if ( 'post' === $typenow ) {
		$selected = isset( $_GET['filter_home_slot'] ) ? sanitize_text_field( wp_unslash( $_GET['filter_home_slot'] ) ) : '';

		$slots = array(
			'all_assigned' => __( '⭐ Tutti gli articoli in Home', 'cinephile' ),
			'hero_main'    => __( '⭐ In Primo Piano (Hero)', 'cinephile' ),
			'hero_side_1'  => __( '📌 Focus 1°', 'cinephile' ),
			'hero_side_2'  => __( '📌 Focus 2°', 'cinephile' ),
			'hero_side_3'  => __( '📌 Focus 3°', 'cinephile' ),
			'horiz_1'      => __( '🔹 Archivio 1°', 'cinephile' ),
			'horiz_2'      => __( '🔹 Archivio 2°', 'cinephile' ),
			'horiz_3'      => __( '🔹 Archivio 3°', 'cinephile' ),
			'horiz_4'      => __( '🔹 Archivio 4°', 'cinephile' ),
			'standard'     => __( '⚪ Solo Articoli Standard', 'cinephile' ),
		);
		?>
		<select name="filter_home_slot" id="filter_home_slot">
			<option value=""><?php esc_html_e( '-- Tutte le Posizioni Home --', 'cinephile' ); ?></option>
			<?php foreach ( $slots as $key => $label ) : ?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $selected, $key ); ?>>
					<?php echo esc_html( $label ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<?php
	}
}
add_action( 'restrict_manage_posts', 'cinephile_filter_by_home_slot_dropdown' );

function cinephile_filter_posts_by_home_slot( $query ) {
	global $pagenow;

	if ( is_admin() && 'edit.php' === $pagenow && $query->is_main_query() ) {
		if ( isset( $_GET['post_type'] ) && 'post' !== sanitize_key( wp_unslash( $_GET['post_type'] ) ) ) {
			return;
		}

		if ( ! empty( $_GET['filter_home_slot'] ) ) {
			$slot       = sanitize_text_field( wp_unslash( $_GET['filter_home_slot'] ) );
			$meta_query = (array) $query->get( 'meta_query' );

			if ( 'all_assigned' === $slot ) {
				$meta_query[] = array(
					'key'     => '_home_slot',
					'compare' => 'EXISTS',
				);
			} elseif ( 'standard' === $slot ) {
				$meta_query[] = array(
					'key'     => '_home_slot',
					'compare' => 'NOT EXISTS',
				);
			} else {
				$meta_query[] = array(
					'key'     => '_home_slot',
					'value'   => $slot,
					'compare' => '=',
				);
			}
			$query->set( 'meta_query', $meta_query );
		}
	}
}
add_action( 'pre_get_posts', 'cinephile_filter_posts_by_home_slot' );
