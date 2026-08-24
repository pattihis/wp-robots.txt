<?php
/**
 * WP Robots Txt
 *
 * Copyright 2013  George Pattichis (gpattihis@gmail.com)
 *
 * "WP Robots Txt" is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * "WP Robots Txt" is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * "along with WP Robots Txt". If not, see http://www.gnu.org/licenses/gpl-2.0.txt.
 *
 * @category    WordPress
 * @package     WPRobotsTxt
 * @author      George Pattichis
 * @copyright   2013 George Pattichis
 * @license     http://opensource.org/licenses/GPL-2.0 GPL-2.0+
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Wrapper for all our admin area functionality.
 *
 * @since 0.1
 */
class ROBTXT_Admin_Page {

	/**
	 * Singleton instance.
	 *
	 * @since    1.2
	 * @access   private
	 * @var      ROBTXT_Admin_Page|null
	 */
	private static $ins = null;

	/**
	 * The name of our option.
	 *
	 * @since    1.2
	 * @access   protected
	 * @var      string    $setting
	 */
	protected $setting = 'robtxt_content';

	/**
	 * Get an instance of the class.
	 *
	 * @since   1.2
	 * @access  public
	 * @return  object
	 */
	public static function instance() {
		if ( null === self::$ins ) {
			self::$ins = new self();
		}

		return self::$ins;
	}

	/**
	 * Initialize our plugin.
	 *
	 * @since   1.2
	 * @access  public
	 * @uses    add_action
	 * @return  void
	 */
	public static function init() {
		add_action( 'admin_init', array( self::instance(), 'settings' ) );

		// Backwards compatibility.
		$old = get_option( 'cd_rdte_content' );
		if ( false !== $old ) {
			update_option( self::instance()->setting, $old );
			delete_option( 'cd_rdte_content' );
		}

		add_filter( 'plugin_action_links_' . WP_ROBOTS_TXT_BASENAME, array( self::instance(), 'robtxt_action_links' ) );
	}

	/**
	 * Registers our setting and takes care of adding the settings field
	 * we need to edit our robots.txt file
	 *
	 * @since   1.2
	 * @access  public
	 * @uses    register_setting
	 * @uses    add_settings_field
	 * @return  void
	 */
	public function settings() {
		register_setting(
			'reading',
			$this->setting,
			array(
				'type'              => 'string',
				'sanitize_callback' => array( $this, 'robtxt_clean_setting' ),
				'default'           => '',
				'show_in_rest'      => false,
			)
		);

		add_settings_section(
			'robots-txt',
			__( 'Robots.txt Content', 'wp-robots-txt' ),
			'__return_false',
			'reading'
		);

		add_settings_field(
			'robtxt_robots_content',
			__( 'Robots.txt Content', 'wp-robots-txt' ),
			array( $this, 'field' ),
			'reading',
			'robots-txt',
			array( 'label_for' => $this->setting )
		);
	}

	/**
	 * Callback for the settings field.
	 *
	 * @since   1.2
	 * @access  public
	 * @uses    get_option
	 * @uses    esc_attr
	 * @return  void
	 */
	public function field() {
		$content = get_option( $this->setting );
		if ( is_string( $content ) && '' !== $content ) {
			$content = wp_specialchars_decode( $content, ENT_QUOTES );
		} else {
			$content = $this->robtxt_get_default_robots();
		}

		printf(
			'<textarea name="%1$s" id="%1$s" rows="10" class="large-text">%2$s</textarea>',
			esc_attr( $this->setting ),
			esc_textarea( $content )
		);

		if ( is_readable( ABSPATH . 'robots.txt' ) ) {
			echo '<p class="description">';
			echo esc_html__( 'A physical robots.txt file exists in the site root. Search engines will use that file instead of this setting.', 'wp-robots-txt' );
			echo '</p>';
		}

		if ( ! get_option( 'blog_public' ) ) {
			echo '<p class="description">';
			echo esc_html__( 'Search engines are discouraged from indexing this site. WordPress uses a noindex tag for that; it does not add Disallow: / here. Add that rule yourself if you want it.', 'wp-robots-txt' );
			echo '</p>';
		}

		$robots_link = sprintf(
			'<a href="%s" target="_blank" rel="noopener noreferrer">robots.txt</a>',
			esc_url( home_url( '/robots.txt' ) )
		);
		echo '<p class="description">';
		/* translators: %s is the link to see your robots.txt file */
		echo wp_kses(
			sprintf(
				__( 'The content of your %s file. Delete the above and save to restore the default.', 'wp-robots-txt' ),
				$robots_link
			),
			array(
				'a' => array(
					'href'   => true,
					'target' => true,
					'rel'    => true,
				),
			)
		);
		echo '</p>';
	}

