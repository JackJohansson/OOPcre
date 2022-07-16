<?php

	namespace OOPCRE\Foundation\Contract;

	/**
	 * Provide support for counting the results, for certain operations
	 * such as preg_replace that allow it.
	 */
	trait CountsResults {
		/**
		 * Number of replaced items.
		 *
		 * @var int $count
		 */
		protected int $count = 0;

		/**
		 * Returns the number of replacements performed.
		 *
		 * @return int
		 */
		public function count(): int {
			return $this->count;
		}
	}