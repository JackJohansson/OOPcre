<?php

	namespace OOPCRE\Foundation\Definition;

	/**
	 * Holds a list of pre-defined posix patterns.
	 *
	 * @internal
	 */
	enum PosixPattern: string {
		// Match a character in the ASCII character set.
		case ASCII = '[:ascii:]';

		// Match alphabetic characters.
		case ALPHA = '[:alpha:]';

		// Match alphabetic and numeric characters.
		case ALPHA_NUM = '[:alnum:]';

		// Match space or tab characters.
		case BLANK = '[:blank:]';

		// Match the control characters.
		case CONTROL = '[:cntrl:]';

		// Match any digit.
		case DIGIT = '[:digit:]';

		// Match Non-blank character (excludes spaces, control characters, and similar)
		case GRAPH = '[:graph:]';

		// Match lowercase alphabetical character.
		case LOWERCASE = '[:lower:]';

		// Works like [:graph:], but includes the space character.
		case PRINT = '[:print:]';

		// Match punctuation character.
		case PUNCTUATION = '[:punct:]';

		// Match whitespace character ([:blank:], newline,
		// carriage return, etc.)
		case SPACE = '[:space:]';

		// Match uppercase alphabetical characters.
		case UPPERCASE = '[:upper:]';

		// Match a character in one of the following Unicode general
		// categories Letter, Mark, Number, Connector_Punctuation.
		case WORD = '[:word:]';

		// Match digit in a hexadecimal number (i.e., 0-9a-fA-F).
		case HEX_DIGIT = '[:xdigit:]';
	}