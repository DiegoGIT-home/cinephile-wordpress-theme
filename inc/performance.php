<?php
/**
 * Modulo Prestazioni e Caching (Transient API)
 *
 * Pulizia bloatware nativo (Emoji/Embed) e caching delle query complesse della Home Page.
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

/* ==========================================================================
   1. DISABILITAZIONE BLOATWARE NATIVO
   ========================================================================== */

/**
 * Rimuove script e stili nativi legati alle Emoji di WordPress per risparmiare richieste HTTP.
 */
function cinephile_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'cinephile_disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'cinephile_disable_emojis_dns_prefetch', 10, 2 );
}
add_action( 'init', 'cinephile_disable_emojis' );

function cinephile_disable_emojis_tinymce( $plugins ) {
	return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
}

function cinephile_disable_emojis_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/' );
		foreach ( $urls as $key => $url ) {
			if ( false !== strpos( $url, $emoji_svg_url ) ) {
				unset( $urls[ $key ] );
			}
		}
	}
	return $urls;
}

/**
 * Deregistra lo script wp-embed nel footer per ridurre il peso delle pagine.
 */
function cinephile_deregister_embed_script() {
	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'cinephile_deregister_embed_script' );


/* ==========================================================================
   2. GESTIONE CACHE HOMEPAGE VIA TRANSIENT API
   ========================================================================== */

/**
 * Restituisce la lista delle chiavi degli slot posizionali della Home.
 */
function cinephile_get_home_slot_keys() {
	return array(
		'hero_main',
		'hero_side_1', 'hero_side_2', 'hero_side_3',
		'horiz_1', 'horiz_2', 'horiz_3', 'horiz_4',
	);
}

/**
 * Carica gli oggetti WP_Post associati agli ID memorizzati in cache.
 */
function cinephile_hydrate_slot_posts( $slot_ids ) {
	if ( empty( $slot_ids ) || ! is_array( $slot_ids ) ) {
		return array();
	}

	$posts = get_posts( array(
		'post_type'              => 'post',
		'post_status'            => 'publish',
		'posts_per_page'         => count( $slot_ids ),
		'post__in'               => array_values( $slot_ids ),
		'orderby'                => 'post__in',
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
	) );

	$posts_by_id = array();
	foreach ( $posts as $post_obj ) {
		$posts_by_id[ $post_obj->ID ] = $post_obj;
	}

	$slot_posts = array();
	foreach ( $slot_ids as $slot_key => $post_id ) {
		if ( isset( $posts_by_id[ $post_id ] ) ) {
			$slot_posts[ $slot_key ] = $posts_by_id[ $post_id ];
		}
	}

	return $slot_posts;
}

/**
 * Ottiene gli articoli per i layout della Home, sfruttando la Transient API per limitare le query al DB.
 */
function cinephile_get_home_slot_posts() {
	$cache_key = 'cc_home_slot_ids';
	$slot_ids  = get_transient( $cache_key );

	if ( false !== $slot_ids && is_array( $slot_ids ) ) {
		return cinephile_hydrate_slot_posts( $slot_ids );
	}

	$all_slots   = cinephile_get_home_slot_keys();
	$slot_ids    = array();
	$exclude_ids = array();

	$assigned_query = new WP_Query( array(
		'post_type'              => 'post',
		'post_status'            => 'publish',
		'posts_per_page'         => 8,
		'fields'                 => 'ids',
		'no_found_rows'          => true,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => true,
		'meta_query'             => array(
			array(
				'key'     => '_home_slot',
				'compare' => 'EXISTS',
			),
		),
	) );

	foreach ( $assigned_query->posts as $assigned_id ) {
		$slot_val = get_post_meta( $assigned_id, '_home_slot', true );
		if ( in_array( $slot_val, $all_slots, true ) && ! isset( $slot_ids[ $slot_val ] ) ) {
			$slot_ids[ $slot_val ] = (int) $assigned_id;
			$exclude_ids[]         = (int) $assigned_id;
		}
	}
	wp_reset_postdata();

	$empty_slots = array();
	foreach ( $all_slots as $slot_key ) {
		if ( ! isset( $slot_ids[ $slot_key ] ) ) {
			$empty_slots[] = $slot_key;
		}
	}

	if ( ! empty( $empty_slots ) ) {
		$fill_query = new WP_Query( array(
			'post_type'              => 'post',
			'post_status'            => 'publish',
			'posts_per_page'         => count( $empty_slots ),
			'post__not_in'           => $exclude_ids,
			'orderby'                => 'date',
			'order'                  => 'DESC',
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		) );

		foreach ( $fill_query->posts as $index => $fill_id ) {
			if ( isset( $empty_slots[ $index ] ) ) {
				$slot_ids[ $empty_slots[ $index ] ] = (int) $fill_id;
			}
		}
		wp_reset_postdata();
	}

	// Salva in Transient per 1 ora
	set_transient( $cache_key, $slot_ids, HOUR_IN_SECONDS );

	return cinephile_hydrate_slot_posts( $slot_ids );
}

