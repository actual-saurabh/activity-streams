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
abstract class Post_Object extends Common\WP_Object {

	protected function init_object( $id ) {

		// add error handling here.
		$post = get_post( $id );

		$this->id      = $post->ID;
		$this->type    = 'post';
		$this->subtype = $post->post_type;

		$this->object = $post;

	}

	protected function create( $args ) {
		$inserted = wp_insert_post( $args, $wp_error = false, $fire_after_hooks = true );
		return $inserted;
	}

	protected function destroy() {
		$destroy = wp_delete_post( $id, $force_delete = false );
		if ( 0 === $destroy || is_null( $delete ) ) {
			return new WP_Error( 'post-delete-failed', __( "Couldn't delete post", 'activity-streams' ) );
		}
		if ( $destroy instanceof WP_Post ) {
			return $destroy;
		}
	}

	protected function update( $args ) {

	}

}
