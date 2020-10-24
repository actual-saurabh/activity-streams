<?php
/**
 * Contains recordable behaviour.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Bodh/Activity_Streams/Activities/
 */

namespace \Bodh\Activity_Streams\Activities\Traits;

/**
 * Recordable Activity
 *
 * @since 1.0.0
 */
trait Recordable {

	/**
	 * Records an activity.
	 *
	 * @param [type] $user_id
	 * @param [type] $action
	 * @return void
	 */
	public function record( $user_id, $action = null ) {

	}

	/**
	 * Voids a previously recorded activity.
	 *
	 * @since 1.0.0
	 *
	 * @param [type] $activity
	 * @return int
	 */
	public function void( $activity = null ) {

		// if no activity is provided, assume the current activity.
		if ( ! $activity ) {
			$activity = $this;
		}

		// construct a new activity.
		$voiding_activity = new Activities\Activity();

		// set up the activity being voided as a parent.
		$voiding_activity->parent_activity_id = $activity->id;

		// setup the voided verb.
		$voiding_activity->verb = 'voided';

		// insert and return voiding activity's ID.
		return $this->insert( $voiding_activity );
	}

	/**
	 * Inserts an activity as WP comment.
	 *
	 * @since 1.0.0
	 *
	 * @param [type] $activity
	 * @return int
	 */
	private function insert( $activity = null ) {

		// if no activity is provided, assume the current activity.
		if ( ! $activity ) {
			$activity = $this;
		}

		// map $activity pproperties to $comment_args.
		$comment_args = array(
			'comment_agent'    => 'bodh', // (string) The HTTP user agent of the $comment_author when the comment was submitted. Default empty.
			'comment_approved' => 1, // (int|string) Whether the comment has been approved. Default 1.
			'comment_content'  => '', // (string) The content of the comment. Default empty.
			'comment_parent'   => $activity->parent_activity_id, // (int) ID of this comment's parent, if any. Default 0.
			'comment_post_ID'  => $activity->action_id, // (int) ID of the post that relates to the comment, if any. Default 0.
			'comment_type'     => $prefix . $activity->verb, // (string) Comment type. Default 'comment'.
			'comment_meta'     => array(), // (array) Optional. Array of key/value pairs to be stored in commentmeta for the new comment.
			'user_id'          => $activity->actor_id, // (int) ID of the user who submitted the comment. Default 0.
		);

		// initialise array to store comment meta data.
		$comment_meta = array();

		// fill metadata with all context items.
		foreach ( $activity->context as $context_key => $context_value ) {
			$context_key = $prefix . '_context_' . $context_key;
			$comment_meta += array( $prefix . '_context_' . $context_key => $context_value );
		}

		// fill comment_meta key.
		$comment_args['comment_meta'] = $comment_meta;

		// insert and return comment's ID.
		return wp_insert_comment( $comment_args );
	}
}
