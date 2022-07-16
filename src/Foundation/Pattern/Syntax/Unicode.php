<?php

	namespace OOPCRE\Foundation\Pattern\Syntax;

	use OOPCRE\Foundation\Exception\InvalidPatternException;
	use OOPCRE\Foundation\Pattern\Pattern;
	use OOPCRE\Foundation\Skeleton\PatternSkeleton;

	/**
	 * Add a pattern to match a unicode character.
	 *
	 */
	class Unicode extends Pattern implements PatternSkeleton {

		/**
		 * Validate the unicode code and create a pattern.
		 *
		 * @param $code
		 *
		 * @return static
		 * @throws \OOPCRE\Foundation\Exception\InvalidPatternException
		 * @internal
		 */
		public static function create( $code ): static {
			if ( ! @preg_match( '~\\\\u([0-9A-Fa-f]{2}){1,4}~', $code, $matches ) ) {
				throw new InvalidPatternException( 'An invalid unicode character has been provided as pattern.' );
			}
			return new static( '\u' . $matches[ 0 ] );
		}
	}