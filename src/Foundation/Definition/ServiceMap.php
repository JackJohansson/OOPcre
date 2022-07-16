<?php

	namespace OOPCRE\Foundation\Definition;

	/**
	 * Enum that is used to register the
	 * services provided by the service provider class.
	 *
	 * @internal
	 */
	enum ServiceMap: string {
		case config = '\OOPCRE\Foundation\Configurator';
		case patternBuilderBag = '\OOPCRE\Foundation\Bag\PatternBuilderBag';
		case patternBuilder = '\OOPCRE\Foundation\Pattern\PatternBuilder';
		case errorBag = '\OOPCRE\Foundation\Bag\ErrorBag';
		case modifierBuilder = '\OOPCRE\Foundation\Pattern\ModifierBuilder';

		/**
		 * Register an array with the property names as keys and
		 * service classes as values.
		 *
		 * @return array
		 */
		public static function map(): array {
			return array_combine(
				array_column( self::cases(), 'name' ),
				array_column( self::cases(), 'value' )
			);
		}
	}