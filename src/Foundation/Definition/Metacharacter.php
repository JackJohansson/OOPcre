<?php

	namespace OOPCRE\Foundation\Definition;

	/**
	 * Different types of metacharacters used in the regex.
	 *
	 */
	enum Metacharacter: string {

		// Decimal digits
		case DIGIT = '\d';

		// Anything but a digit
		case NON_DIGIT = '\D';

		// Horizontal whitespace
		case H_WHITESPACE = '\h';

		// Anything but non-horizontal whitespace
		case NON_H_WHITESPACE = '\H';

		// Any character
		case ANY = '.';

		// Line Start
		case LINE_START = '^';

		// Line end
		case LINE_END = '$';

		// Any whitespace
		case WHITESPACE = '\s';

		// Anything but whitespace
		case NON_WHITESPACE = '\S';

		// Any vertical whitespace
		case V_WHITESPACE = '\v';

		// Anything but vertical whitespace
		case NON_V_WHITESPACE = '\V';

		// Any word character
		case WORD = '\w';

		// Any non-word character
		case NON_WORD = '\W';

		case WORD_BEGIN = '\b';

		case UNICODE = '\u';
	}