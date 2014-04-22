<?php
/**
 * This file is part of tomkyle/string-utils.
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
namespace tomkyle;


/**
 * @author Carsten Witt <tomkyle@posteo.de>
 */
class StopWatch
{
    public $start;

    public function __construct()
    {
        $this->start = microtime(  true  );
    }

    public function __toString()
    {
        return sprintf('%f', $this->stop());
    }

    public function stop( $new_time = false )
    {
        $now    = microtime( true );
        $result = $now - $this->start;
        if ( $new_time ) {
            $this->start = $now;
        }
        return $result;
    }
}
