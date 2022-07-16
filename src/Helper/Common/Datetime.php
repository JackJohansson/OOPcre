<?php

	namespace OOPCRE\Helper\Common;
	/**
	 * Helper trait to provide regexes for working
	 * with dates and times.
	 *
	 * @package OOPCRE
	 * @version 1.0.0
	 */
	trait Datetime {

		/**
		 * Check if the string is a matching YYYY-MM-DD date with - as
		 * separator.
		 *
		 * @param string $date
		 *
		 * @return bool
		 */
		public function isDate_YMD( string $date ): bool {
			return (bool) @preg_match(
				'/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/',
				$date
			);
		}

		/**
		 * Check if the string is a matching dd-MM-YYYY date with - or . or / as
		 * separator.
		 *
		 * @param string $date
		 *
		 * @return bool
		 */
		public function isDate_dMY( string $date ): bool {
			return (bool) @preg_match(
				'/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/',
				$date
			);
		}

		/**
		 * Check if the string is a matching dd-mmm-YYYY date with - or . or / as
		 * separator.
		 *
		 * @param string $date
		 *
		 * @return bool
		 */
		public function isDate_dmmY( string $date ): bool {
			return (bool) @preg_match(
				'/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]|(?:Jan|Mar|May|Jul|Aug|Oct|Dec)))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2]|(?:Jan|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec))\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)(?:0?2|(?:Feb))\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9]|(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep))|(?:1[0-2]|(?:Oct|Nov|Dec)))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/',
				$date
			);
		}

		/**
		 * Checks if the string is a valid time in HH:MM 12-hour format, with optional leading 0.
		 *
		 * @param string $time
		 *
		 * @return bool
		 */
		public function isTime_HM12( string $time ): bool {
			return (bool) @preg_match(
				'/^(0?[1-9]|1[0-2]):[0-5][0-9]$/',
				$time
			);
		}

		/**
		 * Checks if the string is a valid time in HH:MM 12-hour format,
		 * with optional leading 0 and includes optional meridiems.
		 *
		 * @param string $time
		 *
		 * @return bool
		 */
		public function isTime_HM12Meridiem( string $time ): bool {
			return (bool) @preg_match(
				'/((1[0-2]|0?[1-9]):([0-5][0-9]) ?([AaPp][Mm]))/',
				$time
			);
		}

		/**
		 * Check if the string is a valid time in HH:MM 24-hour format
		 * with optional leading 0.
		 *
		 * @param string $time
		 *
		 * @return bool
		 */
		public function isTime_HM24( string $time ): bool {
			return (bool) @preg_match(
				'/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/',
				$time
			);
		}

		/**
		 * Check if the string is a valid time in HH:MM 24-hour format
		 * with leading 0.
		 *
		 * @param string $time
		 *
		 * @return bool
		 */
		public function isTime_HM24With0( string $time ): bool {
			return (bool) @preg_match(
				'/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/',
				$time
			);
		}

		/**
		 * Check if the string is a valid time in HH:MM:SS 24-hour format.
		 *
		 * @param string $time
		 *
		 * @return bool
		 */
		public function isTime_HMS( string $time ): bool {
			return (bool) @preg_match(
				'/(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)/',
				$time
			);
		}
	}