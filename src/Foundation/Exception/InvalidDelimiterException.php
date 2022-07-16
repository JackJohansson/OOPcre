<?php

	namespace OOPCRE\Foundation\Exception;

	/**
	 * Exception thrown whenever the provided delimiter
	 * is not valid, or can not be used inside the pattern.
	 */
	class InvalidDelimiterException extends InvalidConfigException {
		public function __construct() {
			parent::__construct( 'An invalid delimiter has been provided.' );
		}
	}