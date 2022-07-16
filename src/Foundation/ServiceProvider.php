<?php

	namespace OOPCRE\Foundation;

	use OOPCRE\Foundation\Bag\ErrorBag;
	use OOPCRE\Foundation\Bag\PatternBuilderBag;
	use OOPCRE\Foundation\Exception\InvalidServiceClassException;
	use OOPCRE\Foundation\Exception\InvalidServiceException;
	use OOPCRE\Foundation\Pattern\PatternBuilder;
	use \OOPCRE\Foundation\Pattern\ModifierBuilder;

	/**
	 * Class to resolve dependencies for our app.
	 *
	 * @property ErrorBag          $errorBag
	 * @property Configurator      $config
	 * @property PatternBuilderBag $patternBuilderBag
	 * @property PatternBuilder    $patternBuilder
	 * @property ModifierBuilder   $modifierBuilder
	 */
	class ServiceProvider {

		/**
		 * A map of services and their accessor name.
		 *
		 * @var array $map
		 */
		private array $serviceMap;

		/**
		 * Holds an array of initialized services.
		 *
		 * @var array $services
		 */
		private static array $services = [];

		/**
		 *  Boot the IoC and set the dependencies.
		 *
		 * @param int|array|string|float $subject The input subject to perform the regex on.
		 */
		public function __construct( private readonly int|array|string|float $subject ) {
			$this->serviceMap = \OOPCRE\Foundation\Definition\ServiceMap::map();
		}

		/**
		 * @param string $name Name of the property that should be fetched.
		 *
		 * @return object
		 * @throws \OOPCRE\Foundation\Exception\InvalidServiceException
		 * @throws \OOPCRE\Foundation\Exception\InvalidServiceClassException
		 */
		public function __get( string $name ): object {
			// Service not initialized
			if ( ! isset( self::$services[ $name ] ) ) {
				// If service is registered
				if ( isset( $this->serviceMap[ $name ] ) ) {
					self::$services[ $name ] = $this->resolve( $this->serviceMap[ $name ], TRUE );
				} else {
					// Invalid service
					throw new InvalidServiceException( $name );
				}
			}

			// Return the service
			return self::$services[ $name ];
		}

		/**
		 * Get an instance of the required class.
		 *
		 * @param string $class   The name of the class to be resolved.
		 * @param bool   $fresh   If a new instance of the requested class should be provided.
		 * @param mixed  ...$args Optional. The arguments to be passed to the class.
		 *
		 * @return object
		 * @throws \OOPCRE\Foundation\Exception\InvalidServiceClassException
		 */
		public function resolve( string $class, bool $fresh = FALSE, ...$args ): mixed {
			// Try to resolve the service
			try {
				// Invalid class.
				if ( ! class_exists( $class ) ) {
					throw new InvalidServiceClassException( $class );
				}

				// If it's an internal service
				if ( $property = array_search( $class, $this->serviceMap, TRUE ) ) {
					// If a fresh clone is required
					if ( $fresh ) {
						return new $class( ...$this->buildParameters( $class, ...$args ) );
					}
					// Let the service provider resolve it
					return $this->$property;
				}

				// A third-party class is requested.
				return new $class( ...$this->buildParameters( $class, ...$args ) );

			} catch ( InvalidServiceClassException $exception ) {
				$this->errorBag->handle( $exception );
			}

			return new \stdClass;
		}

		/**
		 * Try to resolve the service's constructor arguments.
		 *
		 */
		private function buildParameters( string $class, ...$args ): array {
			// See if the target class requires any dependency injection
			$reflection = new \ReflectionClass( $class );
			$parameters = $reflection->getConstructor()?->getParameters();

			// If the class requires an instance of the service provider
			if (
				isset( $parameters[ 0 ] ) &&
				$parameters[ 0 ]->getType() instanceof \ReflectionNamedType &&
				$parameters[ 0 ]->getType()->getName() === __CLASS__
			) {
				return [ $this, ...$args ];
			}
			return [ ...$args ];
		}

		/**
		 * Clear the services on shutdown.
		 *
		 * @return void
		 */
		public function destroy(): void {
			self::$services = [];
		}

		/**
		 * Parse and get the regex subject.
		 *
		 * @param bool $stringify Whether to convert the subject to a string,
		 *                        if needed.
		 *
		 * @return string|string[]
		 */
		public function subject( bool $stringify = TRUE ): string|array {
			// If a string is required and the subject is an array
			if ( $stringify && is_array( $this->subject ) ) {
				return (string) array_reduce( $this->subject, fn( mixed $carry, mixed $item ) => (string) $item );
			}
			return $this->subject;
		}

	}