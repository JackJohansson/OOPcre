<?php

	namespace OOPCRE\Foundation\Definition;

	/**
	 * Enum to set the type of the quantifier for a pattern.
	 *
	 */
	enum Quantifier: string {
		case GREEDY = '';
		case RELUCTANT = '?';
		case POSSESSIVE = '+';
	}