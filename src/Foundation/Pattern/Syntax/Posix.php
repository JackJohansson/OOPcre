<?php

	namespace OOPCRE\Foundation\Pattern\Syntax;

	use OOPCRE\Foundation\Definition\PosixPattern;
	use OOPCRE\Foundation\Pattern\Pattern;
	use OOPCRE\Foundation\Skeleton\PatternSkeleton;

	/**
	 * Class to add special POSIX patterns as a pattern.
	 *
	 */
	class Posix extends Pattern implements PatternSkeleton {
		/**
		 * Register a pre-defined posix pattern.
		 *
		 * @param $input
		 *
		 * @return static
		 * @throws \OOPCRE\Foundation\Exception\InvalidPatternException
		 * @internal
		 */
		public static function create( $input ): static {
			// If a valid enum has been passed
			if ( $input instanceof PosixPattern ) {
				return new static( $input->value );
			}

			throw new \OOPCRE\Foundation\Exception\InvalidPatternException;
		}
	}