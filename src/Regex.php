<?php

	namespace OOPCRE;

	use OOPCRE\Foundation\ServiceProvider;
	use OOPCRE\Foundation\Configurator;
	use OOPCRE\Foundation\Definition\Option;
	use OOPCRE\Foundation\Pattern\ModifierBuilder;
	use OOPCRE\Foundation\Bag\ErrorBag;

	use OOPCRE\Foundation\PCRE\PregFilterMultiple;
	use OOPCRE\Foundation\PCRE\PregMatch;
	use OOPCRE\Foundation\PCRE\PregMatchAll;
	use OOPCRE\Foundation\PCRE\PregReplace;
	use OOPCRE\Foundation\PCRE\PregGrep;
	use OOPCRE\Foundation\PCRE\PregReplaceMultiple;
	use OOPCRE\Foundation\PCRE\PregSplit;
	use OOPCRE\Foundation\PCRE\PregFilter;

	/**
	 * The entry for all of our regexes. We start performing
	 * regex on a subject by instantiating this class and
	 * passing a subject to it.
	 *
	 * @package OOPCRE
	 * @author  Jill Johansson
	 * @version 1.0.0
	 */
	class Regex {

		/**
		 * Holds an instance of the service provider for our
		 * application.
		 *
		 * @var \OOPCRE\Foundation\ServiceProvider $service
		 */
		private readonly ServiceProvider $service;

		/**
		 * Initialize the regex operation on a given subject.
		 * A subject can be any of these types:
		 * 1) String
		 * 2) String[] ( Arrays with strings/stringables as values )
		 * 5) Integer
		 * 6) Float
		 * 7) Objects that have a _toString() method
		 *
		 * Passing a null value will short-circuit the operation
		 * and throw an exception, or return false.
		 *
		 * @param mixed $subject The subject to perform the regex operations on.
		 */
		public function __construct( array|int|float|string|object $subject ) {
			$this->service = new ServiceProvider( is_array( $subject ) ? $subject : (string) $subject );
		}

		/**
		 * Shut down the service provider on destruction.
		 */
		public function __destruct() {
			$this->service->destroy();
		}

		/**
		 * Get the configurator instance for chaining.
		 *
		 * @return \OOPCRE\Foundation\Configurator
		 */
		public function configs(): Configurator {
			return $this->service->config;
		}

		/**
		 * Get the error bag.
		 *
		 * @return \OOPCRE\Foundation\Bag\ErrorBag
		 */
		public function errorBag(): ErrorBag {
			return $this->service->errorBag;
		}

		/**
		 * Get an array of all the thrown exceptions.
		 *
		 * @return array
		 */
		public function errors(): array {
			return $this->service->errorBag->items();
		}

		/**
		 * Perform a preg_filter on a given subject.
		 *
		 * @return \OOPCRE\Foundation\PCRE\PregFilter
		 */
		public function filter(): PregFilter {
			return new PregFilter( $this->service );
		}

		/**
		 * Perform a preg_filter on multiple items.
		 *
		 * @return \OOPCRE\Foundation\PCRE\PregFilterMultiple
		 */
		public function filterMulti(): PregFilterMultiple {
			return new PregFilterMultiple( $this->service );
		}

		/**
		 * Get the value of a given config key.
		 *
		 * @param \OOPCRE\Foundation\Definition\Option $option
		 *
		 * @return mixed
		 */
		public function getConfig( Option $option ): mixed {
			return $this->service->config->getConfig( $option );
		}

		/**
		 * Get an instance of the modifier bag to be applied globally.
		 *
		 * @return \OOPCRE\Foundation\Pattern\ModifierBuilder
		 */
		public function globalModifiers(): ModifierBuilder {
			return $this->service->modifierBuilder;
		}

		/**
		 * Perform a preg_grep on a given subject.
		 *
		 * @return \OOPCRE\Foundation\PCRE\PregGrep
		 */
		public function grep(): PregGrep {
			return new PregGrep( $this->service );
		}

		/**
		 * Get the error message of the last thrown exception.
		 *
		 * @param bool $pop Whether to remove the retrieved exception from
		 *                  the bag or not.
		 *
		 * @return string The last occurred message's text.
		 */
		public function lastErrorMessage( bool $pop = FALSE ): string {
			return (string) $this->lastError( $pop )?->getMessage();
		}

		/**
		 * Return the last thrown exception.
		 *
		 * @param bool $pop Whether to remove the retrieved exception from
		 *                  the bag or not.
		 *
		 * @return \Throwable|null If there was an error, it returns an instance of
		 *                         the thrown exception. Otherwise, returns null.
		 */
		public function lastError( bool $pop = FALSE ): ?\Throwable {
			return $this->service->errorBag->latest( $pop );
		}

		/**
		 * Match the subject against the pattern.
		 *
		 * @return \OOPCRE\Foundation\PCRE\PregMatch
		 *
		 */
		public function match(): PregMatch {
			return new PregMatch( $this->service );
		}

		/**
		 * Match all the occurrences of a pattern against a subject.
		 *
		 * @return \OOPCRE\Foundation\PCRE\PregMatchAll
		 */
		public function matchAll(): PregMatchAll {
			return new PregMatchAll( $this->service );
		}

		/**
		 * Perform a regex replace on a subject.
		 *
		 * @return \OOPCRE\Foundation\PCRE\PregReplace
		 */
		public function replace(): PregReplace {
			return new PregReplace( $this->service );
		}

		/**
		 * Perform a replace on a subject using multiple patterns
		 * and multiple replacements.
		 *
		 * @return \OOPCRE\Foundation\PCRE\PregReplaceMultiple
		 */
		public function replaceMulti(): PregReplaceMultiple {
			return new PregReplaceMultiple( $this->service );
		}

		/**
		 * Set a config using the given value.
		 *
		 * @param Option $option A config option, which is a case from the Option enum.
		 * @param mixed  $value  The value of the config. Depends on the option. Invalid
		 *                       values will most likely be dropped, or raise an
		 *                       exception.
		 *
		 * @return \OOPCRE\Foundation\Configurator
		 */
		public function setConfig( Option $option, mixed $value = NULL ): Configurator {
			return $this->service->config->setConfig( $option, $value );
		}

		/**
		 * Perform a preg_split on a given subject.
		 *
		 * @return \OOPCRE\Foundation\PCRE\PregSplit
		 */
		public function split(): PregSplit {
			return new PregSplit( $this->service );
		}
	}