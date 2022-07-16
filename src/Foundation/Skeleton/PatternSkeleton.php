<?php

	namespace OOPCRE\Foundation\Skeleton;

	/**
	 * Interface implemented by regex rules.
	 *
	 */
	interface PatternSkeleton {
		/**
		 * Patterns must have a _toString method to cast them
		 * to an actual regex pattern.
		 *
		 * @return string
		 */
		public function __toString(): string;

		/**
		 * Build the pattern and return the string.
		 *
		 * @return string
		 */
		public function build(): string;

		/**
		 * Patterns must implement an static method to accept
		 * an input.
		 *
		 * @param mixed $input The input value to be passed to the pattern.
		 *
		 * @return static
		 * @internal
		 */
		public static function create( $input ): static;
	}