/**
 * Restituisce gli slot posizionali della Home attualmente occupati dagli articoli.
 * Utilizzato da metabox-positions.php per mostrare lo stato degli slot nell'editor.
 *
 * @return array Mappa degli slot occupati [ 'slot_key' => ['post_id' => int, 'title' => string] ].
 */
function cinephile_get_occupied_home_slots() {
	$cache_key      = 'cc_occupied_home_slots';
	$occupied_slots = get_transient( $cache_key );

	if ( false !== $occupied_slots && is_array( $occupied_slots ) ) {
		return $occupied_slots;
	}

	$all_slots      = cinephile_get_home_slot_keys();
	$occupied_slots = array();

	$query = new WP_Query( array(
		'post_type'              => 'post',
		'post_status'            => array( 'publish', 'draft', 'future' ),
		'posts_per_page'         => 50,
		'fields'                 => 'ids',
		'no_found_rows'          => true,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => true,
		'meta_query'             => array(
			array(
				'key'     => '_home_slot',
				'compare' => 'EXISTS',
			),
		),
	) );

	if ( $query->have_posts() ) {
		foreach ( $query->posts as $p_id ) {
			$slot_val = get_post_meta( $p_id, '_home_slot', true );
			if ( in_array( $slot_val, $all_slots, true ) ) {
				$occupied_slots[ $slot_val ] = array(
					'post_id' => (int) $p_id,
					'title'   => get_the_title( $p_id ),
				);
			}
		}
	}
	wp_reset_postdata();

	set_transient( $cache_key, $occupied_slots, HOUR_IN_SECONDS );

	return $occupied_slots;
}


/* ==========================================================================
   3. INVALIDAZIONE CACHE SU SALVATAGGIO O ELIMINAZIONE POST
   ========================================================================== */

/**
 * Svuota i transient memorizzati all'aggiornamento o eliminazione di un articolo.
 *
 * @param int $post_id ID del post.
 */
function cinephile_invalidate_theme_caches( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	if ( 'post' !== get_post_type( $post_id ) ) {
		return;
	}

	delete_transient( 'cc_home_slot_ids' );
	delete_transient( 'cc_occupied_home_slots' );
	delete_transient( 'cinephile_about_team_users' );
}
add_action( 'save_post', 'cinephile_invalidate_theme_caches' );
add_action( 'delete_post', 'cinephile_invalidate_theme_caches' );


/* ==========================================================================
   4. OTTIMIZZAZIONE RISORSE SERVER (HEARTBEAT, REVISIONI & PINGBACKS)
   ========================================================================== */

/**
 * Disabilita la Heartbeat API sul frontend per utenti non loggati
 * per evitare chiamate ripetute ad admin-ajax.php su hosting condivisi.
 */
function cinephile_disable_frontend_heartbeat() {
	if ( ! is_user_logged_in() ) {
		wp_deregister_script( 'heartbeat' );
	}
}
add_action( 'init', 'cinephile_disable_frontend_heartbeat', 1 );

/**
 * Riduce la frequenza della Heartbeat API nell'area amministrativa a 60 secondi
 * (invece dei 15 secondi standard), preservando i "CPU seconds" della quota hosting.
 *
 * @param array $settings Impostazioni Heartbeat.
 * @return array Impostazioni con intervallo calibrato.
 */
function cinephile_throttle_heartbeat( $settings ) {
	$settings['interval'] = 60;
	return $settings;
}
add_filter( 'heartbeat_settings', 'cinephile_throttle_heartbeat' );

/**
 * Limita le revisioni degli articoli a massimo 5 copie salvate nel database.
 * Previene il sovradimensionamento delle tabelle wp_posts e wp_postmeta su dischi lenti.
 *
 * @param int     $num  Numero di revisioni attuali consentite.
 * @param WP_Post $post Oggetto articolo in fase di salvataggio.
 * @return int Tetto massimo revisioni.
 */
function cinephile_limit_post_revisions( $num, $post ) {
	return 5;
}
add_filter( 'wp_revisions_to_keep', 'cinephile_limit_post_revisions', 10, 2 );

/**
 * Disabilita i pingback interni verso il proprio dominio (self-pingbacks),
 * evitando che WordPress avvii richieste HTTP a se stesso al salvataggio degli articoli.
 *
 * @param array $links Array di URL target del ping.
 */
function cinephile_disable_self_pingbacks( &$links ) {
	$home = get_option( 'home' );
	foreach ( $links as $l => $link ) {
		if ( 0 === strpos( $link, $home ) ) {
			unset( $links[ $l ] );
		}
	}
}
add_action( 'pre_ping', 'cinephile_disable_self_pingbacks' );


