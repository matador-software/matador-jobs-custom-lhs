<?php
/**
 * Matador Jobs Custom Extension for Lead Health Staffing / Taxonomy
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

namespace matador\MatadorJobsCustomLHS\Taxonomy;

use stdClass;
use matador\Matador;
use matador\Bullhorn_Import;
use matador\MatadorJobsCustomLHS\Extension;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Taxonomy
 *
 * @final
 * @since 1.0.0
 */
final class Region {

	/**
	 * Class Constructor
	 *
	 * Adds shortcodes to WP.
	 */
	public function __construct() {
		add_filter( 'matador_variable_job_taxonomies', [ __CLASS__, 'add_taxonomy' ] );
		add_filter( 'matador_taxonomy_args', [ __CLASS__, 'show_in_menu' ], 10, 2 );
		add_filter( 'matador_bullhorn_import_fields', [ __CLASS__, 'add_import_fields' ] );
		add_action( 'matador_bullhorn_import_save_job', [ __CLASS__, 'save_taxonomy_terms' ], 10, 3 );
	}

	/**
	 * Add Level Taxonomy
	 *
	 * @since 1.0.0
	 *
	 * @param array $taxonomies
	 *
	 * @return array
	 */
	public static function add_taxonomy( array $taxonomies ) : array {

		$taxonomies['region'] = array(
			'key'    => 'matador-regions',
			'single' => _x( 'region', 'Region Singular Name.', 'matador-extension-custom-lhs' ),
			'plural' => _x( 'regions', 'Regions Plural Name.', 'matador-extension-custom-lhs' ),
			'slug'   => Extension::setting( 'taxonomy_slug_region' ) ?: 'matador-region',
		);

		return $taxonomies;
	}

	/**
	 * Show in Menu
	 *
	 * Since client is expressedly adding this Taxonomy, show it in menu.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $args
	 * @param string $key
	 *
	 * @return array
	 */
	public static function show_in_menu( array $args, string $key ) : array {

		if ( 'region' !== $key ) {
			return $args;
		}

		$args['show_in_menu'] = true;

		return $args;
	}

	/**
	 * Add Import Fields
	 *
	 * This is called by the 'matador_import_fields' to add fields to the job import
	 * function of the @see Bullhorn_Import::get_jobs() behavior so we can use the data
	 * later.
	 *
	 * @since 1.0.0
	 *
	 * @param array $fields
	 *
	 * @return array
	 */
	public static function add_import_fields( array $fields ) : array {
		$fields['customText9'] = [
			'type'   => 'string',
			'saveas' => 'core',
			'name'   => 'region'
		];
		return $fields;
	}

	/**
	 * Save Levels Taxonomy Term
	 *
	 * @since 1.0.0
	 *
	 * @param stdClass $job
	 * @param int $wpid
	 * @param Bullhorn_Import $bullhorn
	 *
	 * @return void
	 */
	public static function save_taxonomy_terms( stdClass $job, int $wpid, Bullhorn_Import $bullhorn ) : void {

		if ( ! is_object( $job ) || ! is_int( $wpid ) || ! is_object( $bullhorn ) ) {
			return;
		}

		if ( ! empty( $job->customText9 ) ) {

			$value = $job->customText9;

			$taxonomy = Matador::variable( 'region', 'job_taxonomies' );

			wp_set_object_terms( $wpid, $value, $taxonomy['key'] );
		}
	}
}
