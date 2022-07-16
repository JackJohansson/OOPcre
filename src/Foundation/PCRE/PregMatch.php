<?php

	namespace OOPCRE\Foundation\PCRE;

	/**
	 * Class to perform a basic preg-match on a given
	 * subject.
	 *
	 * @package OOPCRE
	 * @version 1.0.0
	 */
	class PregMatch extends PregMatchBase {
		/**
		 * Holds the matched string.
		 *
		 * @var string $fullMatch
		 */
		protected string $fullMatch = '';

		/**
		 * Get the matched string, if any. Returns an empty
		 * string if there was no match.
		 *
		 * @return string
		 */
		public function fullMatch(): string {
			return $this->fullMatch;
		}

		/**
		 * Parse the results.
		 *
		 * @return void
		 */
		protected function parseMatches(): void {
			// If the first array key is not set, then there's
			// no match.
			if ( ! isset( $this->matches[ 0 ] ) ) {
				return;
			}

			// Full match
			$this->fullMatch = $this->matches[ 0 ][ 0 ];

			// Parse each named group
			foreach ( $this->matches as $key => $match ) {
				// Only named groups are captured
				if ( is_numeric( $key ) ) {
					continue;
				}
				$this->matchesParsed[] = new \OOPCRE\Foundation\Pattern\Result( $key, $match );
			}
		}

		/**
		 * Perform the regex operation and return the results.
		 *
		 * @return bool|int
		 * @throws \OOPCRE\Foundation\Exception\EmptyPatternBuilderException
		 */
		protected function perform(): bool|int {
			return @preg_match(
				$this->patternBuilder->build(),
				$this->service->subject( TRUE ),
				$this->matches,
				PREG_UNMATCHED_AS_NULL | PREG_OFFSET_CAPTURE,
				$this->offset
			);
		}
	}