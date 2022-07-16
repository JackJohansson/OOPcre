<?php

	namespace OOPCRE\Support;

	use OOPCRE\Foundation\Definition\PosixPattern;
	use OOPCRE\Foundation\Pattern\Pattern;
	use OOPCRE\Foundation\Pattern\Syntax\Posix;

	/**
	 * Trait to provide posix regex patterns for the ruleset.
	 */
	trait RegistersPosixPattern {

		/**
		 * Add a new POSIX pattern to the bag.
		 *
		 * @param \OOPCRE\Foundation\Definition\PosixPattern $pattern
		 *
		 * @return \OOPCRE\Foundation\Pattern\Syntax\Posix
		 */
		private function addPosix( PosixPattern $pattern ): Pattern {
			return $this->addPattern( Posix::create( $pattern ) );
		}

		/**
		 * Match alphabetic characters.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function posixAlpha(): Pattern {
			return $this->addPosix( PosixPattern::ALPHA );
		}

		/**
		 * Match alphabetic and numeric characters.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function posixAlphaNumeric(): Pattern {
			return $this->addPosix( PosixPattern::ALPHA_NUM );
		}

		/**
		 * Match space or tab characters.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function posixBlank(): Pattern {
			return $this->addPosix( PosixPattern::BLANK );
		}

		/**
		 * Match the control characters.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function posixCtrlChar(): Pattern {
			return $this->addPosix( PosixPattern::CONTROL );
		}

		/**
		 * Match any digit.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function posixDigit(): Pattern {
			return $this->addPosix( PosixPattern::DIGIT );
		}

		/**
		 * Match Non-blank character (excludes spaces, control characters, and similar)
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function posixGraph(): Pattern {
			return $this->addPosix( PosixPattern::GRAPH );
		}

		/**
		 * Match lowercase alphabetical character.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function posixLowerCase(): Pattern {
			return $this->addPosix( PosixPattern::LOWERCASE );
		}

		/**
		 * Works like [:graph:], but includes the space character.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function posixPrint(): Pattern {
			return $this->addPosix( PosixPattern::PRINT );
		}

		/**
		 * Match punctuation character.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function posixPunctuation(): Pattern {
			return $this->addPosix( PosixPattern::PUNCTUATION );
		}

		/**
		 * Match whitespace character ([:blank:], newline,
		 * carriage return, etc.)
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function posixSpace(): Pattern {
			return $this->addPosix( PosixPattern::SPACE );
		}

		/**
		 * Match uppercase alphabetical characters.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function posixUppercase(): Pattern {
			return $this->addPosix( PosixPattern::UPPERCASE );
		}

		/**
		 * Match digit in a hexadecimal number (i.e., 0-9a-fA-F).
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function posixHexDigit(): Pattern {
			return $this->addPosix( PosixPattern::HEX_DIGIT );
		}
	}