	/**
	 * Sanitize robots.txt content for storage.
	 *
	 * Do not HTML-escape: the file is text/plain. Do not use
	 * sanitize_textarea_field(), which strips %xx sequences used in paths.
	 *
	 * @since 1.2
	 * @param mixed $contents The contents of the text-area.
	 * @return string
	 */
	public function robtxt_clean_setting( $contents ) {
		if ( ! is_string( $contents ) ) {
			$contents = '';
		}

		$contents = str_replace( array( "\r\n", "\r", "\0" ), array( "\n", "\n", '' ), $contents );
		$contents = wp_strip_all_tags( $contents );
		$contents = trim( $contents );

		if ( '' === $contents ) {
			add_settings_error(
				$this->setting,
				'robtxt-restored',
				__( 'Robots.txt restored to default.', 'wp-robots-txt' ),
				'success'
			);
		}

		return $contents;
	}

	/**
	 * Get the default robots.txt content.
	 *
	 * @since   1.2
	 * @access  protected
	 * @uses    get_option
	 * @return  string The default robots.txt content
	 */
	protected function robtxt_get_default_robots() {
		$admin_path = $this->robtxt_url_path( admin_url(), '/wp-admin/' );
		$ajax_path  = $this->robtxt_url_path( admin_url( 'admin-ajax.php' ), '/wp-admin/admin-ajax.php' );

		$output  = "User-agent: *\n";
		$output .= 'Disallow: ' . $admin_path . "\n";
		$output .= 'Allow: ' . $ajax_path . "\n";

		if ( function_exists( 'wp_sitemaps_get_server' ) ) {
			$sitemaps = wp_sitemaps_get_server();
			if ( $sitemaps->sitemaps_enabled() ) {
				$output .= "\nSitemap: " . esc_url_raw( $sitemaps->index->get_index_url() ) . "\n";
			}
		}

		return $output;
	}

	/**
	 * Path component of a URL, or a fallback if parsing fails.
	 *
	 * @since 1.3.6
	 * @param string $url      Absolute URL.
	 * @param string $fallback Path to use when none is found.
	 * @return string
	 */
	protected function robtxt_url_path( $url, $fallback ) {
		$path = wp_parse_url( $url, PHP_URL_PATH );
		return ( is_string( $path ) && '' !== $path ) ? $path : $fallback;
	}

	/**
	 * Show custom links in Plugins Page
	 *
	 * @since  1.2
	 * @access public
	 * @param  array $links Default Links.
	 * @return array Links list to display in plugins page.
	 */
	public function robtxt_action_links( $links ) {
		$settings = sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'options-reading.php' ) ),
			esc_html__( 'Settings', 'wp-robots-txt' )
		);
		$contact  = sprintf(
			'<a href="%s" target="_blank" rel="noopener noreferrer">%s</a>',
			esc_url( 'https://gp-web.dev/' ),
			esc_html__( 'Contact', 'wp-robots-txt' )
		);

		array_unshift( $links, $contact );
		array_unshift( $links, $settings );

		return $links;
	}
}
