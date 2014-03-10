<?php
/**
 * This file is part of tomkyle/string-utils.
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
namespace tomkyle;

/**
 * StringProvider
 *
 * Force objects providing `__toString` method.
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
interface StringProvider
{
	public function __toString();
}
