<?php

	namespace OOPCRE\Foundation\Pattern;

	use OOPCRE\Foundation\Contract\ManagesQuantifier;

	/**
	 * Base pattern class to be extended by regex patterns.
	 *
	 */
	abstract class Pattern {
		use ManagesQuantifier;

		/**
		 * The pattern that is going to be matched.
		 *
		 * @var string $pattern
		 */
		protected string $pattern = '';

		/**
		 * Set-up the pattern. Create a quantifier and register the pattern.
		 *
		 */
		protected function __construct( mixed $pattern ) {
			// Create a new quantifier
			$this->quantifier = new QuantifierBuilder;
			$this->pattern    = $pattern;
		}

		/**
		 * Cast a pattern to a regex string.
		 *
		 * @return string
		 */
		public function __toString(): string {
			return $this->build();
		}

		/**
		 * Apply quantifier and return the result.
		 *
		 * @return string
		 */
		public function build(): string {
			return $this->pattern . $this->buildQuantifier();
		}

		/**
		 * Extract strings from the input.
		 *
		 * @param mixed $input
		 * @param int   $count
		 *
		 * @return string
		 * @throws \OOPCRE\Foundation\Exception\EmptyInputPatternException
		 */
		protected static function extractChar( mixed $input, int $count = -1 ): string {
			// Nothing provided
			if ( empty( $input ) ) {
				throw new \OOPCRE\Foundation\Exception\EmptyInputPatternException;
			}

			if ( -1 === $count ) {
				return $input;
			}

			return substr( $input, 0, $count );
		}
	}