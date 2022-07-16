<?php

	namespace OOPCRE\Foundation\Contract;

	use OOPCRE\Foundation\Definition\Quantifier;
	use OOPCRE\Foundation\Pattern\QuantifierBuilder;

	/**
	 * Provide the necessary functionalities to manage the quantifier
	 * for a pattern.
	 *
	 */
	trait ManagesQuantifier {

		/**
		 * Holds an instance of the quantifier class.
		 *
		 * @var \OOPCRE\Foundation\Pattern\QuantifierBuilder $quantifier
		 */
		private QuantifierBuilder $quantifier;

		/**
		 * Maximum number of times to match a pattern.
		 *
		 * @param int $max Maximum number of times to look for the pattern. If this
		 *                 value is less than the minimum, it will be dropped. Pass -1
		 *                 to set to unlimited.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function asMost( int $max ): static {
			$this->quantifier->setMax( $max );
			return $this;
		}

		/**
		 * Minimum number of times to match the pattern.
		 *
		 * @param int $count Minimum number of times to look for the pattern.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function atLeast( int $count ): static {
			$this->quantifier->setMin( $count );
			return $this;
		}

		/**
		 * Match the pattern between atLeast and atMost number of times.
		 * This a shorthand for calling both atLeast() and atMost() methods.
		 *
		 * @param int $atLeast Minimum number of times to look for the pattern.
		 * @param int $atMost  Maximum number of times to look for the pattern. If this
		 *                     value is less than the minimum, it will be dropped. Pass -1
		 *                     to set to unlimited.
		 *
		 * @return $this
		 */
		public function between( int $atLeast, int $atMost ): static {
			$this->quantifier->setMin( $atLeast );
			$this->quantifier->setMax( $atMost );
			return $this;
		}

		/**
		 * Build the quantifier and return it.
		 *
		 * @return string
		 */
		protected function buildQuantifier(): string {
			return $this->quantifier->build();
		}

		/**
		 * Match the pattern exactly the given number of times.
		 *
		 * @param int $count
		 *
		 * @return $this
		 */
		public function exactly( int $count ): static {
			if ( 0 !== $count ) {
				$count = abs( $count );
				$this->quantifier->setMin( $count );
				$this->quantifier->setMax( $count );
			}
			return $this;
		}

		/**
		 * Set the quantifier to greedy.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function greedy(): static {
			$this->quantifier->setType( Quantifier::GREEDY );
			return $this;
		}

		/**
		 * Set the quantifier to possessive.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function possessive(): static {
			$this->quantifier->setType( Quantifier::POSSESSIVE );
			return $this;
		}

		/**
		 * Set the quantifier to reluctant.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function reluctant(): static {
			$this->quantifier->setType( Quantifier::RELUCTANT );
			return $this;
		}

		/**
		 * Set the quantifier to match as many times as possible.
		 *
		 * @return $this
		 */
		public function unlimited(): static {
			$this->quantifier->setMin( 0 );
			$this->quantifier->setMax( -1 );
			return $this;
		}
	}