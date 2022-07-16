<?php

	namespace OOPCRE\Foundation\PCRE;

	use OOPCRE\Foundation\Contract\RegistersPattern;
	use OOPCRE\Foundation\Exception\RegexException;

	/**
	 * Perform a preg_grep operation on a given subject.
	 *
	 * @package OOPCRE
	 * @version 1.0.0
	 */
	class PregGrep extends PregBase {
		use RegistersPattern;

		/**
		 * Whether to reverse the filter and remove
		 * the matching items.
		 *
		 * @var bool $invert
		 */
		private bool $invert = FALSE;

		/**
		 * Holds the filtered results.
		 *
		 * @var array $results
		 */
		private array $results = [];

		/**
		 * Execute the preg_grep and return the result.
		 *
		 * @return bool
		 * @throws \OOPCRE\Foundation\Exception\RegexException
		 */
		public function execute(): bool {
			try {
				$subject = $this->service->subject( FALSE );

				// Convert to an array, of the subject is an string.
				if ( is_string( $subject ) ) {
					$subject = [ $subject ];
				}

				$result = @preg_grep(
					$this->patternBuilder->build(),
					$subject,
					$this->invert ? 1 : 0
				);

				// A regex error has occurred
				if ( FALSE === $result ) {
					throw new RegexException( preg_last_error_msg(), preg_last_error() );
				}
				$this->results = $result;
			} catch ( \OOPCRE\Foundation\Exception\RegexException $exception ) {
				return $this->service->errorBag->handle( $exception );
			}

			return TRUE;
		}

		/**
		 * Whether to invert the filter and remove the
		 * matching items instead.
		 *
		 * @param bool $invert
		 *
		 * @return $this
		 */
		public function invert( bool $invert ): static {
			$this->invert = $invert;
			return $this;
		}

		/**
		 * The result of the filter operation. Returns an empty
		 * array if accessed before the operation is run.
		 *
		 * @return array
		 */
		public function results(): array {
			return $this->result;
		}
	}