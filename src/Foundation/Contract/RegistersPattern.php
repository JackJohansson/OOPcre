<?php

	namespace OOPCRE\Foundation\Contract;

	use OOPCRE\Foundation\Pattern\ModifierBuilder;
	use OOPCRE\Foundation\Pattern\PatternBuilder;
	use OOPCRE\Foundation\ServiceProvider;

	/**
	 * Trait that enables the Preg_* classes to register a single
	 * pattern.
	 */
	trait RegistersPattern {

		/**
		 * Holds an instance of the pattern builder.
		 *
		 * @var \OOPCRE\Foundation\Pattern\PatternBuilder $patternBuilder
		 */
		protected PatternBuilder $patternBuilder;

		/**
		 * Instantiate the pattern builder.
		 *
		 * @param \OOPCRE\Foundation\ServiceProvider $service
		 */
		public function __construct( ServiceProvider $service ) {
			parent::__construct( $service );
			$this->patternBuilder = $service->resolve( PatternBuilder::class, TRUE );
		}

		/**
		 * Return an instance of the modifier bag.
		 *
		 * @return \OOPCRE\Foundation\Pattern\ModifierBuilder
		 */
		public function modifiers(): ModifierBuilder {
			return $this->patternBuilder->modifiers();
		}

		/**
		 * Return the pattern builder.
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 */
		public function patterns(): PatternBuilder {
			return $this->patternBuilder;
		}
	}