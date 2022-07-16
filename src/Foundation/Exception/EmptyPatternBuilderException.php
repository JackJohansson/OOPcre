<?php

	namespace OOPCRE\Foundation\Exception;

	/**
	 * Exception thrown whenever there is an attempt to perform
	 * a regex without adding any pattern to the pattern.
	 *
	 */
	class EmptyPatternBuilderException extends RegexException {
		public function __construct() {
			parent::__construct( 'Can not perform a regex without adding any items to the regex pattern.' );
		}
	}