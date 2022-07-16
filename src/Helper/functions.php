<?php
	/**
	 * Define a helper function for our application's
	 * main entry.
	 */
	if ( ! function_exists( 'OOPCRE' ) ) {
		function OOPCRE( mixed $subject ): \OOPCRE\Regex {
			return new \OOPCRE\Regex( $subject );
		}
	}