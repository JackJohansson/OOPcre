<?php

	namespace OOPCRE\Foundation\Pattern\Syntax;

	use OOPCRE\Foundation\Pattern\Pattern;
	use OOPCRE\Foundation\Skeleton\PatternSkeleton;

	/**
	 * Handles adding a single character to the regex
	 * pattern.
	 *
	 */
	class Character extends Pattern implements PatternSkeleton {

		/**
		 * Add a single character to be matched.
		 *
		 * @param $char
		 *
		 * @return static
		 * @throws \OOPCRE\Foundation\Exception\EmptyInputPatternException
		 * @internal
		 */
		public static function create( $char ): static {
			// In case more than a single character is provided
			return new static( self::extractChar( $char, 1 ) );
		}

	}