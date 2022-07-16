<?php

	namespace OOPCRE\Helper\Common;

	/**
	 * Helper trait to provide regexes for working
	 * with filesystems.
	 *
	 * @package OOPCRE
	 * @version 1.0.0
	 */
	trait File {
		/**
		 * Check if the given name is a valid file name with
		 * a 3-4 characters extension.
		 *
		 * @param string $path
		 *
		 * @return bool
		 */
		public function isFilename( string $path ): bool {
			return (bool) @preg_match(
				'/^[\w,\s-]+\.[A-Za-z]{3,4}$/',
				$path
			);
		}

		/**
		 * Check if the input is a full path with filename and extension.
		 *
		 * @param string $path
		 *
		 * @return bool
		 */
		public function isFullPath( string $path ): bool {
			return (bool) @preg_match(
				'/((\/|\\|\/\/|https?:\\\\|https?:\/\/)[a-z0-9 _@\-^!#$%&+={}.\/\\\[\]]+)+\.[a-z]+$/',
				$path
			);
		}

		/**
		 * Check if the input is a path with optional filename and extension.
		 *
		 * @param string $path
		 *
		 * @return bool
		 */
		public function isPath( string $path ): bool {
			return (bool) @preg_match(
				'/^(.+)/([^/]+)$/',
				$path
			);
		}

	}