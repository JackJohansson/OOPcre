<?php

	namespace OOPCRE\Foundation\Pattern\Syntax;

	use OOPCRE\Foundation\Definition\Metacharacter;
	use OOPCRE\Foundation\Exception\InvalidPatternException;
	use OOPCRE\Foundation\Pattern\Pattern;
	use OOPCRE\Foundation\Skeleton\PatternSkeleton;

	/**
	 * Class to add a special metacharacter to the regex
	 *
	 */
	class Special extends Pattern implements PatternSkeleton {
		/**
		 * Rules must implement an static method to accept
		 * an input.
		 *
		 * @param Metacharacter $input
		 *
		 * @return static
		 * @throws \OOPCRE\Foundation\Exception\InvalidPatternException
		 * @internal
		 */
		public static function create( $input ): static {
			// Invalid input
			if ( ! ( $input instanceof Metacharacter ) ) {
				throw new InvalidPatternException(
					sprintf( 'The input value for the metacharacter pattern must be an instance of the "%1$s" enum.', Metacharacter::class )
				);
			}

			return new static( $input->value );
		}
	}