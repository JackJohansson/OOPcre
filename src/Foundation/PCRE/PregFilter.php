<?php

	namespace OOPCRE\Foundation\PCRE;

	use OOPCRE\Foundation\Exception\RegexException;

	/**
	 * Perform a preg_filter operation on a given subject.
	 *
	 * @package OOPCRE
	 * @version 1.0.0
	 */
	class PregFilter extends PregReplace {

		/**
		 * Perform the preg_filter and return the result.
		 *
		 * @return bool
		 * @throws \OOPCRE\Foundation\Exception\RegexException
		 */
		public function execute(): bool {
			try {
				$result = @preg_filter(
					$this->patternBuilder->build(),
					$this->replacement,
					$this->service->subject(),
					$this->limit,
					$this->count
				);

				// An error occurred
				if ( NULL === $result ) {
					throw new RegexException( preg_last_error_msg(), preg_last_error() );
				}

				$this->result = $result;
			} catch ( \OOPCRE\Foundation\Exception\RegexException $exception ) {
				return $this->service->errorBag->handle( $exception );
			}

			return TRUE;
		}
	}