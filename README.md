# OOPCRE: Object-Oriented Regex for PHP

***

#### Table of Content

1) What is OOPCRE, and why should I care?
2) Installation & Requirements
3) Structure & Usage
   1) Starting a regex operation
   2) The `Preg*` class set
4) Basic Example
5) Advanced Usage
6) Digging deeper into structure
   1) Regex class
   2) Configurator class
   3) Error handler class
   4) Pattern class
   5) Quantifier builder class
   6) Pattern builder class
   7) Modifier builder class
   8) Grouping & naming patterns
   9) Registering arrays of patterns
   10) Pre-defined items
7) Helper traits
***

### 1)  What is OOPCRE, and why should I care?

**OOPCRE** ( pronounce `o-o-pi-si-ar-E`, or my favorite, `oopsie! R-E` ) is a package that provides an object-oriented approach to
regex operations. Why would you need it? Actually, you don't. But like many of the packages that are used to make
development easier, you can use OOPCRE to achieve the same. It will be a great fit if:

1) You are not a regex guru, and no time to become one
2) You want a quick way to convert a human-readable piece of code into a regex pattern
3) You want to use dozens of helper methods provided by **OOPCRE**
4) You want to use regex features that you probably didn't even know existed

No matter you are using a simple operation to detect image tags inside an HTML string, or trying to run complex regex
operations, **OOPCRE** is there to assist you. It's very light-weighted as it has no dependency, and won't cause
overheads as it runs the `preg_*` functions only once.

### 2) Installation & Requirements

To install the package, simply run the following composer command:

```
composer require jackjohansson/oopcre
```

You can also download the package and extract the zip file, and then run the following command, since this package has
no dependency:

```
composer dump-autoload
```

**OOPCRE** does not have a special requirement except the PHP version. It depends on the new features released by the
PHP version 8.1, such as enums and readonly properties, so it needs at least PHP 8.1.0 to run. The helper traits includes in section 7 have no requirements.

### 3) Structure & Usage
Below we will explain how to start using any regex operations, mention a list of all provided methods, and explain them a bit.

#### 3.1) Starting a regex operation
To start doing any operation using **OOPCRE**, a new instance of the `\OOPCRE\Regex` class needs to be created. This
class requires the regex subject to be passed to its constructor:

```php
/**
 * Initialize the regex operation on a given subject.
 * A subject can be any of these types:
 * 
 * 1) String
 * 2) String[] ( An array with strings/stringables as values )
 * 5) Integer
 * 6) Float
 * 7) Objects that have a _toString() method
 *
 * Passing a null value will short-circuit the operation
 * and throw an exception, or return false.
 *
 */
$regex = new \OOPCRE\Regex( $subject );
```
Before starting to perform any operations, we can set the configuration. We can set these configs any time before execution, but it's better to keep them on top to avoid confusion. To set a config, you can call the `setConfig()` method on the newly created `\OOPCRE\Regex` class. This method accepts an instance of the `\OOPCRE\Foundation\Definition\Option` enum as its first argument, and a value as its second argument. For example, to set the delimiter, run:

```php
$regex->setConfig( \OOPCRE\Foundation\Definition\Option::DELIMITER, '/' );
```
The most common use of this would be to enable exceptions on errors, which causes the program to throw an instance of the `\OOPCRE\Foundation\Exception\RegexException` if a critical error has occurred:

```php
$regex->setConfig( \OOPCRE\Foundation\Definition\Option::ENABLE_EXCEPTIONS, TRUE );
```

#### 3.2) The `Preg*` class set
Now that we have instantiated our subject, we can use one of the `Preg*` classes to start performing regex operations. You can access these classes by calling one of these methods on your regex subject:

```php
1) $regex->match();
```
Returns an instance of the `\OOPCRE\Foundation\PCRE\PregMatch` class and is similar to `preg_match()`. This class allows you to quickly match a single string against a single pattern and check if it matches.

```php
2) $regex->matchAll();
```
Returns an instance of the `\OOPCRE\Foundation\PCRE\PregMatchAll` class and works similar to `preg_match_all()` function, and `->match()` method. The difference is that it also supports capturing groups, counting results, and not stopping on first match.

