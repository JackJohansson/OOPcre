<?php

	namespace OOPCRE\Foundation\Bag;


	use OOPCRE\Foundation\Definition\Option;

	use OOPCRE\Foundation\Exception\EmptyInputPatternException;
	use OOPCRE\Foundation\Exception\EmptyPatternBuilderException;
	use OOPCRE\Foundation\Exception\InvalidConfigException;
	use OOPCRE\Foundation\Exception\InvalidDelimiterException;
	use OOPCRE\Foundation\Exception\InvalidPatternException;
	use OOPCRE\Foundation\Exception\InvalidServiceClassException;
	use OOPCRE\Foundation\Exception\InvalidServiceException;
	use OOPCRE\Foundation\Exception\RegexException;

	/**
	 * Class to hold a bag of errors that have occurred
	 * during a regex operation.
	 *
	 * @property \Throwable[] $items
	 */
	class ErrorBag extends TraversableBag {

		/**
		 * Resolve the service container.
		 *
		 * @param \OOPCRE\Foundation\ServiceProvider $service
		 */
		public function __construct( private \OOPCRE\Foundation\ServiceProvider $service ) { }

		/**
		 * Try to handle a thrown exception based on the configuration.
		 *
		 * @param \OOPCRE\Foundation\Exception\RegexException $exception
		 *
		 * @return false
		 * @throws \OOPCRE\Foundation\Exception\RegexException
		 */
		public function handle( RegexException $exception ): bool {
			// If exceptions are disabled completely
			if ( FALSE === $this->service->config->getConfig( Option::ENABLE_EXCEPTIONS ) ) {
				return $this->write( $exception );
			}

			// Find the option responsible for raising this exception
			$option = match ( $exception::class ) {
				EmptyInputPatternException::class,
				InvalidPatternException::class      => Option::THROW_EXCEPTION_ON_BAD_PATTERN,
				EmptyPatternBuilderException::class => Option::THROW_EXCEPTION_ON_NO_PATTERN,
				InvalidDelimiterException::class    => Option::DELIMITER,
				InvalidConfigException::class       => Option::THROW_EXCEPTION_ON_BAD_CONFIG,
				InvalidServiceClassException::class,
				InvalidServiceException::class      => Option::THROW_EXCEPTION_ON_BAD_SERVICE,
			};

			// Try to decide what to do with the thrown exception
			if ( FALSE === $this->service->config->getConfig( $option ) ) {
				return $this->write( $exception );
			}

			throw $exception;
		}

		/**
		 * Add a new error to the bag.
		 *
		 * @param \Throwable $throwable
		 *
		 * @return true
		 */
		public function write( \Throwable $throwable ): bool {
			$this->items[ $this->generateKey() ] = $throwable;
			return TRUE;
		}

		/**
		 * Get an specific item from bag.
		 *
		 * @param string $key
		 *
		 * @return \Throwable
		 * @throws \OOPCRE\Foundation\Exception\InvalidBagKeyException
		 */
		public function itemByKey( string $key ): \Throwable {
			return parent::itemByKey( $key );
		}

		/**
		 * Return the last thrown exception.
		 *
		 * @param bool $pop
		 *
		 * @return \Throwable|null
		 */
		public function latest( bool $pop ): ?\Throwable {
			// Nothing int the bag
			if ( empty( $this->items ) ) {
				return NULL;
			}

			// If the last error should be pulled from the list
			if ( $pop ) {
				return array_pop( $this->items );
			}

			return $this->items[ array_key_last( $this->items ) ];
		}
	}