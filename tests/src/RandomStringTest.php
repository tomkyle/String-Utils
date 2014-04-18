<?php
namespace tests;

use \tomkyle\RandomString;

class RandomStringTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider provideEvenIntegerValues
     */
    public function testSimpleInstantiation( $length )
    {
        $str = new RandomString( $length );
        $this->assertEquals( $length, strlen($str->__toString()));
    }

    /**
     * @dataProvider provideOddIntegerValues
     * @expectedException \LengthException
     */
    public function testOnOddValues( $length )
    {
        $str = new RandomString( $length );
    }


    public function provideEvenIntegerValues()
    {
        return array(
            array(4),
            array(64),
            array(256)
        );
    }

    public function provideOddIntegerValues()
    {
        return array(
            array(3),
            array(63),
            array(251)
        );
    }

}
