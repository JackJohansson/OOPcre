<?php

	namespace OOPCRE\Helper\Common;
	/**
	 * Helper trait to provide regexes for working
	 * with user inputs.
	 *
	 * @package OOPCRE
	 * @version 1.0.0
	 */
	trait UserInput {

		/**
		 * Counts how many decimal numbers exist in the given input.
		 *
		 * @param string $decimal
		 *
		 * @return int
		 */
		public function countDecimals( string $decimal ): int {
			return (int) @preg_match_all(
				'/^\d*\.\d+$/',
				$decimal
			);
		}

		/**
		 * Count how many duplicate entries exist in a text in total.
		 *
		 * @param string $text
		 *
		 * @return int
		 */
		public function countDuplicates( string $text ): int {
			return (int) @preg_match_all(
				'/(\b\w+\b)(?=.*\b\1\b)/',
				$text
			);
		}

		/**
		 * Count how many integers exist in the text.
		 *
		 * @param string $number
		 *
		 * @return int
		 */
		public function countIntegers( string $number ): int {
			return (int) @preg_match(
				'/^\d+$/',
				$number
			);
		}

		/**
		 * Counts how many numbers exist in the input. Whether integer,
		 * float or negative.
		 *
		 * @param string $number
		 *
		 * @return int
		 */
		public function countNumbers( string $number ): int {
			return (int) @preg_match_all(
				'/^-?\d*(\.\d+)?$/',
				$number
			);
		}

		/**
		 * Check if the text only contains alphanumeric characters.
		 *
		 * @param string $text
		 *
		 * @return bool
		 */
		public function isAlphaNum( string $text ): bool {
			return (bool) @preg_match(
				'/^[a-zA-Z0-9]*$/',
				$text
			);
		}

		/**
		 * Check if the text only contains alphanumeric characters and space.
		 *
		 * @param string $text
		 *
		 * @return bool
		 */
		public function isAlphaNumSpace( string $text ): bool {
			return (bool) @preg_match(
				'/^[a-zA-Z0-9 ]*$/',
				$text
			);
		}

		/**
		 * Check if the input string is a valid American Express card number.
		 *
		 * @param string $card
		 *
		 * @return bool
		 */
		public function isAmericanExpress( string $card ): bool {
			return (bool) @preg_match(
				'/^3[47][0-9]{13}$/',
				$card
			);
		}

		/**
		 * Check if the given input contains a valid card number
		 * from the following:
		 *
		 * Visa
		 * Mastercard
		 * American Express
		 * Diners Club
		 * Discover
		 * JCB
		 *
		 * @param string $card
		 *
		 * @return bool
		 */
		public function isCreditCard( string $card ): bool {
			return (bool) @preg_match(
				'/^(?:4[0-9]{12}(?:[0-9]{3})?|(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|6(?:011|5[0-9]{2})[0-9]{12}|(?:2131|1800|35\d{3})\d{11})$/',
				$card
			);
		}

		/**
		 * Check if the input string is a valid Diners Club card number.
		 *
		 * @param string $card
		 *
		 * @return bool
		 */
		public function isDinersClub( string $card ): bool {
			return (bool) @preg_match(
				'/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',
				$card
			);
		}

		/**
		 * Check if the input string is a valid Discover card number.
		 *
		 * @param string $card
		 *
		 * @return bool
		 */
		public function isDiscoverCard( string $card ): bool {
			return (bool) @preg_match(
				'/^6(?:011|5[0-9]{2})[0-9]{12}$/',
				$card
			);
		}

		/**
		 * Basic check for common email addresses.
		 *
		 * @param string $email
		 *
		 * @return bool
		 */
		public function isEmail( string $email ): bool {
			return (bool) @preg_match(
				'/^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})*$/',
				$email
			);
		}

		/**
		 * Check if the input string is a valid JCB card number.
		 *
		 * @param string $card
		 *
		 * @return bool
		 */
		public function isJCBCard( string $card ): bool {
			return (bool) @preg_match(
				'/^(?:2131|1800|35\d{3})\d{11}$/',
				$card
			);
		}

		/**
		 * Check if the input string is a valid MasterCard card number.
		 *
		 * @param string $card
		 *
		 * @return bool
		 */
		public function isMasterCard( string $card ): bool {
			return (bool) @preg_match(
				'/^(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}$/',
				$card
			);
		}

		/**
		 * Whether the given string is a moderately safe password. It must
		 * contain at least 1 number, 1 uppercase letter, 1 lowercase letter
		 * and be 8 characters long.
		 *
		 * @param string $password
		 *
		 * @return bool
		 */
		public function isModeratePassword( string $password ): bool {
			return (bool) @preg_match(
				'/(?=(.*[0-9]))((?=.*[A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z]))^.{8,}$/',
				$password
			);
		}

		/**
		 * Check if the given string is a valid passport number.
		 *
		 * @param string $passport
		 *
		 * @return bool
		 */
		public function isPassportNumber( string $passport ): bool {
			return (bool) @preg_match(
				'/^[A-PR-WY][1-9]\d\s?\d{4}[1-9]$/',
				$passport
			);
		}

		/**
		 * Check if the input is a valid international phone number.
		 *
		 * @param string $number
		 *
		 * @return bool
		 */
		public function isPhoneNumber( string $number ): bool {
			return (bool) @preg_match(
				'/^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/',
				$number
			);
		}

		/**
		 * Check whether a given input is an email address using
		 * the official RFC 5322 standard.
		 *
		 * @param string $email
		 *
		 * @return bool
		 */
		public function isRfcEmail( string $email ): bool {
			return
				(bool) @preg_match(
					'/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD',
					$email
				);
		}

		/**
		 * Whether the given string is a secure password or not.
		 * Secure password has 1 lowercase letter, 1 uppercase letter,
		 * 1 number, 1 special character and is at least 8 characters long.
		 *
		 * @param string $password
		 *
		 * @return bool
		 */
		public function isSecurePassword( string $password ): bool {
			return (bool) @preg_match(
				"/(?=(.*[0-9]))(?=.*[\!@#$%^&*()\\[\]{}\-_+=~`|:;\"'<>,./?])(?=.*[a-z])(?=(.*[A-Z]))(?=(.*)).{8,}/",
				$password
			);
		}

		/**
		 * Check if the input is a valid social security number.
		 *
		 * @param string $number
		 *
		 * @return bool
		 */
		public function isSocialSecurityNumber( string $number ): bool {
			return (bool) @preg_match(
				'/^((?!219-09-9999|078-05-1120)(?!666|000|9\d{2})\d{3}-(?!00)\d{2}-(?!0{4})\d{4})|((?!219 09 9999|078 05 1120)(?!666|000|9\d{2})\d{3} (?!00)\d{2} (?!0{4})\d{4})|((?!219099999|078051120)(?!666|000|9\d{2})\d{3}(?!00)\d{2}(?!0{4})\d{4})$/',
				$number
			);
		}

		/**
		 * Check whether the input string is a valid username.
		 * A valid username includes only alphabet, numbers, underscore
		 * and dash.
		 *
		 * @param string $username
		 *
		 * @return bool
		 */
		public function isUsername( string $username ): bool {
			return (bool) @preg_match(
				'/^[a-zA-Z0-9_-]{3,16}$/',
				$username
			);
		}

		/**
		 * Check if the input string is a valid Visa card number.
		 *
		 * @param string $card
		 *
		 * @return bool
		 */
		public function isVisaCard( string $card ): bool {
			return (bool) @preg_match(
				'/^4[0-9]{12}(?:[0-9]{3})?$/',
				$card
			);
		}

		/**
		 * Check if the input string is a valid zipcode. Supports a set of common countries.
		 *
		 * @param string $zipcode
		 * @param string $code
		 *
		 * @return bool
		 */
		public function isZipcode( string $zipcode, string $code = '' ): bool {
			$map = [
				"GB" => "GIR[ ]?0AA|((AB|AL|B|BA|BB|BD|BH|BL|BN|BR|BS|BT|CA|CB|CF|CH|CM|CO|CR|CT|CV|CW|DA|DD|DE|DG|DH|DL|DN|DT|DY|E|EC|EH|EN|EX|FK|FY|G|GL|GY|GU|HA|HD|HG|HP|HR|HS|HU|HX|IG|IM|IP|IV|JE|KA|KT|KW|KY|L|LA|LD|LE|LL|LN|LS|LU|M|ME|MK|ML|N|NE|NG|NN|NP|NR|NW|OL|OX|PA|PE|PH|PL|PO|PR|RG|RH|RM|S|SA|SE|SG|SK|SL|SM|SN|SO|SP|SR|SS|ST|SW|SY|TA|TD|TF|TN|TQ|TR|TS|TW|UB|W|WA|WC|WD|WF|WN|WR|WS|WV|YO|ZE)(\d[\dA-Z]?[ ]?\d[ABD-HJLN-UW-Z]{2}))|BFPO[ ]?\d{1,4}",
				"JE" => "JE\d[\dA-Z]?[ ]?\d[ABD-HJLN-UW-Z]{2}",
				"GG" => "GY\d[\dA-Z]?[ ]?\d[ABD-HJLN-UW-Z]{2}",
				"IM" => "IM\d[\dA-Z]?[ ]?\d[ABD-HJLN-UW-Z]{2}",
				"US" => "\d{5}([ \-]\d{4})?",
				"CA" => "[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJ-NPRSTV-Z][ ]?\d[ABCEGHJ-NPRSTV-Z]\d",
				"DE" => "\d{5}",
				"JP" => "\d{3}-\d{4}",
				"FR" => "\d{2}[ ]?\d{3}",
				"AU" => "\d{4}",
				"IT" => "\d{5}",
				"CH" => "\d{4}",
				"AT" => "\d{4}",
				"ES" => "\d{5}",
				"NL" => "\d{4}[ ]?[A-Z]{2}",
				"BE" => "\d{4}",
				"DK" => "\d{4}",
				"SE" => "\d{3}[ ]?\d{2}",
				"NO" => "\d{4}",
				"BR" => "\d{5}[\-]?\d{3}",
				"PT" => "\d{4}([\-]\d{3})?",
				"FI" => "\d{5}",
				"AX" => "22\d{3}",
				"KR" => "\d{3}[\-]\d{3}",
				"CN" => "\d{6}",
				"TW" => "\d{3}(\d{2})?",
				"SG" => "\d{6}",
				"DZ" => "\d{5}",
				"AD" => "AD\d{3}",
				"AR" => "([A-HJ-NP-Z])?\d{4}([A-Z]{3})?",
				"AM" => "(37)?\d{4}",
				"AZ" => "\d{4}",
				"BH" => "((1[0-2]|[2-9])\d{2})?",
				"BD" => "\d{4}",
				"BB" => "(BB\d{5})?",
				"BY" => "\d{6}",
				"BM" => "[A-Z]{2}[ ]?[A-Z0-9]{2}",
				"BA" => "\d{5}",
				"IO" => "BBND 1ZZ",
				"BN" => "[A-Z]{2}[ ]?\d{4}",
				"BG" => "\d{4}",
				"KH" => "\d{5}",
				"CV" => "\d{4}",
				"CL" => "\d{7}",
				"CR" => "\d{4,5}|\d{3}-\d{4}",
				"HR" => "\d{5}",
				"CY" => "\d{4}",
				"CZ" => "\d{3}[ ]?\d{2}",
				"DO" => "\d{5}",
				"EC" => "([A-Z]\d{4}[A-Z]|(?:[A-Z]{2})?\d{6})?",
				"EG" => "\d{5}",
				"EE" => "\d{5}",
				"FO" => "\d{3}",
				"GE" => "\d{4}",
				"GR" => "\d{3}[ ]?\d{2}",
				"GL" => "39\d{2}",
				"GT" => "\d{5}",
				"HT" => "\d{4}",
				"HN" => "(?:\d{5})?",
				"HU" => "\d{4}",
				"IS" => "\d{3}",
				"IN" => "\d{6}",
				"ID" => "\d{5}",
				"IL" => "\d{5}",
				"JO" => "\d{5}",
				"KZ" => "\d{6}",
				"KE" => "\d{5}",
				"KW" => "\d{5}",
				"LA" => "\d{5}",
				"LV" => "\d{4}",
				"LB" => "(\d{4}([ ]?\d{4})?)?",
				"LI" => "(948[5-9])|(949[0-7])",
				"LT" => "\d{5}",
				"LU" => "\d{4}",
				"MK" => "\d{4}",
				"MY" => "\d{5}",
				"MV" => "\d{5}",
				"MT" => "[A-Z]{3}[ ]?\d{2,4}",
				"MU" => "(\d{3}[A-Z]{2}\d{3})?",
				"MX" => "\d{5}",
				"MD" => "\d{4}",
				"MC" => "980\d{2}",
				"MA" => "\d{5}",
				"NP" => "\d{5}",
				"NZ" => "\d{4}",
				"NI" => "((\d{4}-)?\d{3}-\d{3}(-\d{1})?)?",
				"NG" => "(\d{6})?",
				"OM" => "(PC )?\d{3}",
				"PK" => "\d{5}",
				"PY" => "\d{4}",
				"PH" => "\d{4}",
				"PL" => "\d{2}-\d{3}",
				"PR" => "00[679]\d{2}([ \-]\d{4})?",
				"RO" => "\d{6}",
				"RU" => "\d{6}",
				"SM" => "4789\d",
				"SA" => "\d{5}",
				"SN" => "\d{5}",
				"SK" => "\d{3}[ ]?\d{2}",
				"SI" => "\d{4}",
				"ZA" => "\d{4}",
				"LK" => "\d{5}",
				"TJ" => "\d{6}",
				"TH" => "\d{5}",
				"TN" => "\d{4}",
				"TR" => "\d{5}",
				"TM" => "\d{6}",
				"UA" => "\d{5}",
				"UY" => "\d{5}",
				"UZ" => "\d{6}",
				"VA" => "00120",
				"VE" => "\d{4}",
				"ZM" => "\d{5}",
				"AS" => "96799",
				"CC" => "6799",
				"CK" => "\d{4}",
				"RS" => "\d{6}",
				"ME" => "8\d{4}",
				"CS" => "\d{5}",
				"YU" => "\d{5}",
				"CX" => "6798",
				"ET" => "\d{4}",
				"FK" => "FIQQ 1ZZ",
				"NF" => "2899",
				"FM" => "(9694[1-4])([ \-]\d{4})?",
				"GF" => "9[78]3\d{2}",
				"GN" => "\d{3}",
				"GP" => "9[78][01]\d{2}",
				"GS" => "SIQQ 1ZZ",
				"GU" => "969[123]\d([ \-]\d{4})?",
				"GW" => "\d{4}",
				"HM" => "\d{4}",
				"IQ" => "\d{5}",
				"KG" => "\d{6}",
				"LR" => "\d{4}",
				"LS" => "\d{3}",
				"MG" => "\d{3}",
				"MH" => "969[67]\d([ \-]\d{4})?",
				"MN" => "\d{6}",
				"MP" => "9695[012]([ \-]\d{4})?",
				"MQ" => "9[78]2\d{2}",
				"NC" => "988\d{2}",
				"NE" => "\d{4}",
				"VI" => "008(([0-4]\d)|(5[01]))([ \-]\d{4})?",
				"PF" => "987\d{2}",
				"PG" => "\d{3}",
				"PM" => "9[78]5\d{2}",
				"PN" => "PCRN 1ZZ",
				"PW" => "96940",
				"RE" => "9[78]4\d{2}",
				"SH" => "(ASCN|STHL) 1ZZ",
				"SJ" => "\d{4}",
				"SO" => "\d{5}",
				"SZ" => "[HLMS]\d{3}",
				"TC" => "TKCA 1ZZ",
				"WF" => "986\d{2}",
				"XK" => "\d{5}",
				"YT" => "976\d{2}",
			];

			// If a supported code is provided
			if ( ! empty( $code ) && isset( $map[ $code ] ) ) {
				return (bool) @preg_match( "/{$map[ $code ]}/", $zipcode );
			}

			// Merge and search all
			return (bool) @preg_match( '/' . implode( '|', $map ) . '/', $zipcode );
		}
	}