<?php
/**
 * Contains Activity Object
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Bodh/Activity_Streams/Activities
 */

namespace \Bodh\Activity_Streams\Activities;

use \Bodh\Activity_Streams\Activities as Activities;

use \Bodh\Activity_Streams\Common as Common;

/**
 * Activity Object
 *
 * @since 1.0.0
 */
class Activity extends Common\Comment_Object {

	use Activities\Traits\Recordable;

	use Activities\Traits\Contextual;

	/**
	 * Actor performing the activity.
	 *
	 * @since 1.0.0
	 *
	 * @var integer
	 */
	public $actor_id = 0;

	/**
	 * Activity verb.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $verb = '';

	/**
	 * Action post ID.
	 *
	 * @since 1.0.0
	 *
	 * @var integer
	 */
	public $action_id = 0;

	/**
	 * Parent activity ID.
	 *
	 * @since 1.0.0
	 *
	 * @var integer
	 */
	public $parent_activity_id = 0;

	/**
	 * Context of the activity.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $context = array();

}
