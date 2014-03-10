<?php
/**
 * This file is part of tomkyle/string-utils.
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
namespace tomkyle;

use \tomkyle\StringProvider;


/**
 * RandomString
 *
 * Creates a random Hex string of a given length.
 *
 * WARNING: The algorithm used still MUST be checked twice if suitable
 * for any given purpose. Having that said – feel warned!
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
class RandomString implements StringProvider {

	/**
	 * @var string
	 */
	public $value;


	public function __construct($length = 64)
	{
		$strong = false;
		do {
    		$this->value = bin2hex(openssl_random_pseudo_bytes($length / 2, $strong));
		} while ( !$strong );
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->value;
	}
}
