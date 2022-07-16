<?php

	namespace OOPCRE\Foundation\Pattern\Syntax;

	use OOPCRE\Foundation\Pattern\Pattern;
	use OOPCRE\Foundation\Skeleton\PatternSkeleton;

	/**
	 * Class to match a character range.
	 *
	 */
	class Range extends Pattern implements PatternSkeleton {

		/**
		 * Add a character range pattern to the regex.
		 *
		 * @param array $range
		 * @param bool  $not
		 *
		 * @return \OOPCRE\Foundation\Pattern\Syntax\Range
		 * @throws \OOPCRE\Foundation\Exception\EmptyInputPatternException
		 * @internal
		 */
		public static function create( $range, bool $not = FALSE ): static {
			// Nothing to add
			$parsed = self::extractChar(
				implode(
					'',
					array_map( [ __CLASS__, 'parse' ], array_keys( $range ), array_values( $range ) )
				)
			);

			return new static( '[' . ( $not ? '^' : '' ) . $parsed . ']' );
		}

		/**
		 * Parse the range array and build the regex.
		 *
		 * @param mixed $key
		 * @param mixed $value
		 *
		 * @return string
		 */
		private static function parse( mixed $key, mixed $value ): string {
			// If the key is a number, then it could be a number range
			// If the value is also a number, it's a number range.
			if ( is_int( $key ) && is_int( $value ) ) {
				return self::parseNumberRange( $key, $value );
			}
			// Probably a range of string characters
			return self::parseStringRange( (string) $key, (string) $value );
		}

		/**
		 * Parse a range of integers.
		 *
		 * @param int $start
		 * @param int $end
		 *
		 * @return string
		 */
		public static function parseNumberRange( int $start, int $end ): string {
			$start = abs( $start ) % 10;
			$end   = abs( $end ) % 10;

			$min = min( $start, $end );
			$max = max( $start, $end );

			// Ends in 0. Just return the starting character.
			if ( 0 === $max ) {
				return (string) $min;
			}

			// Correct the order based on the range values
			return match ( $min < $max ) {
				TRUE  => "$min-$max",
				FALSE => "$max-$min"
			};
		}

		/**
		 * Parse a range of string characters.
		 *
		 * @param string $start
		 * @param string $end
		 *
		 * @return string
		 */
		private static function parseStringRange( string $start, string $end ): string {
			$start = substr( $start, 0, 1 );
			$end   = substr( $end, 0, 1 );

			// Detect the start and end of the range, if they exist. if not, return the starting character.
			return match ( 0 === ( $cmp = strcmp( $start, $end ) ) ? 0 : $cmp / abs( $cmp ) ) {
				0  => $start,
				1  => "$end-$start",
				-1 => "$start-$end"
			};
		}

	}