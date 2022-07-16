<?php

	namespace OOPCRE\Foundation\PCRE;

	use OOPCRE\Foundation\Contract\CountsResults;
	use OOPCRE\Foundation\Contract\RegistersMultiplePatterns;
	use OOPCRE\Foundation\Contract\SupportsLimit;
	use OOPCRE\Foundation\Exception\RegexException;

	/**
	 * Class used to handle an array of preg_replace* operations.
	 *
	 * @package OOPCRE
	 * @version 1.0.0
	 */
	class PregReplaceMultiple extends PregBase {
		use RegistersMultiplePatterns,
			SupportsLimit,
			CountsResults;

		/**
		 * Holds a map of patterns and their replacements.
		 *
		 * @var array $map
		 */
		protected array $map = [];

		/**
		 * Holds an array of replacement results.
		 *
		 * @var array $results
		 */
		protected array $results;

		/**
		 * Perform the replaces and return the result.
		 *
		 * @throws \OOPCRE\Foundation\Exception\EmptyPatternBuilderException
		 * @throws \OOPCRE\Foundation\Exception\RegexException
		 */
		public function execute(): bool {
			try {
				// Build all the patterns
				$patterns = $this->patternBuilderBag->buildAll();

				// Map the replacement callbacks to the patterns
				foreach ( $patterns as $key => $pattern ) {
					$this->map[ $key ][ 'pattern' ] = $pattern;
				}

				$result = @preg_replace_callback_array(
					array_combine(
						array_column( $this->map, 'pattern' ),
						array_column( $this->map, 'replacement' ),
					),
					$this->service->subject( FALSE ),
					$this->limit,
					$this->count
				);

				// Regex error
				if ( NULL === $result ) {
					throw new RegexException( preg_last_error_msg(), preg_last_error() );
				}

				// Parse results
				$this->parseResults( $result );
			} catch ( RegexException $exception ) {
				return $this->service->errorBag->handle( $exception );
			}

			return TRUE;
		}

		/**
		 * Parse the preg_replace results.
		 *
		 * @param string|array $results An array of replaced strings, or a single string.
		 *
		 * @return void
		 */
		protected function parseResults( string|array $results ): void {
			if ( is_string( $results ) ) {
				$results = [ $results ];
			}
			$this->results = $results;
		}

		/**
		 * Start building a regex pattern and register a callback or replacement
		 * string.
		 *
		 * @param string|callable $replacement    An array of replacements. This could be in either of these
		 *                                        formats, or a combination of both:
		 *                                        [ 'regex-pattern' => 'replacement-string' ]
		 *                                        [ 'regex-pattern' => 'callable' ]
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 */
		public function register( string|callable $replacement = '' ): \OOPCRE\Foundation\Pattern\PatternBuilder {
			// Generate a new key for the builder
			$key = $this->patternBuilderBag->generateKey();

			// If the input is an string, register a closure
			if ( is_string( $replacement ) ) {
				$this->map[ $key ][ 'replacement' ] = fn() => $replacement;
			} else {
				// Try to call the callback
				$this->map[ $key ][ 'replacement' ] = $replacement;
			}
			return $this->patternBuilderBag->register( $key );
		}

		/**
		 * Returns an array of items that have been replaced by
		 * preg_replace. If the subject was a string, then the return
		 * value will also be a string. If the subject was an array,
		 * then the return value will be an array too.
		 *
		 * @return string|string[]
		 *
		 * @throws \OOPCRE\Foundation\Exception\RegexNotExecutedYet
		 */
		public function results(): string|array {
			// Too soon. Regex has not been executed yet.
			if ( ! isset( $this->results[ 0 ] ) ) {
				$this->service->errorBag->handle( new \OOPCRE\Foundation\Exception\RegexNotExecutedYet );
				return '';
			}

			// If there's only 1 item in the results
			if ( ! isset( $this->results[ 1 ] ) ) {
				return $this->results[ 0 ];
			}

			return $this->results;
		}
	}