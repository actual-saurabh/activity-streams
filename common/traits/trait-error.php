<?php
/**
 * Contains error handling behaviour.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Bodh/Activity_Streams/Common
 */

namespace \Bodh\Activity_Streams\Common\Traits;

/**
 * Error handlers.
 *
 * @since 1.0.0
 */
trait Error {

	/**
	 * Triggers an error.
	 *
	 * @since 1.0.0
	 *
	 * @param string $code    Error code.
	 * @param string $message Error message.
	 * @param string $data    Error data.
	 * @return void
	 */
	public function error( $code, $message, $data = '' ) {

		// if the errors parameter isn't initialised.
		if ( ! is_wp_error( $this->errors ) ) {

			// initialise errors parameters.
			$this->init_errors();
		}

		// add a new error with the provided information.
		$this->errors->add( $code, $message, $data );
	}

	/**
	 * Initialises errors parameter.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function init_errors() {

		// initialise errors as an instance of WP_Error.
		$this->errors = new WP_Error();

		// set up common data for all errors on the object.
		$common_data = array(
			'object_id'      => $this->id,
			'object_type'    => $this->type,
			'object_subtype' => $this->subtype,
		);

		// add common data to errors object.
		$this->errors->add_data( $common_data, 'common' );
	}

	/**
	 * Log all the errors.
	 *
	 * @return void
	 */
	public function log_errors() {

		// bail if there are no errors.
		if ( ! is_wp_error( $this->errors ) ) {
			return;
		}

		// initialise array to store log messages.
		$error_messages = array();

		// translators: json object.
		$first_message = sprintf( __( '>>> There have been errors on %s', 'bodh' ), wp_json_encode( $this->errors->get_data( 'common' ) ) );
		// translators: json object.
		$last_message = __sprintf( __( '<<< Finish error details for %s', 'bodh' ), wp_json_encode( $this->errors->get_data( 'common' ) ) );

		// construct log entries for each error.
		foreach ( $this->errors->errors as $code => $msg ) {

			// translators: 1: Error Code 2: Error message.
			$error_messages[] = sprintf( __( 'Error Code: %1$s | %2$s', 'bodh' ), $code, $msg );

			// if the error has any data, add an entry for that.
			if ( isset( $this->errors->error_data[ $code ] ) ) {
				// translators: Error data.
				$error_messages[] = sprintf( __( 'Error Data: %s', 'bodh' ), $this->errors->error_data[ $code ] );
			}
		}

		// merge all the messages into a single array.
		$error_messages = array( $first_message ) + $error_messages + array( $last_message );

		// loop through and enter messages in the error log.
		foreach ( $error_messages as $msg ) {
			error_log( $msg ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		}
	}

}
