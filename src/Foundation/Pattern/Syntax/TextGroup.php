<?php

	namespace OOPCRE\Foundation\Pattern\Syntax;

	use OOPCRE\Foundation\Exception\InvalidPatternException;
	use OOPCRE\Foundation\Pattern\Pattern;
	use OOPCRE\Foundation\Skeleton\PatternSkeleton;

	/**
	 * Class to add a simple text group to the pattern.
	 *
	 */
	class TextGroup extends Pattern implements PatternSkeleton {

		/**
		 *  Parse the input and try to generate a text group.
		 *
		 * @param array $input The input value to be passed to the pattern.
		 *
		 * @return static
		 * @throws \OOPCRE\Foundation\Exception\InvalidPatternException
		 * @internal
		 */
		public static function create( $input ): static {
			// The input must be an array.
			if ( ! is_array( $input ) ) {
				throw new InvalidPatternException( 'The input value for the text group must be an array of strings.' );
			}

			// Try to convert array items to string, if possible
			$strings = array_map( fn( $item ) => (string) $item, $input );

			return new static( '(' . implode( '|', $strings ) . ')' );
		}
	}