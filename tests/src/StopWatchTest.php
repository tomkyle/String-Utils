<?php
namespace tests;

use \tomkyle\StopWatch;

class StopWatchTest extends \PHPUnit_Framework_TestCase {

    public function testSimpleInstantiation( )
    {
        $s0 = new StopWatch;

        $s1 = $s0->stop();
        usleep(30);

        $s2 = $s0->stop();
        $this->assertGreaterThan($s1, $s2);

    }

    public function testStringOutput( )
    {
        $s0 = new StopWatch;
        $this->assertInternalType('string', $s0->__toString() );
    }


    public function testFloatVal( )
    {
        $s0 = new StopWatch;
        $this->assertInternalType('float', $s0->stop() );
    }


    public function testIntermediateTime( )
    {
        $s0 = new StopWatch;
        usleep(30);
        $s1 = $s0->stop("new time");
        usleep(10);
        $s2 = $s0->stop();
        $this->assertGreaterThan($s2, $s1);

    }


}
