<?php
/**
 * SEO básico propio: meta description, Open Graph, Twitter Card y JSON-LD.
 * Deliberadamente no depende de Yoast/RankMath — ver .claude/CLAUDE.md "Decisiones y Quirks".
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Descripción para <meta name="description"> y para OG/Twitter.
 */
function flowdesk_seo_description() {
	if ( is_singular() && has_excerpt() ) {
		return wp_strip_all_tags( get_the_excerpt() );
	}
	if ( is_singular() ) {
		return wp_trim_words( wp_strip_all_tags( get_the_content() ), 30 );
	}
	if ( is_category() || is_tag() ) {
		return wp_strip_all_tags( term_description() ) ?: get_bloginfo( 'description' );
	}
	return get_bloginfo( 'description' ) ?: __( 'FlowDesk — organizá el trabajo de tu equipo sin fricción.', 'flowdesk' );
}

function flowdesk_seo_image() {
	if ( is_singular() && has_post_thumbnail() ) {
		return get_the_post_thumbnail_url( get_the_ID(), 'large' );
	}
	$default = get_theme_mod( 'flowdesk_default_og_image' );
	return $default ?: FLOWDESK_THEME_URI . '/assets/images/og-default.jpg';
}

/**
 * Meta tags + OG + Twitter Card en <head>.
 */
function flowdesk_output_meta_tags() {
	$description = esc_attr( flowdesk_seo_description() );
	$image       = esc_url( flowdesk_seo_image() );
	$url         = esc_url( is_singular() ? get_permalink() : home_url( add_query_arg( array(), $GLOBALS['wp']->request ) ) );
	$title       = esc_attr( wp_get_document_title() );
	$site_name   = esc_attr( get_bloginfo( 'name' ) );

	echo "\n<!-- FlowDesk SEO -->\n";
	echo '<meta name="description" content="' . $description . '" />' . "\n";
	echo '<meta property="og:type" content="' . ( is_singular( 'post' ) ? 'article' : 'website' ) . '" />' . "\n";
	echo '<meta property="og:title" content="' . $title . '" />' . "\n";
	echo '<meta property="og:description" content="' . $description . '" />' . "\n";
	echo '<meta property="og:url" content="' . $url . '" />' . "\n";
	echo '<meta property="og:image" content="' . $image . '" />' . "\n";
	echo '<meta property="og:site_name" content="' . $site_name . '" />' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
	echo '<meta name="twitter:title" content="' . $title . '" />' . "\n";
	echo '<meta name="twitter:description" content="' . $description . '" />' . "\n";
	echo '<meta name="twitter:image" content="' . $image . '" />' . "\n";
}
add_action( 'wp_head', 'flowdesk_output_meta_tags', 1 );

/**
 * JSON-LD: Organization/SoftwareApplication en el home, Article en posts.
 */
function flowdesk_output_schema() {
	$graphs = array();

	$graphs[] = array(
		'@type' => 'Organization',
		'@id'   => home_url( '/#organization' ),
		'name'  => get_bloginfo( 'name' ),
		'url'   => home_url( '/' ),
		'logo'  => flowdesk_seo_image(),
	);

	if ( is_front_page() ) {
		$graphs[] = array(
			'@type'           => 'SoftwareApplication',
			'name'            => get_bloginfo( 'name' ),
			'applicationCategory' => 'BusinessApplication',
			'operatingSystem' => 'Web',
			'description'     => flowdesk_seo_description(),
			'offers'          => array(
				'@type'         => 'AggregateOffer',
				'priceCurrency' => 'USD',
				'lowPrice'      => '0',
				'highPrice'     => '49',
			),
		);
	}

	if ( is_singular( 'post' ) ) {
		$graphs[] = array(
			'@type'            => 'BlogPosting',
			'headline'         => get_the_title(),
			'description'      => flowdesk_seo_description(),
			'image'            => flowdesk_seo_image(),
			'datePublished'    => get_the_date( 'c' ),
			'dateModified'     => get_the_modified_date( 'c' ),
			'author'           => array(
				'@type' => 'Person',
				'name'  => get_the_author(),
			),
			'mainEntityOfPage' => get_permalink(),
		);
	}

	$schema = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graphs,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";
}
add_action( 'wp_head', 'flowdesk_output_schema', 2 );
