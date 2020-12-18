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

	protected function init_object( $id ) {

		// add error handling here.
		$term = get_term( $id );

		$this->id      = $term->term_id;
		$this->type    = 'term';
		$this->subtype = $term->taxonomy;

		$this->object = $term;

	}

	protected function create( $term, $taxanomy, $args ) {
		$inserted = wp_insert_term( $term, $taxonomy, $args );
		return $inserted;
	}

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

	protected function update( $args ) {
		$updated = wp_update_term( $id, $taxonomy, $args );
		return $updated;
	}

}
