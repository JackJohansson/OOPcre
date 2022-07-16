<?php

	namespace OOPCRE\Foundation\PCRE;

	use OOPCRE\Foundation\ServiceProvider;
	use OOPCRE\Foundation\Skeleton\PcreSkeleton;

	/**
	 * Base PCRE class extended by regex classes.
	 *
	 * @package OOPCRE
	 * @version 1.0.0
	 */
	abstract class PregBase implements PcreSkeleton {
		/**
		 * Holds the status of regex's result.
		 *
		 * @var bool $success
		 */
		protected bool $success = FALSE;

		/**
		 * Set up the service container.
		 *
		 * @param \OOPCRE\Foundation\ServiceProvider $service
		 *
		 */
		public function __construct( protected readonly ServiceProvider $service ) { }

		/**
		 * Whether the execution of the regex was successful
		 * or not.
		 *
		 * @return bool
		 */
		public function success(): bool {
			return $this->success;
		}
	}