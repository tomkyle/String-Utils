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
        $this->start = microtime('float');
    }

    public function __toString()
    {
        return sprintf('%f', $this->stop());
    }

    public function stop( $new_time = false )
    {
        $result = microtime('float') - $this->start;
        if ( $new_time ) {
            $this->start = microtime('float');
        }
        return $result;
    }
}
