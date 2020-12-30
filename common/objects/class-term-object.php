<?php
/**
 * Contains recordable behaviour.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Bodh/Activity_Streams/Common
 */

namespace \Bodh\Activity_Streams\Common\Objects;

use \Bodh\Activity_Streams\Common as Common;

/**
 * Any WP Object
 *
 * @since 1.0.0
 */
abstract class Term_Object extends Common\WP_Object {

	/**
	 * Method init_object initiates the term object.
	 *
	 * @param int $id ID of the term.
	 *
	 * @return void
	 */
	protected function init_object( $id ) {

		// add error handling here.
		$term = get_term( $id );

		$this->id      = $term->term_id;
		$this->type    = 'term';
		$this->subtype = $term->taxonomy;

		$this->object = $term;

	}

	/**
	 * Method create adds the term object to the database.
	 *
	 * @param string       $term        (Required) The term name to add.
	 * @param string       $taxanomy    (Required) The taxonomy to which to add the term.
	 * @param array|string $args        (Optional) Array or query string of arguments for inserting a term.
	 *
	 * @return array|WP_Error An array containing the term_id and term_taxonomy_id, WP_Error otherwise.
	 */
	protected function create( $term, $taxanomy, $args ) {
		$inserted = wp_insert_term( $term, $taxonomy, $args );
		return $inserted;
	}

	/**
	 * Method destroy deletes the term object from the database.
	 *
	 * @param string       $term        (Required) The term name to add.
	 * @param string       $taxanomy    (Required) The taxonomy to which to add the term.
	 * @param array|string $args        (Optional) Array or query string of arguments for inserting a term.
	 *
	 * @return bool|WP_Error  True on success. WP_Error if term does not exist or if the taxonomy does not exist or on attempted deletion of default Category.
	 */
	protected function destroy( $term, $taxanomy, $args ) {
		$destroy = wp_delete_term( $term, $taxonomy, $args );
		if ( ! $destroy ) {
			return new WP_Error( 'term-delete-failed', __( "Couldn't delete term because term not found", 'activity-streams' ) );
		}
		if ( 0 === $destroy ) {
			return new WP_Error( 'term-delete-failed', __( "Couldn't delete term because you attempted to delete a default category", 'activity-streams' ) );
		}
		if ( is_wp_error( $destroy ) || true === $destroy ) {
			return $destroy;
		}
	}

	/**
	 * Method update udpates the term object in the database.
	 *
	 * @param array $args Array or query string of arguments for inserting a term.
	 *
	 * @return array|WP_Error An array containing the term_id and term_taxonomy_id, WP_Error otherwise.
	 */
	protected function update( $args ) {
		$updated = wp_update_term( $id, $taxonomy, $args );
		return $updated;
	}

}
