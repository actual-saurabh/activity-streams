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
abstract class Comment_Object extends Common\WP_Object {
	/**
	 * Method init_object
	 *
	 * @param int $id accpets ID of the object.
	 *
	 * @return void
	 */
	protected function init_object( $id ) {

		// add error handling here.
		$comment = get_comment( $id );

		$this->id      = $comment->comment_ID;
		$this->type    = 'comment';
		$this->subtype = $comment->comment_type;

		$this->object = $comment;

	}

	/**
	 * Method create
	 *
	 * @param array $args accepts variables required for the comment object as array.
	 *
	 * @return int|WP_Error returns ID of comment or an error.
	 */
	protected function create( $args ) {
		$inserted = wp_insert_comment( $args );
		if ( ! $inserted ) {
			return new WP_Error( 'comment-insert-failed', __( "Couldn't insert Comment", 'activity-streams' ) );
		}
		if ( is_int( $inserted ) ) {
			return $inserted;
		}
	}

	/**
	 * Method destroy
	 *
	 * @param int $id requires ID of comment.
	 *
	 * @return int|WP_Error returns ID of the deleted post orthrows an error.
	 */
	protected function destroy( $id ) {
		$deleted = wp_delete_comment( $id );
		if ( ! $deleted ) {
			return new WP_Error( 'comment-delete-failed', __( "Couldn't delete Comment", 'activity-streams' ) );
		} else {
			return $deleted;
		}
	}

	/**
	 * Method update
	 *
	 * @param array $args accepts variables required for the comment object as array.
	 *
	 * @return int|WP_Error returns ID of the deleted post orthrows an error.
	 */
	protected function update( $args ) {
		$updated = wp_update_comment( $args );
		if ( ! $updated ) {
			return new WP_Error( 'comment-update-failed', __( "Couldn't update Comment", 'activity-streams' ) );
		}
		if ( is_int( $updated ) ) {
			return $updated;
		}
	}

}
