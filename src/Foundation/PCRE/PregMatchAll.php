<?php

	namespace OOPCRE\Foundation\PCRE;

	/**
	 * Class to perform a preg_match_all on a given subject.
	 *
	 * @package OOPCRE
	 * @version 1.0.0
	 */
	class PregMatchAll extends PregMatchBase {

		/**
		 * Holds the matched string.
		 *
		 * @var string[] $fullMatches
		 */
		protected array $fullMatches = [];

		/**
		 * Return the first match, or an empty string if
		 * there has been no matches yet.
		 *
		 * @return string
		 */
		public function firstMatch(): string {
			return $this->fullMatches[ 0 ] ?? '';
		}

		/**
		 * Get the matched strings, if any. Returns an empty
		 * array if there was no match.
		 *
		 * @return string[]
		 */
		public function fullMatches(): array {
			return $this->fullMatches;
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
			$this->fullMatches = array_column( $this->matches[ 0 ], 0 );

			// Remove unnamed groups
			$groups = array_filter( $this->matches, fn( $key ) => ! is_numeric( $key ), ARRAY_FILTER_USE_KEY );

			foreach ( $groups as $name => $match ) {
				foreach ( $match as $subMatch ) {
					$this->matchesParsed[] = new \OOPCRE\Foundation\Pattern\Result( $name, $subMatch );
				}
			}
		}

		/**
		 * Perform the regex and return the results.
		 *
		 * @return bool|int
		 * @throws \OOPCRE\Foundation\Exception\EmptyPatternBuilderException
		 */
		protected function perform(): bool|int {
			return @preg_match_all(
				$this->patternBuilder->build(),
				$this->service->subject( TRUE ),
				$this->matches,
				PREG_PATTERN_ORDER | PREG_OFFSET_CAPTURE | PREG_UNMATCHED_AS_NULL,
				$this->offset
			);
		}
	}