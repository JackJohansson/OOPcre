<?php

	namespace OOPCRE\Foundation\PCRE;

	use OOPCRE\Foundation\Exception\RegexException;

	/**
	 *  Perform a preg_filter operation on a given subject,
	 * using an array of patterns.
	 *
	 *
	 * @package OOPCRE
	 * @version 1.0.0
	 */
	class PregFilterMultiple extends PregReplaceMultiple {

		/**
		 * Perform the filter and return the result.
		 *
		 * @return bool
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

				// Invoke the callbacks on replacement patterns
				$replacements = array_map( 'call_user_func', array_column( $this->map, 'replacement' ) );

				$result = @preg_filter(
					array_column( $this->map, 'pattern' ),
					$replacements,
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
	}