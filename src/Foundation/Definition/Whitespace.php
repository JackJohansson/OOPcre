<?php

	namespace OOPCRE\Foundation\Definition;

	/**
	 * Enum that represents different types of whitespaces.
	 *
	 */
	enum Whitespace: string {
		// Any type of whitespace.
		case ANY = '';

		// Single space.
		case SPACE = ' ';

		// Tab character
		case TAB = '\t';

		// Any vertical whitespace.
		case ANY_VERTICAL = '\v';

		// Any horizontal whitespace.
		case ANY_HORIZONTAL = '\h';

		// New line
		case NEWLINE = '\n';

		// Carriage return
		case CARRIAGE_RETURN = '\cr';

		// Line feed
		case LINE_FEED = '\lf';

		case NULL = '\0';
	}