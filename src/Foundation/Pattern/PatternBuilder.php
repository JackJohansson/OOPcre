<?php

	namespace OOPCRE\Foundation\Pattern;

	use OOPCRE\Foundation\Bag\TraversableBag;
	use OOPCRE\Foundation\Definition\Option;
	use OOPCRE\Foundation\Definition\Whitespace;
	use OOPCRE\Foundation\Exception\RegexException;
	use OOPCRE\Foundation\ServiceProvider;
	use OOPCRE\Support\RegistersPosixPattern;

	/**
	 * The pattern builder class used to register patterns.
	 *
	 */
	class PatternBuilder extends TraversableBag {
		use RegistersPosixPattern;

		/**
		 * Holds an instance of the builder for the modifiers.
		 *
		 * @var \OOPCRE\Foundation\Pattern\ModifierBuilder $modifierBuilder
		 */
		protected ModifierBuilder $modifierBuilder;

		/**
		 * Set up the service container.
		 *
		 * @param \OOPCRE\Foundation\ServiceProvider $service      The service provider instance.
		 * @param bool                               $isSubPattern Whether this bag is a sub-pattern or not.
		 *
		 * @throws \OOPCRE\Foundation\Exception\InvalidServiceClassException
		 */
		public function __construct( private readonly ServiceProvider $service, private bool $isSubPattern = FALSE ) {
			$this->modifierBuilder = $service->resolve( ModifierBuilder::class, TRUE );
		}

		/**
		 * Match any character.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function addAnything(): Pattern {
			return $this->_add( \OOPCRE\Foundation\Pattern\Syntax\Character::class, '.' );
		}

		/**
		 * Internal method to register a new pattern.
		 *
		 * @param string $class
		 * @param        ...$args
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 * @throws \OOPCRE\Foundation\Exception\RegexException
		 * @internal
		 */
		private function _add( string $class, ...$args ): Pattern {
			try {
				// Try to call the create method on the target class and pass the arguments
				$pattern = call_user_func( [ $class, 'create' ], ...$args );

				$this->items[ $this->generateKey() ] = $pattern;
				return $pattern;
			} catch ( RegexException $exception ) {
				$this->service->errorBag->handle( $exception );
			}

			// We shouldn't reach here unless exceptions are disabled, and there's been an error.
			// We will return a dummy pattern just to keep the program functional.
			return \OOPCRE\Foundation\Pattern\Syntax\Placeholder::create( '' );
		}

		/**
		 * Add a character to the pattern.
		 *
		 * @param string $char A single character to be added as a pattern. Any additional
		 *                     characters will be removed.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function addCharacter( string $char ): Pattern {
			return $this->_add( \OOPCRE\Foundation\Pattern\Syntax\Character::class, $char );
		}

		/**
		 * Add a character class match.
		 *
		 * @param string $characters One or multiple characters to be used as a character class.
		 * @param bool   $not        Whether to reverse this pattern, and search for characters that DO NOT
		 *                           exist among these characters.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function addCharacterClass( string $characters, bool $not = FALSE ): Pattern {
			return $this->_add( \OOPCRE\Foundation\Pattern\Syntax\CharacterClass::class, $characters, $not );
		}

		/**
		 * Add a pattern to match a floating point number.
		 *
		 * @param float $float     A float or a double number.
		 * @param int   $precision The precision for the floating points. Defaults to 2.
		 * @param bool  $unsigned  Whether to convert this number to absolute value. Defaults to true.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function addFloat( float $float, int $precision = 2, bool $unsigned = TRUE ): Pattern {
			return $this->_add( \OOPCRE\Foundation\Pattern\Syntax\FloatNumber::class, $float, $precision, $unsigned );
		}

		/**
		 * Add a pattern to match an integer number.
		 *
		 * @param int  $int      An integer to be added to the pattern.
		 * @param bool $unsigned Whether to convert this number to absolute value. Defaults to true.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function addInteger( int $int, bool $unsigned = TRUE ): Pattern {
			return $this->_add( \OOPCRE\Foundation\Pattern\Syntax\IntNumber::class, $int, $unsigned );
		}

		/**
		 * Add a pre-defined metacharacter pattern to the bag.
		 *
		 * @param \OOPCRE\Foundation\Definition\Metacharacter $metacharacter An instance of a pre-defined metacharacter
		 *                                                                   enum class.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function addMetaChar( \OOPCRE\Foundation\Definition\Metacharacter $metacharacter ): Pattern {
			return $this->_add( \OOPCRE\Foundation\Pattern\Syntax\Special::class, $metacharacter );
		}

		/**
		 * Add a bitwise OR to the regex.
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 */
		public function addOr(): static {
			return $this->_addSimple( \OOPCRE\Foundation\Pattern\Syntax\Text::class, '|' );
		}

		/**
		 * Add a new pattern to the bag. Returns an instance of the
		 * added pattern, which can be further customized.
		 *
		 * @param \OOPCRE\Foundation\Pattern\Pattern $pattern
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		protected function addPattern( Pattern $pattern ): Pattern {
			$this->items[ $this->generateKey() ] = $pattern;
			return $pattern;
		}

		/**
		 * Add a character range match pattern.
		 *
		 * @param array $range  An associative array of characters, passed as [ 'a' => 'd', 'r' => 'x' ]. This will
		 *                      be compiled into [a-dr-x]. if a range of numbers is provided, they will be parsed
		 *                      and added as strings, if the range makes sense.
		 * @param bool  $not    Whether to reverse this pattern, and search for characters that DO NOT
		 *                      exist among these ranges.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function addRange( array $range, bool $not = FALSE ): Pattern {
			return $this->_add( \OOPCRE\Foundation\Pattern\Syntax\Range::class, $range, $not );
		}

		/**
		 * Add a pattern to a group of texts.
		 *
		 * @param string[] $strings An array of items with strings as values. If the values are not
		 *                          strings, the application will try to convert them into string.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function addTextGroup( array $strings ): Pattern {
			return $this->_add( \OOPCRE\Foundation\Pattern\Syntax\TextGroup::class, $strings );
		}

		/**
		 * Match a unicode character.
		 *
		 * @param string $code The hexadecimal code for the unicode character to be matched against.
		 *                     Should only include 0-9, A-F and a-f.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function addUnicode( string $code ): Pattern {
			return $this->_add( \OOPCRE\Foundation\Pattern\Syntax\Unicode::class, $code );
		}

		/**
		 *  Match an unprintable character.
		 *
		 * @param \OOPCRE\Foundation\Definition\Unprintable $unprintable A case of the unprintable enum class.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function addUnprintable( \OOPCRE\Foundation\Definition\Unprintable $unprintable ): Pattern {
			return $this->_add( \OOPCRE\Foundation\Pattern\Syntax\Unicode::class, $unprintable->value );
		}

		/**
		 * Add a pattern to match a whitespace character.
		 *
		 * @param \OOPCRE\Foundation\Definition\Whitespace $whitespace A case of the whitespace enum class. If none
		 *                                                             is provided, defaults to a single empty space.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function addWhitespace( Whitespace $whitespace = Whitespace::SPACE ): Pattern {
			return $this->_add( \OOPCRE\Foundation\Pattern\Syntax\Space::class, $whitespace );
		}

		/**
		 * Return the raw regex pattern.
		 *
		 * @return string
		 * @throws \OOPCRE\Foundation\Exception\EmptyPatternBuilderException
		 */
		public function getPatternString(): string {
			return $this->build();
		}

		/**
		 * Build the current bag and return a pattern string.
		 *
		 * @param string $key
		 *
		 * @return string
		 * @throws \OOPCRE\Foundation\Exception\EmptyPatternBuilderException
		 */
		public function build( string $key = '' ): string {
			// If no pattern has been applied
			if ( $this->isEmpty() ) {
				throw new \OOPCRE\Foundation\Exception\EmptyPatternBuilderException;
			}

			// Start building the pattern
			$pattern = '';
			$build   = '';

			// Traverse through all the patterns and build them.
			foreach ( $this->items as $patternKey => $item ) {
				$build .= $item->build( $patternKey );
			}

			if ( $this->isSubPattern ) {
				$pattern .= "(?P<{$key}>{$build})";
			} else {
				$pattern .= $build;
			}

			// If this is not a sub-pattern, add delimiter and other required parameters.
			if ( ! $this->isSubPattern ) {

				// Resolve the delimiter
				$delimiter = Option::parse(
					Option::DELIMITER,
					$this->service->config->get( Option::DELIMITER )
				);

				// Wrap in delimiter
				$pattern = "{$delimiter}{$pattern}{$delimiter}";

				// Add modifiers
				$pattern .= $this->modifierBuilder->build();

				// Quote the pattern
				if ( $this->service->config->get( Option::QUOTE ) ) {
					$pattern = preg_quote( $pattern, $delimiter );
				}
			}
			return $pattern;
		}

		/**
		 * Accept a closure and store its result in the bag as
		 * as a pattern.
		 *
		 * @param \Closure $closure Closure to be executed. This closure will receive a
		 *                          new instance of the PatternBuilderBag class.
		 * @param string   $name    Optional. A name for this group.
		 *
		 * @return $this
		 */
		public function group( \Closure $closure, string $name = '' ): static {
			// Execute the closure and create a sub-bag
			$group = new static( $this->service, TRUE );

			$closure( $group );

			if ( ! $group->isEmpty() ) {
				$this->items[ $this->generateKey( $name ) ] = $group;
			}

			return $this;
		}

		/**
		 * Whether this bag is a sub-pattern or not.
		 *
		 * @return bool
		 */
		public function isGroup(): bool {
			return $this->isSubPattern;
		}

		/**
		 * Get the modifier builder for this pattern builder.
		 *
		 * @return \OOPCRE\Foundation\Pattern\ModifierBuilder
		 */
		public function modifiers(): ModifierBuilder {
			return $this->modifierBuilder;
		}

		/**
		 * Add a raw regex pattern to the bag.
		 *
		 * @param string $pattern Add a raw pattern to the list of patterns. Delimiters or modifiers
		 *                        should NOT be provided.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function raw( string $pattern ): Pattern {
			return $this->addText( $pattern );
		}

		/**
		 * Add a pattern to match a textual string.
		 *
		 * @param string $text Add a custom text to be matched against.
		 *
		 * @return \OOPCRE\Foundation\Pattern\Pattern
		 */
		public function addText( string $text ): Pattern {
			return $this->_add( \OOPCRE\Foundation\Pattern\Syntax\Text::class, $text );
		}

		/**
		 * Add a pattern to match a single character.
		 *
		 * @param string $char A single character to be added as a pattern. Any additional
		 *                     characters will be removed.
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 */
		public function simpleCharacter( string $char ): static {
			return $this->_addSimple( \OOPCRE\Foundation\Pattern\Syntax\Character::class, $char );
		}

		/**
		 * Add a simple pattern to the bag.
		 *
		 * @param string $class
		 * @param mixed  ...$args
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 * @throws \OOPCRE\Foundation\Exception\RegexException
		 */
		private function _addSimple( string $class, ...$args ): static {
			$this->_add( $class, ...$args );
			return $this;
		}

		/**
		 * Add a character class match.
		 *
		 * @param string $characters One or multiple characters to be used as a character class.
		 * @param bool   $not        Whether to reverse this pattern, and search for characters that DO NOT
		 *                           exist among these characters.
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 */
		public function simpleCharacterClass( string $characters, bool $not ): static {
			return $this->_addSimple( \OOPCRE\Foundation\Pattern\Syntax\CharacterClass::class, $characters, $not );
		}

		/**
		 * Add a pattern to match a floating point number.
		 *
		 * @param float $float     A float or a double number.
		 * @param int   $precision The precision for the floating points. Defaults to 2.
		 * @param bool  $unsigned  Whether to convert this number to absolute value. Defaults to true.
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 */
		public function simpleFloat( float $float, int $precision = 2, bool $unsigned = TRUE ): static {
			return $this->_addSimple( \OOPCRE\Foundation\Pattern\Syntax\FloatNumber::class, $float, $precision, $unsigned );
		}

		/**
		 * Add a pattern to match an integer number.
		 *
		 * @param int  $int      An integer to be added to the pattern.
		 * @param bool $unsigned Whether to convert this number to absolute value. Defaults to true.
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 */
		public function simpleInteger( int $int, bool $unsigned = TRUE ): static {
			return $this->_addSimple( \OOPCRE\Foundation\Pattern\Syntax\IntNumber::class, $int, $unsigned );
		}

		/**
		 * Add a pre-defined metacharacter pattern to the bag.
		 *
		 * @param \OOPCRE\Foundation\Definition\Metacharacter $metacharacter An instance of a pre-defined metacharacter
		 *                                                                   enum class.
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 */
		public function simpleMetaChar( \OOPCRE\Foundation\Definition\Metacharacter $metacharacter ): static {
			return $this->_addSimple( \OOPCRE\Foundation\Pattern\Syntax\Special::class, $metacharacter );
		}

		/**
		 * Add a character range match pattern.
		 *
		 * @param array $range  An associative array of characters, passed as [ 'a' => 'd', 'r' => 'x' ]. This will
		 *                      be compiled into [a-dr-x]. if a range of numbers is provided, they will be parsed
		 *                      and added as strings, if the range makes sense.
		 * @param bool  $not    Whether to reverse this pattern, and search for characters that DO NOT
		 *                      exist among these ranges.
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 */
		public function simpleRange( array $range, bool $not = FALSE ): static {
			return $this->_addSimple( \OOPCRE\Foundation\Pattern\Syntax\Range::class, $range, $not );
		}

		/**
		 * Add a pattern to match a textual string.
		 *
		 * @param string $text Add a custom text to be matched against.
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 */
		public function simpleText( string $text ): static {
			return $this->_addSimple( \OOPCRE\Foundation\Pattern\Syntax\Text::class, $text );
		}

		/**
		 * Add a pattern to a group of texts.
		 *
		 * @param string[] $strings An array of items with strings as values. If the values are not
		 *                          strings, the application will try to convert them into string.
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 */
		public function simpleTextGroup( array $strings ): static {
			return $this->_addSimple( \OOPCRE\Foundation\Pattern\Syntax\TextGroup::class, $strings );
		}

		/**
		 * Match a unicode character.
		 *
		 * @param string $code The hexadecimal code for the unicode character to be matched against.
		 *                     Should only include 0-9, A-F and a-f.
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 */
		public function simpleUnicode( string $code ): static {
			return $this->_addSimple( \OOPCRE\Foundation\Pattern\Syntax\Unicode::class, $code );
		}

		/**
		 * Match an unprintable character.
		 *
		 * @param \OOPCRE\Foundation\Definition\Unprintable $unprintable A case of the unprintable enum class.
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 */
		public function simpleUnprintable( \OOPCRE\Foundation\Definition\Unprintable $unprintable ): static {
			return $this->_addSimple( \OOPCRE\Foundation\Pattern\Syntax\Unicode::class, $unprintable->value );
		}

		/**
		 * Add a pattern to match a whitespace character.
		 *
		 * @param \OOPCRE\Foundation\Definition\Whitespace $whitespace A case of the whitespace enum class. If none
		 *                                                             is provided, defaults to a single empty space.
		 *
		 * @return \OOPCRE\Foundation\Pattern\PatternBuilder
		 */
		public function simpleWhitespace( Whitespace $whitespace = Whitespace::SPACE ): static {
			return $this->_addSimple( \OOPCRE\Foundation\Pattern\Syntax\Space::class, $whitespace );
		}
	}