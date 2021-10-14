<?php
/**
 * Plugin Name: Matador Jobs Custom Extension for Lead Health Staffing
 * Plugin URI: https://matadorjobs.com/
 * Description: Extends Matador Jobs for custom features as requested by Lead Health Staffing
 * Author: Matador Software, LLC, Jeremy Scott (jeremyescott)
 * Author URI: http://matadorjobs.com
 * Version: 1.0.0
 * Text Domain: matador-extension-custom-lhs
 * Domain Path: /languages
 *
 * Extends Matador Jobs for custom features as requested by Lead Health Staffing
 *
 * Matador Jobs Custom Extension for Lead Health Staffing is free software: you can
 * redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 3 of
 * the License, or any later version.
 *
 * Matador Jobs Custom Extension for Lead Health Staffing is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Matador Jobs Board. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Matador Software LLC, Jeremy Scott, Paul Bearne
 * @version    1.0.0
 */

namespace matador\MatadorJobsCustomLHS;

/**
 * Starts the Plugin
 *
 * @since 1.0.0
 */
function run() {
	if ( file_exists( plugin_dir_path( __FILE__ ) . '/Extension.php' ) ) {
		include_once plugin_dir_path( __FILE__ ) . 'Extension.php';
		$run = new Extension();
		$run->instance();
	}
}

/**
 * Admin Notice if Unsupported PHP Version
 *
 * If we can't load, lets tell our admins.
 *
 * @since 1.0.0
 */
function admin_notice_php() {
	$html = '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>';
	$plugin = __( 'Matador Jobs Custom Extension for Lead Health Staffing', 'matador-extension-custom-lhs' );
	// Translators: This string is translated in the parent plugin and the placeholder is the name of the child plugin.
	$message = __( 'The plugin Matador Jobs Pro - %s Extension requires PHP Version %s or better. Contact your web host to upgrade so you can use the features offered by this plugin.', 'matador-jobs' );
	printf( $html, esc_html( sprintf( $message, $plugin, '7.1.0' ) ) );
}

// Make sure we have access to is_plugin_active()
if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

// We need Matador to be activated, and if it is, load it.
if ( version_compare( PHP_VERSION, '7.1.0', '<' ) ) {
	add_action( 'admin_notices', __NAMESPACE__ . '\admin_notice_php' );
} else {
	add_action( 'matador_loaded', __NAMESPACE__ . '\run' );
}
