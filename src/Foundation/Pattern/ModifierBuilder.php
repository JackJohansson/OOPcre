<?php

	namespace OOPCRE\Foundation\Pattern;

	use OOPCRE\Foundation\Bag\TraversableBag;
	use OOPCRE\Foundation\Definition\Modifier;

	/**
	 * Class used to builder a modifier for a given pattern.
	 *
	 * @property Modifier[] $items
	 */
	class ModifierBuilder extends TraversableBag {

		/**
		 * Generate a key for the builder when a new builder is resolved.
		 */
		public function __construct( private \OOPCRE\Foundation\ServiceProvider $service ) {
			$this->key = $this->generateKey();
		}

		/**
		 * If this modifier is set, the pattern is forced to be "anchored", that
		 * is, it is constrained to match only at the start of the string which
		 * is being searched (the "subject string"). This effect can also be
		 * achieved by appropriate constructs in the pattern itself, which is
		 * the only way to do it in Perl.
		 *
		 * @return \OOPCRE\Foundation\Pattern\ModifierBuilder
		 */
		public function anchored(): static {
			return $this->add( Modifier::ANCHORED );
		}

		/**
		 * Add a new modifier to the bag.
		 *
		 * @param \OOPCRE\Foundation\Definition\Modifier $modifier
		 *
		 * @return \OOPCRE\Foundation\Pattern\ModifierBuilder
		 */
		private function add( Modifier $modifier ): static {
			// If not added already
			if ( ! isset( $this->items[ $modifier->name ] ) ) {
				$this->items[ $modifier->name ] = $modifier;
			}
			return $this;
		}

		/**
		 * Build the modifiers.
		 *
		 * @return string
		 */
		public function build(): string {
			// If there are items in this modifier builder
			if ( ! $this->isEmpty() ) {
				return implode( array_map( fn( $item ) => $item->value, $this->items ) );
			}

			// No items have been added, by maybe there are some global modifiers
			if ( ! $this->service->modifierBuilder->isEmpty() ) {
				return $this->service->modifierBuilder->build();
			}

			// Nothing.
			return '';
		}

		/**
		 * If this modifier is set, letters in the pattern
		 * match both upper and lower case letters.
		 *
		 * @return \OOPCRE\Foundation\Pattern\ModifierBuilder
		 */
		public function caseInsensitive(): static {
			return $this->add( Modifier::CASE_INSENSITIVE );
		}

		/**
		 * If this modifier is set, a dollar metacharacter in the pattern matches
		 * only at the end of the subject string. Without this modifier, a dollar
		 * also matches immediately before the final character if it is a newline
		 * (but not before any other newlines). This modifier is ignored if
		 * m modifier is set. There is no equivalent to this modifier in Perl.
		 *
		 * @return \OOPCRE\Foundation\Pattern\ModifierBuilder
		 */
		public function dollarEndOnly(): static {
			return $this->add( Modifier::DOLLAR_END_ONLY );
		}

		/**
		 * If this modifier is set, a dot metacharacter in the pattern
		 * matches all characters, including newlines. Without it, newlines
		 * are excluded. This modifier is equivalent to Perl's /s modifier.
		 * A negative class such as [^a] always matches a newline character,
		 * independent of the setting of this modifier.
		 *
		 * @return \OOPCRE\Foundation\Pattern\ModifierBuilder
		 */
		public function dotAll(): static {
			return $this->add( Modifier::DOT_ALL );
		}

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
		 *
		 * @return \OOPCRE\Foundation\Pattern\ModifierBuilder
		 */
		public function extended(): static {
			return $this->add( Modifier::EXTENDED );
		}

		/**
		 * This modifier turns on additional functionality of Operation that is
		 * incompatible with Perl. Any backslash in a pattern that is followed by
		 * a letter that has no special meaning causes an error, thus reserving
		 * these combinations for future expansion. By default, as in Perl, a
		 * backslash followed by a letter with no special meaning is treated as
		 * a literal. There are at present no other features controlled by this modifier.
		 *
		 * @return \OOPCRE\Foundation\Pattern\ModifierBuilder
		 */
		public function extra(): static {
			return $this->add( Modifier::EXTRA );
		}

		/**
		 * Get an specific item from bag.
		 *
		 * @param string $key
		 *
		 * @return \OOPCRE\Foundation\Definition\Modifier
		 * @throws \OOPCRE\Foundation\Exception\InvalidBagKeyException
		 */
		public function itemByKey( string $key ): Modifier {
			return parent::itemByKey( $key );
		}

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
		 *
		 * @return \OOPCRE\Foundation\Pattern\ModifierBuilder
		 */
		public function multiline(): static {
			return $this->add( Modifier::MULTILINE );
		}

		/**
		 * Remove a modifier from the bag.
		 *
		 * @param \OOPCRE\Foundation\Definition\Modifier $modifier
		 *
		 * @return \OOPCRE\Foundation\Pattern\ModifierBuilder
		 * @internal
		 */
		public function remove( Modifier $modifier ): static {
			// If exists, remove
			if ( isset( $this->items[ $modifier->name ] ) ) {
				unset( $this->items[ $modifier->name ] );
			}
			return $this;
		}

		/**
		 * When a pattern is going to be used several times, it is worth spending
		 * more time analyzing it in order to speed up the time taken for matching.
		 * If this modifier is set, then this extra analysis is performed. At present,
		 * studying a pattern is useful only for non-anchored patterns that do not
		 * have a single fixed starting character.
		 *
		 * @return \OOPCRE\Foundation\Pattern\ModifierBuilder
		 */
		public function study(): static {
			return $this->add( Modifier::STUDY );
		}

		/**
		 * This modifier inverts the "greediness" of the quantifiers so that
		 * they are not greedy by default, but become greedy if followed by ?.
		 * It is not compatible with Perl. It can also be set by a (?U) modifier
		 * setting within the pattern or by a question mark behind a quantifier (e.g. .*?).
		 *
		 * @link https://www.php.net/manual/en/regexp.reference.internal-options.php
		 * @return \OOPCRE\Foundation\Pattern\ModifierBuilder
		 */
		public function ungreedy(): static {
			return $this->add( Modifier::UNGREEDY );
		}

		/**
		 * This modifier turns on additional functionality of Operation that is incompatible
		 * with Perl. Pattern and subject strings are treated as UTF-8. An invalid
		 * subject will cause the preg_* function to match nothing; an invalid
		 * pattern will trigger an error of level E_WARNING. Five and six octet
		 * UTF-8 sequences are regarded as invalid.
		 *
		 * @return \OOPCRE\Foundation\Pattern\ModifierBuilder
		 */
		public function unicode(): static {
			return $this->add( Modifier::UNICODE );
		}
	}