```php
3) $regex->replace();
```

Returns an instance of the `\OOPCRE\Foundation\PCRE\PregReplace` class and is similar to the `preg_replace()` function. This class allows you to replace a single pattern with a given string, which is by default set to an empty string. You can set the replacement string by calling the `->replacement()` method on this class.

```php
4) $regex->replaceMulti();
```

Returns an instance of the `\OOPCRE\Foundation\PCRE\PregReplaceMultiple` class and allows you to replace multiple patterns with multiple strings on multiple subjects. The subject can be a string or an array with stringifyable values ( such as objects with `_toString()` method ). Explanation on how to register multiple patterns is explained on 6.9.

```php
5) $regex->filter();
```
Returns an instance of the `\OOPCRE\Foundation\PCRE\PregFilter` class and behaves similar to `preg_filter()` which itself behaves like `preg_replace()`. You can use this method to replace and filter an array of subjects who match against a single pattern.

```php
6) $regex->filterMulti();
```
Returns an instance of the `\OOPCRE\Foundation\PCRE\PregFilterMultiple` class and behaves similarly to the previous method, except it allows registering multiple patterns.

```php
7) $regex->grep();
```

Returns an instance of the `\OOPCRE\Foundation\PCRE\PregGrep` class, and is similar to `preg_grep()` function. It will filter and return items from an array subject that match ( or don't match, if enabled ) against a given pattern.

```php
8) $regex->split();
```

Returns an instance of the `\OOPCRE\Foundation\PCRE\PregSplit` class and is similar to `preg_split()`. It allows you to split a given subject into an array of strings based on a given pattern. Consider using php's `explode()` function instead, if your pattern is very basic. 

Each of these classes implement the `\OOPCRE\Foundation\Skeleton\PcreSkeleton` interface and extend the `\OOPCRE\Foundation\PCRE\PregBase` abstract class. The code is well-documented, so any proper IDE will provide full auto-completion. Now let's try to do a basic regex to find some text.

### 4) Basic Example
We will try to see if the subject contains alphanumeric text, using the `match()` method and with the help of the `\OOPCRE\Foundation\Pattern\PatternBuilder` class. This class provides an easy and convenient way to build the regex without knowing anything about regex patterns.

We start building the pattern by calling the `patterns()` method:

```php
$patternBuilder = $match->patterns();
$patternBuilder->simpleRange( [ 'a' => 'f', '0' => '9' ] );
```

The above code will be compiled into `[a-zA-Z0-9]`. You can manually build and check the full pattern by calling the `getPatternString()` on the `PatternBuilder` instance, which will return the pattern string.
After you are done with building your pattern, you can call the `execute()` method on the `match()` method ( which returned an instance of `\OOPCRE\Foundation\PCRE\PregMatch` class ) to execute the operation and get the result. This method returns a boolean which will tell you whether anything was matched, replaced or filtered:

```php
if( $match->success() ) {
    // String matched! Do some stuff.
}
```

Other operations such as `matchAll()` or `filter()` provide extra methods such as `count()` or `results()` depending on the situation. For example, calling the `count()` method on the `\OOPCRE\Foundation\PCRE\PregMatchAll` ( which is returned by `matchAll()` method ) will return the number of matches.

### 5) Advanced Usage
Now that we had some fun matching basic strings, let's try a real example. We will try to match an image tag inside an HTML code. Let's set some modifiers first. We'll tell the program not to stop on new lines, and ignore case:
```php
$match->modifiers()->caseInsensitive()->multiline();
```
The `modifiers()` method returns an instance of the `\OOPCRE\Foundation\Pattern\ModifierBuilder` class, which behaves similarly to the `PatternBuilder` class. This means you can chain the modifiers as many times as you need. Now let's build the pattern.

This time, we will call the `add*()` methods. These methods return an instance of the `\OOPCRE\Foundation\Pattern\Pattern` class and allow more flexibility and configurations:

```php
$patterns = $match->patterns();
// Match an opening `<img` tag.
$patterns->addText( '<img' );
// Match anything except the `>` character, and keep matching as much as possible.
$patterns->addCharacterClass( '>', TRUE )->unlimited();
// Match a closing `>` HTML tag.
$patterns->addCharacter( '>' );
```

By calling `$patterns->getPatternString()`, you will notice that the compiled pattern will be the following, which is a basic pattern for matching any image:

```phpregexp
~<img[^>]*>~im
```

Now we can run the `execute()` method as we did previously and check the result.

Please note that the default delimiter is set to `~` by the application, but it can be changed. Also, by default, the application will not try to escape the pattern, but this can also be enabled.

### 6) Digging deeper into structure
Let's take a deeper look into the application's structure and break it down to smaller parts to know exactly what's going on. We'll start by looking at the smallest and most important part of the application, the `\OOPCRE\Regex` class.

##### 6.1) Regex Class
As mentioned earlier, to start any regex operation, we need to instantiate the `\OOPCRE\Regex` class and pass our subject to it. This class provided the following methods:

```php
// Configurations
->configs();
->setConfig( $name, $value );
->getConfig( $name );

// Modifier override
->globalModifiers();

// Error handling
->errors();
->errorBag();
->lastErrorMessage();
->lastError();

// Regex operations
->match();
->matchAll();
->replace();
->replaceMulti();
->filter();
->filterMulti();
->grep();
->split();
```

#### 6.2) Configurator Class
We'll start by taking a look at the configurator. Calling the first 2 configuration methods will return an instance of the `\OOPCRE\Foundation\Configurator` class, which also supports chaining methods on the `setConfig()` method. The `setConfig()` and `getConfig()` methods both accepts an instance of the `\OOPCRE\Foundation\Definition\Option` enum as their first argument, which is the desired option that we want to work with. The `setConfig()` method also accepts a second argument, which is the value of the given option to be set. To view a list of all possible options and their default values, take a look at the `Option` enum.

#### 6.3) Error handler class
By default, exceptions are disabled by the application. This means that errors will silently be ignored and the application will not halt after encountering a fatal error. However, this means that the results are not reliable. If the exceptions are not enabled, all the errors will be logged into a bag, handled by the `\OOPCRE\Foundation\Bag\ErrorBag` class. This class implements the `\OOPCRE\Foundation\Bag\TraversableBag` interface, which means you can iterate over it like an array. To get the instance of this class, call the `errorBag()` method on the `Regex` class. The other methods function as described below:
+ `errorBag()` returns the only instance of the `ErrorBag` class.
+ `errors()` method will call the `items()` method on the `ErrorBag` class, which returns an array of occurred and logged errors.
+ `lastError()` will return the last exception that has been silently logged. It returns `null` if no exceptions have been thrown.
+ `lastErrorMessage()` method will try to return the textual message of the last error occurred. It returns an empty string if no error has been logged.

#### 6.4) Pattern class
Each pattern that is registered in any way, will be stored as an instance of the base abstract `\OOPCRE\Foundation\Pattern\Pattern` class, which is extended internally by other specific types of pattern. You can think of this class as the smallest building blocks of the pattern. For example, a single character, or a number, or a range of characters.

Each specific pattern contains a static `create()` method, which accepts an input. The input can vary based on each pattern, so it's not type-hinted. However, it will be validated and if it doesn't match the bare-minimum of the requirements, an exception will be raised or logged.

The `create()` method should not be directly used, and it should be used internally by the `PatternBuilder` class, which we will discuss later. 

#### 6.5) Quantifier builder class
The `Pattern` class uses the `\OOPCRE\Foundation\Contract\ManagesQuantifier` trait, which allows multiple quantifiers to be applied to a pattern:

```php
->atLeast( $min );
->asMost( $max );
->between( $min, $max );
->exactly( $count );
->unlimited();

->greedy();
->possessive();
->reluctant();
```

The above trait manages the `\OOPCRE\Foundation\Pattern\QuantifierBuilder` class, which means you don't need to directly interact with the builder. You can instead use the above methods to build your desired quantifier. As usual, you can chain all of these methods as many times as needed. Here's a brief explanation of what each method does:

+ `->atleast( $n )` method accepts an integer as input, and will try to match the given pattern as least `$n` times. Similar to `{n,}`.
+ `->atMost( $n )` method accepts an integer as input, and will try to match the given pattern no more than `$n` times. If you pass 0 or -1 to it, it will match as many times as possible. If you give a number less than `atLeast()`, it will be set to `atLeast()`. Similar to `{x,y}`. Defaults to 0.
+ `->between( $x, $y )` is a shorthand method for calling both `->atleast()` and `->atMost()` at the same time. Same rules about the above methods applies to this method too. Similar to `{x,y}`.
+ `->exactly( $n )` method will try to match the pattern **exactly** `$n` number of times. It's a shorthand for calling `->between( $n, $n )`. Similar to `{n}`.
+ `->greed()` method will set to quantifier to greedy ( Advanced ).
+ `->possessive()` method will set the quantifier to possessive ( Advanced ).
+ `->reluctant()` method will set the quantifier to reluctant ( Advanced ).

To learn more about the last 3 methods, take a look at [this question](https://stackoverflow.com/q/5319840) on StackOverflow.

#### 6.6) Pattern builder class
We talked about the `Pattern` class above, and how it works. But how do we add these patterns, if we're not supposed to instantiate the `Pattern` class directly? Here's where the `\OOPCRE\Foundation\Pattern\PatternBuilder` class comes in handy. This class offers 3 extensive sets of helper methods that can register even the most complex patterns. These 3 sets of methods are prefixed as below:

#### 6.6.1) The `->add*()` method set
These methods are prefixed with the `add` keyword, and will return an instance of the `Pattern` class. This allows us to furthermore customize the pattern, such as setting quantifiers. The full set of  `add*()` methods is as described below:

```php
1) ->addAnything()
``` 
This method will match any character.

```php
2) ->addCharacter( string $char )
```
This method will add a single character to the pattern.

```php
3) ->addCharacterClass( string $characters, bool $not )
```
This method will add a character class match.

```php
4) ->addFloat( float $float, int $precision, bool $unsigned )
```
Will add a pattern to match a floating point number.  Passing true to second argument will add the absolute value of the float number.

```php
5) ->addInteger( int $int, bool $unsigned )
```
Will add a pattern to match an integer number. Passing true to second argument will add the absolute value of the integer.

```php
6) ->addMetaChar( Metacharacter $metacharacter )
```
Accepts an instance of the `\OOPCRE\Foundation\Definition\Metacharacter` enum, and will add a pattern to match a pre-defined metacharacter. You can take a look at the `Metacharacter` enum for the complete list of available options.

```php
7) ->addRange( array $range, bool $not )
```
Will add a character range match pattern. For example, from `h` to `t` ( passed as `[ 'h' => 't' ]` ) or from `3` to `8` ( passed as `[ 3 => 8 ]` ). Passing true to the second argument will reverse the match. Some validations will be performed to make sure the range makes sense.

```php
8) ->addText( string $text )
```
will add a pattern to match a textual string, such as a word.

```php
9) ->addUnicode( string $code )
``` 
Will match a unicode character. You should only pass the unicode without the `\u` prefix. For example, `3a2d1F`.
```php
10) ->addUnprintable( Unprintable $unprintable )
```
Accepts an instance of the `\OOPCRE\Foundation\Definition\Unprintable` enum, and matches a character that can not be printed, such as line feed character.
```php
11) ->addWhitespace( Whitespace $whitespace )
```
Will accept an instance of the `\OOPCRE\Foundation\Definition\Whitespace` enum, and will match a whitespace character. Defaults to a single space.

#### 6.6.2) The `->simple*()` method set
These methods are for adding a very basic item to the pattern builder. They do not return the instance of the created `Pattern` class, instead, they return the same instance of the `PatternBuilder` that is being used to build the current pattern. Note that we mentioned **current**, as some operations such as replacements can have an array of patterns and therefore an array of pattern builders. Below is a full list of these methods. However, since they behave similarly to the `add*()` methods, the description have been excluded.
```php
1)  ->simpleCharacter( string $char )
2)  ->simpleCharacterClass( string $characters, bool $not )
3)  ->simpleFloat( float $float, int $precision, bool $unsigned )
4)  ->simpleInteger( int $int, bool $unsigned )
5)  ->simpleMetaChar( Metacharacter $metacharacter )
6)  ->simpleRange( array $range, bool $not )
7)  ->simpleText( string $text )
8)  ->simpleUnicode( string $code )
9)  ->simpleUnprintable( Unprintable $unprintable )
10) ->simpleWhitespace( Whitespace $whitespace )
```
#### 6.6.3) The `->posix*()` method set ( Advanced )
The `->posix*()` methods will add a pre-defined posix character class as a pattern. These methods are as follows:

```php
1) ->posixAlpha()
```
Match alphabetic characters. Similar to `[[:upper:][:lower:]]`;

```php
2) ->posixAlphaNumeric()
```
Match alphabetic and numeric characters. Similar to `[[:alpha:][:digit:]]`;

```php
3) ->posixBlank()
```
Match space or tab characters. Similar to `[ \t]`.

```php
4) ->posixCtrlChar()
```
Match the control characters.

```php
5) ->posixDigit()
```
Match any digit. Similar to `[0-9]`.

```php
6) ->posixGraph()
```
Match Non-blank character (excludes spaces, control characters, and similar) Similar to `[^ \t\n\r\f\v]`.

```php
7) ->posixLowerCase()
```

Match lowercase alphabetical character. Similar to `[a-z]`.

```php
8) ->posixPrint()
```
Works like `[:graph:]`, but includes the space character. Similar to `[^\t\n\r\f\v]`.

```php
9) ->posixPunctuation()
```

Match punctuation character. Similar to `[.,!?:…]`.

```php
10) ->posixSpace()
```

Match whitespace character (`[:blank:]`, newline,  carriage return, etc.). Similar to `[ \t]`.

```php
11) ->posixUppercase()
```
Match uppercase alphabetical characters. Similar to `[A-Z]`.

```php
12) ->posixHexDigit()
```
Match digit in a hexadecimal number (i.e., 0-9a-fA-F). Similar to `[0-9A-Fa-f]`.

#### 6.6.4) Additional methods
Apart from the 3 sets of above methods, `PatternBuilder` class offers 4 more methods:

+ `->group( \Closure $closure, string $name )`. This method allows you to define a named pattern group. The closure passed to its first argument will receive a new instance of the `PatternBuilder`, which allows you to build a complete new sub-pattern and assign a name to it. Dropping the `name` argument will generate a random name for the group.
+ `->getPatternString()` method which returns the compiled pattern.
+ `->modifiers()` method returns an instance of the modifier builder. Will be explained shortly.
+ `->raw( string $text  )` method allows you to add a raw and unescaped string to the pattern, such as `[a]{2}(foo|bar)`. The input will not be processed, so use carefully.
#### 6.7) Modifier builder class
Calling the `->modifiers()` method on the `PatternBuilder` class will return the instance of the `\OOPCRE\Foundation\Pattern\ModifierBuilder` class that is currently in use for the current pattern. It returns a new instance of the `ModifierBuilder` class if no modifier has been added to the pattern yet.

This class provided the following methods, which each add one of the cases of the `OOPCRE\Foundation\Definition\Modifier` backed-enum. Each modifier is extensively explained in the `Modifier` enum class, so we will skip the description.
+ `->anchored()`
+ `->caseInsensitive()`
+ `->dollarEndOnly()`
+ `->dotAll()`
+ `->extended()`
+ `->extra()`
+ `->multiline()`
+ `->study()`
+ `->ungreedy()`
+ `->unicode()`

Again, each method returns the instance of `ModifierBuilder` so you can chain the methods as long as they make sense together.

#### 6.8) Grouping & naming patterns
As mentioned earlier, you can call the `->group()` method on the `PatternBuilder` class to group a set of patterns together. This is specially useful when working with `preg_match*` methods, that allow capturing named sub-patterns. Below is s a basic example of how to group patterns. Let's reuse of previous example:

```php
$patterns = $match->patterns();
$patterns->addText( '<img' );
$patterns->addCharacterClass( '>', TRUE )->unlimited();
$patterns->addText( 'src=' );
$patterns->group(
    function ( \OOPCRE\Foundation\Pattern\PatternBuilder $builder ) {
        $builder->addCharacterClass( '\'"', TRUE )->unlimited();  
    }
);
$patterns->addCharacterClass( '>', TRUE )->unlimited();
$patterns->addCharacter( '>' );
```

The above pattern will be compiled into something similar to this:

```phpregexp
~<img[^>]*src=(?P<oopcre_6241ff33eadd0>[^'"]*)[^>]*>~im
```
Remember that the `->group()` method accepts a custom group name as its second argument, but you should avoid this unless you enabled duplicate group names. Even then, it's not recommended.

Grouping patterns also allows you to quickly find it later. The two match classes ( `PregMatch` & `PregMatchAll` ) both offer a `->results()` method that returns instance or instances of the `\OOPCRE\Foundation\Pattern\Result` class, depending on the situation. The `Result` class has 3 readonly properties:
+ `->name` This property holds the name of the group.
+ `->content`. This property holds the matched string.
+ `->offset` Holds the offset from the beginning of the string, which this match happened.

#### 6.9) Registering array of patterns
Certain operations such as `replaceMulti()` support array of input patterns. These operations provide a `register()` method which you can use to start registering a new pattern builder. This method returns a new instance of the pattern builder, with its own modifiers. Here's an example:

```php
$multiple = $regex->replaceMulti();

// Register 1st pattern
$multiple->register( 'replacement' )
->simpleCharacter( 'a' )
->simpleFloat( 2.5 );

// Register 2nd pattern
$multiple->register('example')
->simpleMetaChar( Metacharacter::ANY )
->addText( 'some-string' )
->between( 1, 3 );

// Execute
$result = $multiple->execute()
```

The `register()` method accepts either a replacement string, or a callable to be called when a replacement is about to happen. The callables are called by the php's `preg_*` functions, and receive the same arguments as they provide.

#### 6.10) Pre-defined items
**OOPCRE** comes with a set of pre-defined enums, that can be used in the application. The enums are located under the `/src/Foundation/Definition` directory, and are registered within the `OOPCRE\Foundation\Definition` namespace. Below is the full list of these enums and their purpose.

+ `Metacharacter` enum holds special regex characters known as metacharacters. You can use these cases in your regex while working with metacharacter methods.
+ `Modifier` enum is used internally, to build the modifiers. You can take a look at it to learn more about what each modifier does.
+ `Option` enum holds a list of possible configuration values, alongside their default values.
+ `PosixPattern` holds an array of supported posix patterns, that you can use as s shorthand in your regex operations.
+ `Quantifier` contains a list of regex quantifiers, explained earlier. Used internally.
+ `ServiceMap` internal enum that holds a list of default services registered and provided by the service container.
+ `Unprintable` keeps a list of unprintable characters, such as line feed and carriage return. You can use these cases while building your regex.
+ `Whitespace` is similar to `Unprintable`, except it only holds whitespace characters.

### 7) Helpers
**OOPCRE** provides a set of traits that you can use in your projects to quickly solve common regex problems. These traits don't use **OOPCRE** internally, and don't require PHP 8.1, they have been mainly added for convenient and to cover common cases. They are located under the `/src/Helper/Common` directory and registered within `\OOPCRE\Helper\Common` namespace. A list of these traits has been included below, and you can take a look inside them to see what they offer. Enjoy!

+ `UserInput` provides methods of parsing and validating common user inputs. 
+ `Html` provides ways to perform common operations on HTML content.
+ `Datetime` provides a set of methods to validate and parse common dates and time.
+ `Http` has methods to validate and work with HTTP uri and structure.
+ `File` provides methods to validate common filesystem elements.
