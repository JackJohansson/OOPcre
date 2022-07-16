<?php

	namespace OOPCRE\Foundation\Exception;

	/**
	 * Exception thrown whenever a invalid class is requested
	 * from the service provider
	 *
	 */
	class InvalidServiceClassException extends RegexException {
		public function __construct( string $class ) {
			parent::__construct(
				sprintf( 'The requested class can not be resolved by the service provider. Class %1$s can not be resolved.', $class )
			);
		}
	}