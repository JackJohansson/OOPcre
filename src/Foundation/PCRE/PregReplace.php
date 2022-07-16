<?php

	namespace OOPCRE\Foundation\PCRE;

	use OOPCRE\Foundation\Contract\CountsResults;
	use OOPCRE\Foundation\Contract\RegistersPattern;
	use OOPCRE\Foundation\Contract\SupportsLimit;
	use OOPCRE\Foundation\Exception\RegexException;

	/**
	 * Perform a preg_replace operation on a given subject.
	 *
	 * @package OOPCRE
	 * @version 1.0.0
	 */
	class PregReplace extends PregBase {
		use RegistersPattern,
			SupportsLimit,
			CountsResults;

		/**
		 * The string to replace the matched items.
		 *
		 * @var string $replacement
		 */
		protected string $replacement = '';

		/**
		 * Holds the result of the regex operation.
		 *
		 * @var string $result
		 */
		protected string $result = '';

		/**
		 * Execute the regex and return the result.
		 *
		 * @return bool
		 * @throws \OOPCRE\Foundation\Exception\RegexException
		 */
		public function execute(): bool {
			try {
				$result = @preg_replace(
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

		/**
		 * Set the replacement for the matched strings.
		 *
		 * @param string $replacement A string to be used to replace the matched
		 *                            strings.
		 *
		 * @return \OOPCRE\Foundation\PCRE\PregReplace
		 */
		public function replacement( string $replacement = '' ): static {
			$this->replacement = $replacement;
			return $this;
		}

		/**
		 * Return the modified string, or the original string if no
		 * replacement has occurred. If this method is accessed without
		 * checking whether the operation was successful or not, it
		 * returns an empty string.
		 *
		 * @return string
		 */
		public function result(): string {
			return $this->result;
		}

	}