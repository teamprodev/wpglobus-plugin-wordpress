<?php
/**
 * Plugin Name: Blog Layouts for Elementor
 * Description: Blog Layouts for Elementor - WordPress Plugin
 * Plugin URI: http://plugins.ad-theme.com/elementor/bloglayouts
 * Author: AD-Theme
 * Version: 1.0
 * Author URI: http://ad-theme.com/
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'BLE_DIR', plugin_dir_path( __FILE__ ) );
define( 'BLE_URL', plugin_dir_url( __FILE__ ) );
/**
 * Main Elementor Blog Layouts Class
 */
final class Elementor_Blog_Layouts {

	/**
	 * Plugin Version
	 *
	 * @since 1.2.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.2.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.2.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.3';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Load translation
		add_action( 'init', array( $this, 'i18n' ) );

		// Init Plugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );
		
		add_action( 'init', array( $this, 'bloglayouts_elementor_add_image_sizes' ) );
		
		add_filter( 'query_vars', array( $this, 'bloglayouts_elementor_pagination') );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'elementor-blog-layouts' );
	}


	/**
	 * Add Image Sizes
	 *
	 * @since 1.0.0
	 * @access public
	 */
	 public function bloglayouts_elementor_add_image_sizes() {

		add_image_size( 'bloglayouts-large', 1000, 800, true );
		add_image_size( 'bloglayouts-normal', 800 , 800 , true);
		add_image_size( 'bloglayouts-masonry', 500 );		
		add_image_size( 'bloglayouts-blog-large', 1600 , 914 , true);
		add_image_size( 'bloglayouts-blog-medium', 700 , 400 , true);
		add_image_size( 'bloglayouts-blog-medium-vertical', 700 , 800 , true);
		add_image_size( 'bloglayouts-blog-small', 325 , 235 , true);
		add_image_size( 'bloglayouts-posts-medium', 600, 500, true );
		add_image_size( 'bloglayouts-header', 800 , 600 , true);
		add_image_size( 'bloglayouts-vc-header-medium', 446 , 248 , true);
		add_image_size( 'bloglayouts-vc-header-small', 300 , 200 , true);
		add_image_size( 'bloglayouts-vc-posts-medium-large', 800 , 350 , true);	
		
	 }

	/**
	 * Add Pagination Var
	 *
	 * @since 1.0.0
	 * @access public
	 */
	 public function bloglayouts_elementor_pagination( $vars ){
		$vars[] = "fg_page";
		return $vars;
	 }

	/**
	 * Initialize the plugin
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'plugin.php' );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-blog-layouts' ),
			'<strong>' . esc_html__( 'Blog Layouts For Elementor', 'elementor-blog-layouts' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-blog-layouts' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-blog-layouts' ),
			'<strong>' . esc_html__( 'Blog Layouts For Elementor', 'elementor-blog-layouts' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-blog-layouts' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-blog-layouts' ),
			'<strong>' . esc_html__( 'Blog Layouts For Elementor', 'elementor-blog-layouts' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-blog-layouts' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

// Instantiate Elementor_Blog_Layouts.
new Elementor_Blog_Layouts();
