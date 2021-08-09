<?php
/**
 * Plugin Name: Vitamin Disable Feeds
 * Description: Remove all feeds from WordPress
 * Author: Vitamin
 * Version: 1.0.0
 * Author: Vitamin
 * Author URI: https://vitaminisgood.com
 * Author URI: https://vitaminisgood.com
 * GitHub Plugin URI: vitamin-dev/vitamin-disable-feeds
 *
 * @package Vitamin\Plugins\Disable_Feeds
 * @author Vitamin
 */

/**
 * Head RSS Links
 *
 * Removes rss link actions from wp_head
 */
function v_rss_wp_head() {
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
}
add_action( 'wp_head', 'v_rss_wp_head', 1 );

/**
 * Redirect RSS
 */
function v_rss_remove_feeds() {
	wp_safe_redirect( home_url(), 302 );
	exit();
}
foreach ( [ 'rdf', 'rss', 'rss2', 'atom' ] as $feed ) {
	add_action( 'do_feed_' . $feed, 'v_rss_remove_feeds', 1 );
}
unset( $feed );

/**
 * Remove RSS Endpoint
 */
function v_rss_kill_feed_endpoint() {
	global $wp_rewrite;
	$wp_rewrite->feeds = array();
}
add_action( 'init', 'v_rss_kill_feed_endpoint', 99 );

/**
 * Kill RSS Endpoint on Plugin Activation
 */
function v_rss_activation() {
	v_rss_kill_feed_endpoint();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'v_rss_activation' );
