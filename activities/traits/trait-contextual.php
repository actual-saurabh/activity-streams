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
trait Contextual {

	/**
	 * Undocumented function
	 *
	 * @param [type] $key
	 * @param [type] $value
	 * @return void
	 */
	public function set_context( $key, $value ) {

		if ( array_key_exists( $key, $this->context ) ) {
			$this->context[ $key ] = $value;
		}

		return $this;

	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $key
	 * @return void
	 */
	public function get_context( $key ) {
		if ( array_key_exists( $key, $this->context ) ) {
			return $this->context[ $key ];
		}
	}
}
