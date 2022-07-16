<?php

	namespace OOPCRE\Foundation\Exception;

	/**
	 * Exception thrown when an empty input has been
	 * provided to a regex pattern.
	 */
	class EmptyInputPatternException extends RegexException {
		public function __construct() {
			parent::__construct( 'An empty input has been passed as a pattern.' );
		}
	}