<?php

	namespace OOPCRE\Foundation\Pattern\Syntax;

	use OOPCRE\Foundation\Definition\Whitespace;
	use OOPCRE\Foundation\Exception\InvalidPatternException;
	use OOPCRE\Foundation\Pattern\Pattern;
	use OOPCRE\Foundation\Skeleton\PatternSkeleton;

	/**
	 * Pattern to match whitespaces.
	 *
	 */
	class Space extends Pattern implements PatternSkeleton {
		/**
		 * Add a pattern to match a whitespace character.
		 *
		 * @param \OOPCRE\Foundation\Definition\Whitespace $whitespace
		 *
		 * @return static
		 * @throws \OOPCRE\Foundation\Exception\InvalidPatternException
		 * @internal
		 */
		public static function create( $whitespace ): static {

			// Input must be an instance of the whitespace type enum
			if ( ! ( $whitespace instanceof Whitespace ) ) {
				throw new InvalidPatternException(
					sprintf( 'The input value for the whitespace pattern must be an instance of the "%1$s" enum.', Whitespace::class )
				);
			}

			return new static( $whitespace->value );
		}
	}