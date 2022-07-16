<?php

	namespace OOPCRE\Foundation\Pattern\Syntax;

	use OOPCRE\Foundation\Pattern\Pattern;
	use OOPCRE\Foundation\Skeleton\PatternSkeleton;

	/**
	 * This pattern is simply a placeholder for when a pattern is invalid,
	 * and the exceptions are disables. Needless to say that the result
	 * of the operation will be invalid, if the errors are not investigated
	 * before using the results.
	 */
	class Placeholder extends Pattern implements PatternSkeleton {

		/**
		 * Nothing to build.
		 *
		 * @return string
		 */
		public function build(): string {
			return '';
		}

		/**
		 * No valid will be accepted.
		 *
		 */
		public static function create( $input ): static {
			return new static( '' );
		}
	}