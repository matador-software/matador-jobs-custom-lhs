<?php
/**
 * Matador Jobs Custom Extension for Lead Health Staffing
 *
 * The one class that powers the plugin and makes it extendable.
 *
 * @link        https://matadorjobs.com/
 * @since       1.0.0
 *
 * @package     Matador Jobs Custom Extension for Lead Health Staffing
 * @subpackage  Core
 * @author      Matador Software LLC, Jeremy Scott, Paul Bearne
 * @copyright   (c) 2021 Matador Software, LLC
 *
 * @license     https://opensource.org/licenses/GPL-3.0 GNU General Public License version 3
 */

namespace matador\MatadorJobsCustomLHS;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use matador;

/**
 * Class Extension
 *
 * @final
 * @since 1.0.0
 */
final class Extension implements matador\MatadorJobs\Extension\ExtensionInterface {

	use matador\MatadorJobs\Extension\ExtensionTrait;

	/**
	 * Name
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	const NAME = 'custom-lhs';

	/**
	 * Constant Version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * Properties
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	protected function properties() : void {
		self::$directory = plugin_dir_path( __FILE__ );
		self::$file      = self::$directory . 'matador-jobs-' . self::NAME . '.php';
		self::$path      = plugin_dir_url( self::$file );
		self::$namespace = __NAMESPACE__;
	}

	/**
	 * Load Plugin
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function load() : void {
		new Taxonomy\Region();
		new Taxonomy\Shift();
	}
}
