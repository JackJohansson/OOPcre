<?php

	namespace OOPCRE\Foundation\Definition;

	/**
	 * A list of regex modifiers and their values. Used internally.
	 *
	 * @link https://www.php.net/manual/en/reference.pcre.pattern.modifiers.php
	 * @internal
	 */
	enum Modifier: string {
		/**
		 * If this modifier is set, letters in the pattern
		 * match both upper and lower case letters.
		 */
		case CASE_INSENSITIVE = 'i';

		/**
		 * By default, Operation treats the subject string as consisting
		 * of a single "line" of characters (even if it actually contains
		 * several newlines). The "start of line" metacharacter (^) matches
		 * only at the start of the string, while the "end of line"
		 * metacharacter ($) matches only at the end of the string, or
		 * before a terminating newline (unless D modifier is set). This
		 * is the same as Perl. When this modifier is set, the "start of
		 * line" and "end of line" constructs match immediately following or
		 * immediately before any newline in the subject string, respectively,
		 * as well as at the very start and end. This is equivalent to Perl's
		 * /m modifier. If there are no "\n" characters in a subject string,
		 * or no occurrences of ^ or $ in a pattern, setting this modifier has no effect.
		 */
		case MULTILINE = 'm';

		/**
		 * If this modifier is set, a dot metacharacter in the pattern
		 * matches all characters, including newlines. Without it, newlines
		 * are excluded. This modifier is equivalent to Perl's /s modifier.
		 * A negative class such as [^a] always matches a newline character,
		 * independent of the setting of this modifier.
		 */
		case DOT_ALL = 's';

		/**
		 * If this modifier is set, whitespace data characters in the pattern
		 * are totally ignored except when escaped or inside a character
		 * class, and characters between an unescaped # outside a character
		 * class and the next newline character, inclusive, are also ignored.
		 * This is equivalent to Perl's /x modifier, and makes it possible to
		 * include commentary inside complicated patterns. Note, however, that
		 * this applies only to data characters. Whitespace characters may never
		 * appear within special character sequences in a pattern, for example
		 * within the sequence (?( which introduces a conditional subpattern.
		 */
		case EXTENDED = 'x';

		/**
		 * If this modifier is set, the pattern is forced to be "anchored", that
		 * is, it is constrained to match only at the start of the string which
		 * is being searched (the "subject string"). This effect can also be
		 * achieved by appropriate constructs in the pattern itself, which is
		 * the only way to do it in Perl.
		 */
		case ANCHORED = 'A';

		/**
		 * If this modifier is set, a dollar metacharacter in the pattern matches
		 * only at the end of the subject string. Without this modifier, a dollar
		 * also matches immediately before the final character if it is a newline
		 * (but not before any other newlines). This modifier is ignored if
		 * m modifier is set. There is no equivalent to this modifier in Perl.
		 */
		case DOLLAR_END_ONLY = 'D';

		/**
		 * When a pattern is going to be used several times, it is worth spending
		 * more time analyzing it in order to speed up the time taken for matching.
		 * If this modifier is set, then this extra analysis is performed. At present,
		 * studying a pattern is useful only for non-anchored patterns that do not
		 * have a single fixed starting character.
		 */
		case STUDY = 'S';

		/**
		 * This modifier inverts the "greediness" of the quantifiers so that
		 * they are not greedy by default, but become greedy if followed by ?.
		 * It is not compatible with Perl. It can also be set by a (?U) modifier
		 * setting within the pattern or by a question mark behind a quantifier (e.g. .*?).
		 *
		 * @link https://www.php.net/manual/en/regexp.reference.internal-options.php
		 */
		case UNGREEDY = 'U';

		/**
		 * This modifier turns on additional functionality of Operation that is
		 * incompatible with Perl. Any backslash in a pattern that is followed by
		 * a letter that has no special meaning causes an error, thus reserving
		 * these combinations for future expansion. By default, as in Perl, a
		 * backslash followed by a letter with no special meaning is treated as
		 * a literal. There are at present no other features controlled by this modifier.
		 */
		case EXTRA = 'X';

		/**
		 * This modifier turns on additional functionality of Operation that is incompatible
		 * with Perl. Pattern and subject strings are treated as UTF-8. An invalid
		 * subject will cause the preg_* function to match nothing; an invalid
		 * pattern will trigger an error of level E_WARNING. Five and six octet
		 * UTF-8 sequences are regarded as invalid.
		 */
		case UNICODE = 'u';
	}