<?php
namespace tests;

use \tomkyle\Entropy;

class EntropyTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider provideStringValues
     */
    public function testSimpleInstantiation( $string )
    {
        $h = new Entropy( $string );
        $this->assertInstanceOf('\tomkyle\Entropy', $h);
        $this->assertTrue( is_string( $h->__toString() ));
    }

    /**
     * @dataProvider provideStringValues
     */
    public function testFluentInterface( $string )
    {
        $h = new Entropy( 'test' );
        $this->assertInstanceOf('\tomkyle\Entropy', $h->setString( $string ));
    }


    /**
     * @dataProvider provideStringValues
     */
    public function testStringOutput( $string )
    {
        $h = new Entropy( $string );
        $this->assertEquals( $h->__toString(), (string) $h->calculate() );
    }

    /**
     * @dataProvider provideStringValues
     */
    public function testInvoking( $string )
    {
        $h = new Entropy( 'test' );
        $this->assertInternalType('float', $h( $string) );
    }

    /**
     * @dataProvider provideStringValues
     */
    public function testStringInterceptors( $string )
    {
        $h = new Entropy( 'test' );
        $h->setString( $string );
        $this->assertEquals( $string, $h->getString() );
    }

    /**
     * @dataProvider provideStringValues
     */
    public function testCalculation( $string )
    {
        $h = new Entropy( $string );
        $this->assertInternalType('float', $h->calculate() );
    }


    public function provideStringValues()
    {
        return array(
            array("Foo"),
            array("Lorem Ipsum"),
            array("129kk &%?\" '`'")
        );
    }




}
