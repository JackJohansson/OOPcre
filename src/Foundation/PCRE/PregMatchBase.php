<?php

	namespace OOPCRE\Foundation\PCRE;

	use OOPCRE\Foundation\Contract\CountsResults;
	use OOPCRE\Foundation\Contract\RegistersPattern;
	use OOPCRE\Foundation\Exception\RegexException;

	/**
	 * Abstract class that is extended by preg_match* classes.
	 *
	 * @package OOPCRE
	 * @version 1.0.0
	 */
	abstract class PregMatchBase extends PregBase {
		use RegistersPattern,
			CountsResults;

		/**
		 * Holds an array of matched items.
		 *
		 * @var array $matches
		 */
		protected array $matches = [];

		/**
		 * Holds an array of matches after being parsed.
		 *
		 * @var array $matchesParsed
		 */
		protected array $matchesParsed = [];

		/**
		 * The offset value for the preg_match function.
		 *
		 * @var int $offset
		 */
		protected int $offset = 0;

		/**
		 * Check the preg_match* results.
		 *
		 * @return bool
		 * @throws \OOPCRE\Foundation\Exception\EmptyPatternBuilderException
		 * @throws \OOPCRE\Foundation\Exception\RegexException
		 */
		public function execute(): bool {
			try {
				$result = $this->perform();

				// If the config is set to throw exception on errors
				if ( FALSE === $result ) {
					throw new RegexException( preg_last_error_msg(), preg_last_error() );
				}

				// Set the status, and number of matched items
				$this->count = (int) $result;

				// Parse the matches
				$this->parseMatches();

				return $this->success = TRUE;

			} catch ( RegexException $exception ) {
				return $this->service->errorBag->handle( $exception );
			}
		}

		/**
		 * Return the matched items.
		 *
		 * @return array
		 */
		public function results(): array {
			// if there's no match
			if ( FALSE === $this->success ) {
				return [];
			}

			// If already parsed
			if ( empty( $this->matchesParsed ) ) {
				$this->parseMatches();
			}

			// Parse and return the results
			return $this->matchesParsed;
		}

		/**
		 * Set the offset for the preg_match function.
		 *
		 * @param int $offset
		 *
		 * @return void
		 */
		public function setOffset( int $offset ): void {
			$this->offset = abs( $offset );
		}
	}