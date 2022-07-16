<?php

	namespace OOPCRE\Foundation\Pattern;

	use OOPCRE\Foundation\Skeleton\PatternSkeleton;

	/**
	 * Class to provide a way to group a number of rules.
	 *
	 */
	class Group extends Pattern implements PatternSkeleton {

		/**
		 * Holds the name for this group, if provided.
		 *
		 * @var string $groupName
		 */
		protected string $groupName;


		/**
		 * Accept a closure and assign its result to the pattern.
		 *
		 * @param \Closure $closure
		 */
		public static function create( $closure ): static {
			return new static( $closure );
		}

		/**
		 * Set the name for this pattern group.
		 *
		 * @param string $name
		 *
		 * @return \OOPCRE\Foundation\Pattern\Group
		 */
		public function groupName( string $name ): static {
			$this->groupName = $name;
			return $this;
		}
	}