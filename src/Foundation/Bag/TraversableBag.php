<?php

	namespace OOPCRE\Foundation\Bag;

	use OOPCRE\Foundation\Exception\InvalidBagKeyException;
	use OOPCRE\Foundation\Skeleton\BagSkeleton;

	/**
	 * Base class for bags that support iteration and can
	 * be used in a foreach loop.
	 *
	 */
	abstract class TraversableBag implements BagSkeleton {

		/**
		 * Holds an array of items for this bag.
		 *
		 * @var \OOPCRE\Foundation\Bag\TraversableBag[]
		 */
		protected array $items = [];

		/**
		 * Holds the key to this item in the bag.
		 *
		 * @var string $key
		 */
		protected string $key;

		/**
		 * Return the current element
		 *
		 * @link https://php.net/manual/en/iterator.current.php
		 * @return mixed Can return any type.
		 */
		public function current(): mixed {
			// TODO: Implement current() method.
		}

		/**
		 * Empty the bag.
		 *
		 * @return void
		 */
		public function empty(): void {
			$this->items = [];
		}

		/**
		 * Generate a key for a bag item.
		 *
		 * @param string $prefix
		 * @param string $name
		 *
		 * @return string
		 */
		public function generateKey( string $name = '', string $prefix = 'oopcre_', ): string {
			// Check if the provided key can be used
			if ( ! empty( $name ) ) {
				$name = preg_replace( '[^A-z0-9_-]', '', $name );
				if ( ! empty( $name ) ) {
					return "oopcre_{$name}";
				}
			}
			return uniqid( $prefix );
		}

		/**
		 * Whether there is any pattern added to the bag or not.
		 *
		 * @return bool
		 */
		public function isEmpty(): bool {
			return empty( $this->items );
		}

		/**
		 * Get an specific item from bag.
		 *
		 * @param string $key
		 *
		 * @return mixed
		 * @throws \OOPCRE\Foundation\Exception\InvalidBagKeyException
		 */
		public function itemByKey( string $key ) {
			if ( isset( $this->items[ $key ] ) ) {
				return $this->items[ $key ];
			}
			throw new InvalidBagKeyException;
		}

		/**
		 * Return the bag items.
		 *
		 *
		 * @return array
		 */
		public function items(): array {
			return $this->items;
		}

		/**
		 * Return the key of the current element
		 *
		 * @link https://php.net/manual/en/iterator.key.php
		 */
		public function key(): string {
			return $this->key;
		}

		/**
		 * Return the first item of the bag.
		 *
		 * @return \OOPCRE\Foundation\Bag\TraversableBag
		 */
		public function first(): TraversableBag {
			return $this->items[ array_key_first( $this->items ) ];
		}

		/**
		 * Return the last item of the bag.
		 *
		 * @return \OOPCRE\Foundation\Bag\TraversableBag
		 */
		public function last(): TraversableBag {
			return $this->items[ array_key_last( $this->items ) ];
		}

		/**
		 * Move forward to next element
		 *
		 * @link https://php.net/manual/en/iterator.next.php
		 * @return void Any returned value is ignored.
		 */
		public function next(): void {
			// TODO: Implement next() method.
		}

		/**
		 * Whether a offset exists
		 *
		 * @link https://php.net/manual/en/arrayaccess.offsetexists.php
		 *
		 * @param mixed $offset <p>
		 *                      An offset to check for.
		 *                      </p>
		 *
		 * @return bool true on success or false on failure.
		 * </p>
		 * <p>
		 * The return value will be casted to boolean if non-boolean was returned.
		 */
		public function offsetExists( mixed $offset ): bool {
			// TODO: Implement offsetExists() method.
		}

		/**
		 * Offset to retrieve
		 *
		 * @link https://php.net/manual/en/arrayaccess.offsetget.php
		 *
		 * @param mixed $offset <p>
		 *                      The offset to retrieve.
		 *                      </p>
		 *
		 * @return mixed Can return all value types.
		 */
		public function offsetGet( mixed $offset ): mixed {
			// TODO: Implement offsetGet() method.
		}

		/**
		 * Offset to set
		 *
		 * @link https://php.net/manual/en/arrayaccess.offsetset.php
		 *
		 * @param mixed $offset <p>
		 *                      The offset to assign the value to.
		 *                      </p>
		 * @param mixed $value  <p>
		 *                      The value to set.
		 *                      </p>
		 *
		 * @return void
		 */
		public function offsetSet( mixed $offset, mixed $value ): void {
			// TODO: Implement offsetSet() method.
		}

		/**
		 * Offset to unset
		 *
		 * @link https://php.net/manual/en/arrayaccess.offsetunset.php
		 *
		 * @param mixed $offset <p>
		 *                      The offset to unset.
		 *                      </p>
		 *
		 * @return void
		 */
		public function offsetUnset( mixed $offset ): void {
			// TODO: Implement offsetUnset() method.
		}

		/**
		 * Rewind the Iterator to the first element
		 *
		 * @link https://php.net/manual/en/iterator.rewind.php
		 * @return void Any returned value is ignored.
		 */
		public function rewind(): void {
			// TODO: Implement rewind() method.
		}

		/**
		 * Checks if current position is valid
		 *
		 * @link https://php.net/manual/en/iterator.valid.php
		 * @return bool The return value will be casted to boolean and then evaluated.
		 * Returns true on success or false on failure.
		 */
		public function valid(): bool {
			// TODO: Implement valid() method.
		}

	}