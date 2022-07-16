<?php

	namespace OOPCRE\Foundation\Definition;

	/**
	 * Enum that represents unprintable ASCII characters.
	 * These characters have the ASCII code from 0 to 32,
	 * and the DELETE character at code 127.
	 */
	enum Unprintable: int {
		// Null character
		case NULL = 0;

		// Start of heading
		case SOH = 1;

		// Start or text
		case STX = 2;

		// Start or text
		case ETX = 3;

		// End of transmission
		case EOT = 4;

		// Enquiry
		case ENQ = 5;

		// Acknowledge
		case ACK = 6;

		// Bell
		case BEL = 7;

		// Backspace
		case BS = 8;

		// Horizontal tab
		case TAB = 9;

		// New line feed, new line
		case LF = 10;

		// Vertical tab
		case VT = 11;

		// New page from feed, new page
		case NP = 12;

		// Carriage return
		case CR = 13;

		// Shift out
		case SO = 14;

		// Shift in
		case SI = 15;

		// Data link escape
		case DLE = 16;

		// Device control 1
		case DC1 = 17;

		// Device control 2
		case DC2 = 18;

		// Device control 3
		case DC3 = 19;

		// Device control 4
		case DC4 = 20;

		// Negative acknowledge
		case NAK = 21;

		// Synchronous idle
		case SYN = 22;

		// End of transmission block
		case ETB = 23;

		// Cancel
		case CAN = 24;

		// End of medium
		case EM = 25;

		// Substitute
		case SUB = 26;

		// Escape
		case ESC = 27;

		// File separator
		case FS = 28;

		// Group separator
		case GS = 29;

		// Record separator
		case RS = 30;

		// Unit separator
		case US = 31;

		// Space
		case SPACE = 32;

		// Delete
		case DEL = 127;
	}