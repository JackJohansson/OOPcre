<?php

	namespace OOPCRE\Foundation\Pattern;

	/**
	 * Result of a regex match.
	 *
	 */
	class Result {

		/**
		 * The matched string.
		 *
		 * @var string $content
		 */
		public readonly string $content;

		/**
		 * Name for this match group.
		 *
		 * @var string $name
		 */
		public readonly string $name;

		/**
		 * The offset which this match
		 * has occurred at.
		 *
		 * @var int $offset
		 */
		public readonly int $offset;

		/**
		 *
		 * @param string $key
		 * @param array  $match
		 */
		public function __construct( string $key, array $match ) {
			$this->name    = $key;
			$this->content = $match[ 0 ];
			$this->offset  = $match[ 1 ];
		}
	}