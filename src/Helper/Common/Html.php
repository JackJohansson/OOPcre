<?php

	namespace OOPCRE\Helper\Common;
	/**
	 * Helper trait to provide regexes for working
	 * with HTML content.
	 *
	 * @package OOPCRE
	 * @version 1.0.0
	 */
	trait Html {
		/**
		 * Count how many unique HTML tags have inline javascript handlers attached to them.
		 *
		 * @param string $html
		 *
		 * @return int
		 */
		public function uniqueElementsWithInlineJsHandler( string $html ): int {
			return (int) @preg_match_all(
				'/(?:<[^>]+\s)(on\S+)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?/',
				$html
			);
		}

		/**
		 * Count how many HTML tags exist in a given string. Counts
		 * both opening and closing HTML tags.
		 *
		 * @param string $html
		 *
		 * @return int
		 */
		public function countHtmlTag( string $html ): int {
			return (int) @preg_match_all(
				'/<\/?[\w\s]*>|<.+[\W]>/',
				$html
			);
		}

		/**
		 * Counts how many inline javascript handlers exist in the
		 * HTML code.
		 *
		 * @param string $html
		 *
		 * @return int
		 */
		public function inlineJsHandlers( string $html ): int {
			return (int) @preg_match_all(
				'/\bon\w+=\S+(?=.*>)/',
				$html
			);
		}
	}