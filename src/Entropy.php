<?php
/**
 * This file is part of tomkyle/string-utils.
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
namespace tomkyle;

/**
 * Entropy
 */
class Entropy
{

    public $str;

    /**
     * @var float
     */
    public $h;


    public function __construct( $str )
    {
        $this->setString($str);
    }

    public function __toString()
    {
        return '' . $this->calculate();
    }


    public function __invoke( $str )
    {
        $this->setString( $str );
        return $this->calculate();
    }



    public function setString( $str )
    {
        $this->str = $str;
        return $this;
    }

    public function getString( )
    {
        return $this->str;
    }



    /**
     * return float
     * @see http://stackoverflow.com/a/3198026
     */
    public function calculate() {
        $this->h    = 0;
        $str = $this->getString();

        $size = strlen( $str );
        foreach (count_chars( $str, 1 ) as $v) {
            $p  = $v / $size;
            $this->h -= $p * log($p) / log(2);
        }
        return $this->h;
    }
}
