<?php

	namespace OOPCRE\Foundation\Contract;

	/**
	 * Add support for the limitation of regex operations,
	 * on certain operations such as preg_replace that
	 * allow it.
	 */
	trait SupportsLimit {
		/**
		 * Total number of replacements to be
		 * performed.
		 *
		 * @var int $limit
		 */
		protected int $limit = -1;

		/**
		 * Limit the number of replaces that should be performed.
		 * Defaults to -1, which is unlimited.
		 *
		 * @param int $limit
		 *
		 * @return $this
		 */
		public function limit( int $limit ): static {
			$this->limit = abs( $limit );
			return $this;
		}
	}