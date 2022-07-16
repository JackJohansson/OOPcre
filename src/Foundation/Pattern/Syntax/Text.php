<?php

	namespace OOPCRE\Foundation\Pattern\Syntax;

	use OOPCRE\Foundation\Exception\EmptyInputPatternException;
	use OOPCRE\Foundation\Pattern\Pattern;
	use OOPCRE\Foundation\Skeleton\PatternSkeleton;

	/**
	 * Class to match a custom text string.
	 *
	 */
	class Text extends Pattern implements PatternSkeleton {
		/**
		 * Build the pattern.
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
		 * Set up the class to add a textual pattern to the regex.
		 *
		 * @param string $text
		 *
		 * @throws \OOPCRE\Foundation\Exception\EmptyInputPatternException
		 * @internal
		 */
		public static function create( $text ): static {
			// Nothing to process
			if ( '' === $text ) {
				throw new EmptyInputPatternException;
			}
			return new static( $text );
		}
	}