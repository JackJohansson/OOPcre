<?php

	namespace OOPCRE\Foundation\Exception;

	/**
	 * Exception thrown whenever an invalid service has been
	 * requested from the service provider.
	 *
	 */
	class InvalidServiceException extends RegexException {
		public function __construct( string $property ) {
			parent::__construct(
				sprintf( 'An invalid service property has been requested from the service provider. Property %1$s is not registered in the service provider.', $property )
			);
		}
	}