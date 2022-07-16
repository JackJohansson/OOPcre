<?php

	namespace OOPCRE\Foundation\Exception;

	/**
	 * Exception thrown when the result of an operation is
	 * accessed before the operation is run.
	 */
	class RegexNotExecutedYet extends RegexException {
		public function __construct() {
			parent::__construct(
				'The regex result is requested too early. Regex operation has not been executed yet.'
			);
		}
	}