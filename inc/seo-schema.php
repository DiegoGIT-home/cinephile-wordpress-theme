<?php
/**
 * Modulo SEO Nativo & Microdati Schema.org (JSON-LD)
 *
 * Generazione automatica di microdati per Google (Review, Movie, Breadcrumbs) e Meta Tag Open Graph / Twitter.
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
 * Personalizza i titoli della scheda browser per articoli e recensioni.
 */
function cinephile_custom_title_parts( $title_parts ) {
	if ( is_front_page() || is_home() ) {
		$title_parts['title']   = get_bloginfo( 'name' );
		$title_parts['tagline'] = __( 'Rivista di critica e cultura cinematografica', 'cinephile' );
		unset( $title_parts['site'] );
	} elseif ( is_singular( 'post' ) ) {
		$post_id = get_queried_object_id();
		$regista = get_post_meta( $post_id, '_film_regista', true );
		if ( ! empty( $regista ) ) {
			/* translators: %s: nome del regista */
			$title_parts['title'] = get_the_title( $post_id ) . ' ' . sprintf( __( '(Regia di %s)', 'cinephile' ), $regista );
		}
	}
	return $title_parts;
}
add_filter( 'document_title_parts', 'cinephile_custom_title_parts', 10, 1 );

/**
 * Rimuove il tag canonical nativo duplicato di WordPress per usare quello controllato dal tema.
 */
remove_action( 'wp_head', 'rel_canonical' );

/**
 * Inietta i dati strutturati Schema.org JSON-LD nell'head delle pagine.
 */
