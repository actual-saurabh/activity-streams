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

	protected function init_object( $id ) {

		// add error handling here.
		$comment = get_comment( $id );

		$this->id      = $comment->comment_ID;
		$this->type    = 'comment';
		$this->subtype = $comment->comment_type;

		$this->object = $comment;

	}

	protected function create( $args ) {
		$inserted = wp_insert_comment( $args );
		if ( ! $inserted ) {
			return new WP_Error( 'comment-insert-failed', __( "Couldn't insert Comment", 'activity-streams' ) );
		}
		if ( is_int( $inserted ) ) {
			return $inserted;
		}
	}

	protected function destroy() {

	}

	protected function update( $args ) {

	}

}
