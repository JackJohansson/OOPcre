<?php

	namespace OOPCRE\Foundation\Skeleton;

	/**
	 * Interface that will be implemented by the application's bags.
	 *
	 */
	interface BagSkeleton extends \Traversable, \Iterator, \ArrayAccess {

		/**
		 * Empty the bag.
		 *
		 * @return void
		 */
		public function empty(): void;

		/**
		 * Whether the bag is empty or not.
		 *
		 * @return bool
		 */
		public function isEmpty(): bool;

		/**
		 * Fetch an specific item from the bag.
		 *
		 * @param string $key The key of the item.
		 *
		 * @return mixed
		 */
		public function itemByKey( string $key );

		/**
		 * Get the items inside the bag.
		 *
		 * @return array
		 */
		public function items(): array;
	}