/* ==========================================================================
   5. ALLEGGERIMENTO ASSET FRONTEND (DASHICONS, JQUERY MIGRATE & STILI CORE)
   ========================================================================== */

/**
 * Rimuove Dashicons dal frontend per i visitatori non autenticati (risparmia ~30KB).
 */
function cinephile_dequeue_dashicons_guests() {
	if ( ! is_user_logged_in() ) {
		wp_deregister_style( 'dashicons' );
	}
}
add_action( 'wp_enqueue_scripts', 'cinephile_dequeue_dashicons_guests', 20 );

/**
 * Rimuove jQuery Migrate dal frontend se jQuery viene caricato, eliminando uno script ridondante.
 *
 * @param WP_Scripts $scripts Oggetto globale degli script registrati.
 */
function cinephile_remove_jquery_migrate( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
		$script = $scripts->registered['jquery'];
		if ( $script->deps ) {
			$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
		}
	}
}
add_action( 'wp_default_scripts', 'cinephile_remove_jquery_migrate' );

/**
 * Rimuove stili core di WordPress non necessari ai layout del tema:
 * - classic-theme-styles su tutto il frontend
 * - libreria blocchi Gutenberg (wp-block-library) in Homepage, essendo un template 100% PHP
 */
function cinephile_dequeue_unused_core_styles() {
	wp_dequeue_style( 'classic-theme-styles' );

	if ( is_front_page() ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
	}
}
add_action( 'wp_enqueue_scripts', 'cinephile_dequeue_unused_core_styles', 100 );


/* ==========================================================================
   6. PRELOAD NATIVO FONT WOFF2 (CORE WEB VITALS - ZERO FOUT / ZERO CLS)
   ========================================================================== */

/**
 * Inietta tag <link rel="preload"> nell'head HTML per i file WOFF2 dei font attivi nel Customizer.
 * Avvia il download al byte 1, azzerando il Flash of Unstyled Text e accelerando il First Contentful Paint.
 */
function cinephile_preload_active_fonts() {
	$font_map = array(
		'playfair'     => 'playfair-display-v40-latin-regular.woff2',
		'lora'         => 'lora-v37-latin-regular.woff2',
		'cinzel'       => 'cinzel-v26-latin-regular.woff2',
		'plus_jakarta' => 'plus-jakarta-sans-v12-latin-regular.woff2',
		'inter'        => 'inter-v20-latin-regular.woff2',
		'outfit'       => 'outfit-v15-latin-regular.woff2',
	);

	$title_font = get_theme_mod( 'font_family_title', 'playfair' );
	$body_font  = get_theme_mod( 'font_family_body', 'plus_jakarta' );

	$fonts_to_preload = array();
	if ( isset( $font_map[ $title_font ] ) ) {
		$fonts_to_preload[ $font_map[ $title_font ] ] = true;
	}
	if ( isset( $font_map[ $body_font ] ) ) {
		$fonts_to_preload[ $font_map[ $body_font ] ] = true;
	}

	$fonts_dir_uri = get_template_directory_uri() . '/assets/fonts/';

	foreach ( array_keys( $fonts_to_preload ) as $font_file ) {
		echo '<link rel="preload" href="' . esc_url( $fonts_dir_uri . $font_file ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
	}
}
add_action( 'wp_head', 'cinephile_preload_active_fonts', 1 );


/* ==========================================================================
   7. CACHE TRANSIENT SQUADRA EDITORIALE (PAGINA CHI SIAMO)
   ========================================================================== */

/**
 * Restituisce gli utenti con ruolo editoriale memorizzati in cache transient per 12 ore.
 * Riduce a zero le query alla tabella utenti durante le visite alla pagina Chi Siamo.
 *
 * @return array Array di oggetti WP_User.
 */
function cinephile_get_about_team_users() {
	$cache_key = 'cinephile_about_team_users';
	$authors   = get_transient( $cache_key );

	if ( false !== $authors && is_array( $authors ) ) {
		return $authors;
	}

	$authors = get_users( array(
		'role__in' => array( 'administrator', 'editor', 'author' ),
		'orderby'  => 'post_count',
		'order'    => 'DESC',
	) );

	set_transient( $cache_key, $authors, 12 * HOUR_IN_SECONDS );

	return $authors;
}

/**
 * Invalida la cache degli autori al cambio di profilo o registrazione utente.
 */
function cinephile_invalidate_team_users_cache() {
	delete_transient( 'cinephile_about_team_users' );
}
add_action( 'profile_update', 'cinephile_invalidate_team_users_cache' );
add_action( 'user_register', 'cinephile_invalidate_team_users_cache' );
add_action( 'deleted_user', 'cinephile_invalidate_team_users_cache' );

