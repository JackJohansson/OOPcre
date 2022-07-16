<?php

	namespace OOPCRE\Foundation\Definition;

	use OOPCRE\Foundation\Exception\InvalidDelimiterException;

	/**
	 * Holds a list of valid config options. We'll
	 * use this to quickly determine whether a
	 * provided config should be processed further
	 * or not.
	 *
	 */
	enum Option: string {
		/**
		 * The delimiter used in the pattern.
		 *
		 */
		case DELIMITER = 'delimiter';

		/**
		 * Whether to quote the regex or not.
		 *
		 */
		case QUOTE = 'quote';

		/**
		 * Whether to throw an exception when a null subject
		 * has been passed.
		 */
		case THROW_EXCEPTION_ON_NULL = 'exception_on_null';

		/**
		 * Throw an exception whenever an error occurs.
		 *
		 */
		case ENABLE_EXCEPTIONS = 'exception_on_error';

		/**
		 * Whether to throw an exception whenever a malformed
		 * pattern has been passed to the pattern bag or not.
		 */
		case THROW_EXCEPTION_ON_BAD_PATTERN = 'exception_on_bad_pattern';

		/**
		 * Whether to throw an exception when no pattern has been added yet.
		 *
		 */
		case THROW_EXCEPTION_ON_NO_PATTERN = 'exception_on_no_pattern';

		/**
		 * Whether to throw an exception when a bad config key has
		 * been passed or not.
		 *
		 */
		case THROW_EXCEPTION_ON_BAD_CONFIG = 'exception_on_bad_config';

		/**
		 * Whether to throw an exception whenever an invalid service
		 * has been requested from the service provider.
		 *
		 */
		case THROW_EXCEPTION_ON_BAD_SERVICE = 'exception_on_bad_service';

		/**
		 * Whether to fallback to the default configuration value
		 * if a provided config is invalid.
		 *
		 */
		case DEFAULT_OPTION_ON_ERROR = 'default_option_on_error';

		/**
		 * Whether to throw an exception, if the regex result is accessed
		 * before the operation is run.
		 *
		 */
		case THROW_EXCEPTION_IF_EARLY = 'exception_on_early_access';

		/**
		 * Return an array of configuration keys and their default
		 * values.
		 *
		 * @return array
		 */
		public static function configMap(): array {
			return [
				self::DEFAULT_OPTION_ON_ERROR->value        => TRUE,
				self::DELIMITER->value                      => '~',
				self::QUOTE->value                          => FALSE,
				self::ENABLE_EXCEPTIONS->value              => FALSE,
				self::THROW_EXCEPTION_ON_NULL->value        => TRUE,
				self::THROW_EXCEPTION_ON_BAD_PATTERN->value => TRUE,
				self::THROW_EXCEPTION_ON_BAD_CONFIG->value  => TRUE,
				self::THROW_EXCEPTION_IF_EARLY->value       => TRUE,
				self::THROW_EXCEPTION_ON_BAD_SERVICE->value => TRUE,
				self::THROW_EXCEPTION_ON_NO_PATTERN->value  => TRUE,
			];
		}

		/**
		 * Parse a config key and generate a valid value
		 * for it.
		 *
		 * @param \OOPCRE\Foundation\Definition\Option $option A case from the Option enum.
		 * @param int|bool|array|string                $value  Value that should be validated and parsed.
		 *
		 * @return int|bool|array|string
		 * @throws \OOPCRE\Foundation\Exception\InvalidConfigException
		 */
		public static function parse( self $option, int|bool|array|string $value ): int|bool|array|string {
			// Parse or cast the value
			return match ( $option ) {
				self::DELIMITER => $option->parseDelimiter( $value ),
				default         => (bool) $value,
			};
		}

		/**
		 * Try to generate a proper delimiter.
		 *
		 * @param mixed $delimiter
		 *
		 * @return string
		 * @throws \OOPCRE\Foundation\Exception\InvalidConfigException
		 */
		private function parseDelimiter( mixed $delimiter ): string {
			$clean = substr(
				match ( gettype( $delimiter ) ) {
					'string' => str_replace( " \t\n\r\0\x0B", '', trim( $delimiter ) ),
					default  => '',
				},
				0,
				1
			);

			// A valid delimiter was not found.
			if ( ! str_contains( '!"#$%&\'*+,./:;=?@^_`|~-', $clean ) ) {
				throw new InvalidDelimiterException;
			}

			return $clean;
		}
	}