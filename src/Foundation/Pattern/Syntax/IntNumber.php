<?php

	namespace OOPCRE\Foundation\Pattern\Syntax;

	/**
	 * Class to match an integer number.
	 *
	 */
	class IntNumber extends Number {
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
		 * Set up the class and apply the modifiers.
		 *
		 * @param int  $number
		 * @param bool $unsigned
		 *
		 * @return \OOPCRE\Foundation\Pattern\Syntax\IntNumber
		 * @internal
		 */
		public static function create( $number, bool $unsigned = TRUE ): static {
			// If negative numbers aren't allowed
			if ( $unsigned ) {
				$number = abs( $number );
			}
			return new static( (string) $number );
		}
	}