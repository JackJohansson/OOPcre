<?php

	namespace OOPCRE\Foundation\PCRE;

	use OOPCRE\Foundation\Contract\RegistersPattern;
	use OOPCRE\Foundation\Contract\SupportsLimit;

	/**
	 * PCRE class to perform a preg_split on a given
	 * subject.
	 *
	 * @package OOPCRE
	 * @version 1.0.0
	 */
	class PregSplit extends PregBase {
		use RegistersPattern,
			SupportsLimit;

		/**
		 * An array of seperated strings.
		 *
		 * @var array $results
		 */
		private array $results = [];

		/**
		 * Execute the regex and return the result.
		 *
		 * @return mixed
		 * @throws \OOPCRE\Foundation\Exception\RegexException
		 */
		public function execute(): bool {
			try {
				$results = @preg_split(
					$this->patternBuilder->build(),
					$this->service->subject(),
					$this->limit
				);

				// Unsuccessful
				if ( FALSE === $results ) {
					throw new \OOPCRE\Foundation\Exception\RegexException;
				}

				// Set the results
				$this->results = $results;
			} catch ( \OOPCRE\Foundation\Exception\RegexException $exception ) {
				return ! $this->service->errorBag->handle( $exception );
			}

			return TRUE;
		}

		/**
		 * Return an array of matched strings.
		 *
		 * @return array
		 */
		public function results(): array {
			return $this->results;
		}
	}