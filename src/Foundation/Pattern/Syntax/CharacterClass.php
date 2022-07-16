<?php

	namespace OOPCRE\Foundation\Pattern\Syntax;

	use OOPCRE\Foundation\Pattern\Pattern;
	use OOPCRE\Foundation\Skeleton\PatternSkeleton;

	/**
	 * Handles a character class inside a regex pattern.
	 *
	 */
	class CharacterClass extends Pattern implements PatternSkeleton {
		/**
		 * Add a character pattern to the regex.
		 *
		 * @param string $chars The characters to be included.
		 *
		 * @throws \OOPCRE\Foundation\Exception\EmptyInputPatternException
		 * @internal
		 */
		public static function create( $chars, bool $not = FALSE ): static {
			// Remove duplicates
			$negative = $not ? '^' : '';
			return new static( '[' . $negative . implode( array_unique( str_split( self::extractChar( $chars ) ) ) ) . ']' );
		}
	}