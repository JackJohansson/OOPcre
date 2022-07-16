<?php

	namespace OOPCRE\Foundation\Pattern\Syntax;

	/**
	 * Match a floating point number.
	 *
	 */
	class FloatNumber extends Number {

		/**
		 * Build and return the pattern.
		 *
		 * @return string
		 */
		public function build(): string {
			// Build the quantifier. If there's anything, wrap the pattern in parentheses.
			$quantifier = $this->buildQuantifier();

			if ( ! empty( $quantifier ) ) {
				return "($this->pattern){$quantifier}";
			}

			return $this->pattern;
		}

		/**
		 * Set up the number and apply the necessary modifications.
		 *
		 * @param float $number
		 * @param int   $precision
		 * @param bool  $unsigned
		 *
		 * @return \OOPCRE\Foundation\Pattern\Syntax\FloatNumber
		 */
		public static function create( $number, int $precision = 2, bool $unsigned = TRUE ): static {
			// If negative numbers aren't allowed
			if ( $unsigned ) {
				$number = abs( $number );
			}
			return new static( (string) round( $number, $precision ) );
		}
	}