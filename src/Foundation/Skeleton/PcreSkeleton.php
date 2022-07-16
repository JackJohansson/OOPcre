<?php

	namespace OOPCRE\Foundation\Skeleton;

	use OOPCRE\Foundation\ServiceProvider;

	/**
	 * Interface implemented by PCRE classes.
	 *
	 * @package \OOPCRE
	 * @version 1.0.0
	 */
	interface PcreSkeleton {
		/**
		 * All the PCRE classes must have a constructor for service container.
		 *
		 * @param \OOPCRE\Foundation\ServiceProvider $provider An instance of the service provider class.
		 */
		public function __construct( ServiceProvider $provider );

		/**
		 * Execute the operation and possibly return a result.
		 *
		 * @return bool
		 */
		public function execute(): bool;
	}