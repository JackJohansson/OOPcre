<?php

	namespace OOPCRE\Foundation\Pattern;

	use OOPCRE\Foundation\Definition\Quantifier;

	/**
	 * Class to handle the quantifier for a pattern.
	 *
	 */
	class QuantifierBuilder {
		/**
		 * Minimum number of times the pattern should be matched.
		 *
		 * @var int $maximum
		 */
		protected int $maximum = 0;

		/**
		 * Maximum number of times the pattern should be matched.
		 *
		 * @var int $minimum
		 */
		protected int $minimum = 0;

		/**
		 * Sets the quantifier type for this pattern.
		 *
		 * @var \OOPCRE\Foundation\Definition\Quantifier $type
		 */
		protected Quantifier $type;

		/**
		 * Build the quantifier and return it.
		 *
		 * @return string
		 */
		public function build(): string {
			[ $min, $max ] = $this->validate();

			$quantifier = '';
			// Let's break down the quantifiers to avoid confusion.
			if ( 0 === $min ) {
				// Equivalent of c?
				if ( 1 === $max ) {
					$quantifier .= '?';
				} elseif ( -1 === $max ) {
					$quantifier .= '*';
				} elseif ( 1 < $max ) {
					$quantifier .= '{' . $min . ',' . $max . '}';
				}
			} elseif ( $min === $max ) {
				$quantifier .= '{' . $min . '}';
			} elseif ( 0 === $max || -1 === $max ) {
				// Equivalent of c{min,}
				$quantifier .= '{' . $min . ',}';
			} else {
				$quantifier .= '{' . $min . ',' . $max . '}';
			}

			// Apply quantifier type, if provided
			if ( isset( $this->type ) ) {
				$quantifier .= $this->type->value;
			}

			return $quantifier;
		}

		/**
		 * Validate and register the range limit for a pattern.
		 *
		 *
		 * @return array
		 */
		private function validate(): array {
			// The minimum matched counts can't be more than maximum.
			if ( -1 !== $this->maximum && 0 !== $this->maximum ) {
				$this->maximum = max( abs( $this->maximum ), abs( $this->minimum ) );
			}
			return [ $this->minimum, $this->maximum ];
		}

		/**
		 * Maximum number of times to match a pattern.
		 *
		 * @param int $max
		 *
		 */
		public function setMax( int $max ): void {
			$this->maximum = $max;
		}

		/**
		 * Minimum number of times to match the pattern.
		 *
		 * @param int $min
		 */
		public function setMin( int $min ): void {
			$this->minimum = abs( $min );
		}

		/**
		 * Set the quantifier type for this pattern.
		 *
		 * @param \OOPCRE\Foundation\Definition\Quantifier $type
		 *
		 */
		public function setType( Quantifier $type ): void {
			$this->type = $type;
		}
	}