<?php

	namespace OOPCRE\Foundation\Bag;

	use OOPCRE\Foundation\Exception\EmptyPatternBuilderException;
	use OOPCRE\Foundation\Pattern\PatternBuilder;

	/**
	 * Container class that holds a bag of regex builders.
	 * These rules will be compiled into a pattern to be
	 * used in regex functions.
	 *
	 * @property PatternBuilder[] $items
	 */
	class PatternBuilderBag extends TraversableBag {

		/**
		 * Resolve the service provider
		 *
		 * @param \OOPCRE\Foundation\ServiceProvider $service
		 */
		public function __construct( private \OOPCRE\Foundation\ServiceProvider $service ) { }

		/**
		 * Try to build all the items of the bag.
		 *
		 * @return string[]
		 *
		 * @throws \OOPCRE\Foundation\Exception\EmptyPatternBuilderException
		 */
		public function buildAll(): array {
			// No pattern exist in the bag
			if ( $this->isEmpty() ) {
				throw new EmptyPatternBuilderException;
			}

			$items = [];
			foreach ( $this->items as $key => $builder ) {
				$items[ $key ] = $builder->build();
			}
			return $items;
		}

		/**
		 * Return an array of builders inside the bag.
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder[]
		 */
		public function builders(): array {
			return $this->items;
		}

		/**
		 * Start building a new pattern. Returns an instance of the
		 * pattern builder.
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 */
		public function register( string $key ): PatternBuilder {
			return $this->items[ $key ] = $this->service->resolve( PatternBuilder::class, TRUE );
		}

	}