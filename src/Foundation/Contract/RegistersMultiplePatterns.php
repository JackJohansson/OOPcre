<?php

	namespace OOPCRE\Foundation\Contract;

	use OOPCRE\Foundation\Bag\PatternBuilderBag;
	use OOPCRE\Foundation\ServiceProvider;

	/**
	 * Trait that enables the Preg_* classes to register
	 * multiple patterns.
	 *
	 */
	trait RegistersMultiplePatterns {
		/**
		 * Holds a bag of pattern builders, for operations that need more than one.
		 *
		 * @var \OOPCRE\Foundation\Bag\PatternBuilderBag $patternBuilderBag
		 */
		protected PatternBuilderBag $patternBuilderBag;

		/**
		 * Set up a new bag of patterns.
		 *
		 * @param \OOPCRE\Foundation\ServiceProvider $service
		 *
		 */
		public function __construct( ServiceProvider $service, ) {
			parent::__construct( $service );
			$this->patternBuilderBag = $service->resolve( PatternBuilderBag::class, TRUE );
		}

	}