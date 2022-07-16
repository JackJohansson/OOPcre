<?php

	namespace OOPCRE\Foundation\Exception;


	/**
	 * Exception thrown when an invalid item key from the bag
	 * is requested.
	 */
	class InvalidBagKeyException extends RegexException {
		public function __construct( ) {
			parent::__construct( "An invalid bag item has been requested. Please double check the item's key." );
		}
	}