function cinephile_schema_review_markup() {
	// 1. Homepage: Sitelinks Search Box
	if ( is_front_page() || is_home() ) {
		$website_schema = array(
			'@context'        => 'https://schema.org',
			'@type'           => 'WebSite',
			'name'            => get_bloginfo( 'name' ),
			'url'             => home_url( '/' ),
			'potentialAction' => array(
				'@type'       => 'SearchAction',
				'target'      => home_url( '/?s={search_term_string}' ),
				'query-input' => 'required name=search_term_string',
			),
		);
		echo "\n<script type=\"application/ld+json\">" . wp_json_encode( $website_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
	}

	// 2. Articolo Singolo: Schema Review/Movie oppure Article + BreadcrumbList
	if ( is_singular( 'post' ) ) {
		$post_id   = get_the_ID();
		$voto      = get_post_meta( $post_id, '_film_voto', true );
		$titolo    = get_the_title( $post_id );
		$autore    = get_the_author_meta( 'display_name', get_post_field( 'post_author', $post_id ) );
		$data_pub  = get_the_date( 'c', $post_id );
		$data_mod  = get_the_modified_date( 'c', $post_id );
		$thumb_url = get_the_post_thumbnail_url( $post_id, 'full' );

		$excerpt = get_the_excerpt( $post_id );
		if ( empty( $excerpt ) ) {
			$excerpt = wp_strip_all_tags( strip_shortcodes( get_post_field( 'post_content', $post_id ) ) );
			$excerpt = mb_substr( $excerpt, 0, 160 );
		}
		$clean_desc = trim( preg_replace( '/\s+/', ' ', $excerpt ) );

		$publisher_schema = array(
			'@type' => 'Organization',
			'name'  => get_bloginfo( 'name' ),
			'url'   => home_url( '/' ),
			'logo'  => array(
				'@type' => 'ImageObject',
				'url'   => get_theme_file_uri( '/assets/img/cinephile-logo.png' ),
			),
		);

		if ( ! empty( $voto ) ) {
			$regista = get_post_meta( $post_id, '_film_regista', true );
			$anno    = get_post_meta( $post_id, '_film_anno', true );
			$genere  = get_post_meta( $post_id, '_film_genere', true );
			$cast    = get_post_meta( $post_id, '_film_cast', true );

			$item_reviewed = array(
				'@type' => 'Movie',
				'name'  => $titolo,
			);

			if ( ! empty( $thumb_url ) ) {
				$item_reviewed['image'] = $thumb_url;
			}
			if ( ! empty( $regista ) ) {
				$item_reviewed['director'] = array(
					'@type' => 'Person',
					'name'  => $regista,
				);
			}
			if ( ! empty( $anno ) ) {
				$item_reviewed['dateCreated'] = $anno;
			}
			if ( ! empty( $genere ) ) {
				$item_reviewed['genre'] = $genere;
			}
			if ( ! empty( $cast ) ) {
				$actors      = explode( ',', $cast );
				$actor_array = array();
				foreach ( $actors as $actor ) {
					$trimmed = trim( $actor );
					if ( ! empty( $trimmed ) ) {
						$actor_array[] = array(
							'@type' => 'Person',
							'name'  => $trimmed,
						);
					}
				}
				if ( ! empty( $actor_array ) ) {
					$item_reviewed['actor'] = $actor_array;
				}
			}

			$schema = array(
				'@context'      => 'https://schema.org',
				'@type'         => 'Review',
				'itemReviewed'  => $item_reviewed,
				'reviewRating'  => array(
					'@type'       => 'Rating',
					'ratingValue' => (float) $voto,
					'bestRating'  => 5,
					'worstRating' => 1,
				),
				'author'        => array(
					'@type' => 'Person',
					'name'  => $autore,
				),
				'publisher'     => $publisher_schema,
				'datePublished' => $data_pub,
				'dateModified'  => $data_mod,
				'description'   => $clean_desc,
				'inLanguage'    => get_bloginfo( 'language' ),
			);
		} else {
			$schema = array(
				'@context'         => 'https://schema.org',
				'@type'            => 'Article',
				'headline'         => $titolo,
				'datePublished'    => $data_pub,
				'dateModified'     => $data_mod,
				'mainEntityOfPage' => get_permalink( $post_id ),
				'author'           => array(
					'@type' => 'Person',
					'name'  => $autore,
				),
				'publisher'        => $publisher_schema,
				'description'      => $clean_desc,
				'inLanguage'       => get_bloginfo( 'language' ),
			);

			if ( $thumb_url ) {
				$schema['image'] = $thumb_url;
			}
		}

		echo "\n<script type=\"application/ld+json\">" . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";

		// Schema Breadcrumbs
		$categories = get_the_category( $post_id );
		$cat_name   = ! empty( $categories ) ? $categories[0]->name : __( 'Articoli', 'cinephile' );
		$cat_url    = ! empty( $categories ) ? get_category_link( $categories[0]->term_id ) : home_url( '/' );

		$breadcrumb_schema = array(
			'@context'        => 'https://schema.org',
			'@type'           => 'BreadcrumbList',
			'itemListElement' => array(
				array(
					'@type'    => 'ListItem',
					'position' => 1,
					'name'     => __( 'Home', 'cinephile' ),
					'item'     => home_url( '/' ),
				),
				array(
					'@type'    => 'ListItem',
					'position' => 2,
					'name'     => $cat_name,
					'item'     => $cat_url,
				),
				array(
					'@type'    => 'ListItem',
					'position' => 3,
					'name'     => $titolo,
					'item'     => get_permalink( $post_id ),
				),
			),
		);
		echo "<script type=\"application/ld+json\">" . wp_json_encode( $breadcrumb_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
	}
}
add_action( 'wp_head', 'cinephile_schema_review_markup' );

/**
 * Inietta meta tag Open Graph, Twitter Cards e Direttive Robots avanzate per Google.
 */
function cinephile_seo_meta_tags() {
	$site_name = get_bloginfo( 'name' );
	$title     = get_bloginfo( 'name' );
	$desc      = wp_strip_all_tags( get_bloginfo( 'description' ) );
	$url       = home_url( '/' );
	$type      = 'website';
	$img_url   = '';
	$img_w     = 0;
	$img_h     = 0;

	if ( is_single() || is_page() ) {
		$post_id = get_queried_object_id();
		if ( $post_id ) {
			$post_obj = get_post( $post_id );
			$type     = 'article';
			$title    = get_the_title( $post_id );
			$url      = get_permalink( $post_id );

			$excerpt = get_the_excerpt( $post_id );
			if ( empty( $excerpt ) ) {
				$excerpt = wp_strip_all_tags( strip_shortcodes( $post_obj->post_content ) );
				$excerpt = mb_substr( $excerpt, 0, 155 );
			}
			$desc = trim( preg_replace( '/\s+/', ' ', $excerpt ) );

			if ( has_post_thumbnail( $post_id ) ) {
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'large' );
				if ( $thumb ) {
					$img_url = $thumb[0];
					$img_w   = $thumb[1];
					$img_h   = $thumb[2];
				}
			}
		}
	}

	// Meta Robots avanzato: Google Discover & Snippet Richieste
	if ( is_404() || is_search() ) {
		echo '<meta name="robots" content="noindex, follow">' . "\n";
	} else {
		echo '<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">' . "\n";
	}

	echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";

	// Open Graph (Facebook, WhatsApp, LinkedIn, Telegram)
	echo '<meta property="og:locale" content="' . esc_attr( get_locale() ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '">' . "\n";
	echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";

	if ( ! empty( $img_url ) ) {
		echo '<meta property="og:image" content="' . esc_url( $img_url ) . '">' . "\n";
		if ( $img_w > 0 && $img_h > 0 ) {
			echo '<meta property="og:image:width" content="' . absint( $img_w ) . '">' . "\n";
			echo '<meta property="og:image:height" content="' . absint( $img_h ) . '">' . "\n";
		}
		echo '<meta name="twitter:image" content="' . esc_url( $img_url ) . '">' . "\n";
	}

	// Twitter / X Cards
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
}
add_action( 'wp_head', 'cinephile_seo_meta_tags', 1 );

/**
 * Generazione automatica dell'attributo ALT mancante per le immagini allegate agli articoli.
 */
function cinephile_auto_image_alt( $attr, $attachment, $size ) {
	if ( empty( $attr['alt'] ) ) {
		$post_id   = get_the_ID();
		$site_name = get_bloginfo( 'name' );
		$attr['alt'] = $post_id ? esc_attr( get_the_title( $post_id ) . ' - ' . $site_name ) : esc_attr( $site_name );
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'cinephile_auto_image_alt', 10, 3 );

/**
 * Ottimizzazione automatica del file virtuale robots.txt.
 */
function cinephile_custom_robots( $output, $public ) {
	if ( $public ) {
		$output .= "Disallow: /wp-admin/\n";
		$output .= "Allow: /wp-admin/admin-ajax.php\n";
		$output .= "Disallow: /?s=\n";
		$output .= "Disallow: /search/\n";
		$output .= "Sitemap: " . esc_url( home_url( '/wp-sitemap.xml' ) ) . "\n";
	}
	return $output;
}
add_filter( 'robots_txt', 'cinephile_custom_robots', 10, 2 );
