<?php
namespace tests;

use \tomkyle\TextInterpolation;

class TextInterpolationTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider provideStringArray
     */
    public function testFullCtorArguments( $value_array )
    {
        $tpl = $this->createTestTemplate( $value_array );
        $ti  = new TextInterpolation( $tpl, $value_array );
        $this->assertEquals( implode(" ", $value_array), $ti->__toString());
    }



    /**
     * @dataProvider provideStringArray
     */
    public function testTemplateOnCtorAndInvoke( $value_array )
    {
        $tpl = $this->createTestTemplate( $value_array );
        $ti  = new TextInterpolation( $tpl );
        $this->assertEquals( implode(" ", $value_array), $ti( $value_array));
    }



    /**
     * @dataProvider provideStringArray
     */
    public function testNoCtorArguments( $value_array )
    {
        $tpl = $this->createTestTemplate( $value_array );
        $ti  = new TextInterpolation( );
        $ti->setTemplate($tpl);
        $ti->setContext( $value_array );
        $this->assertEquals( implode(" ", $value_array), $ti->__toString());
    }




    /**
     * @dataProvider provideStringArray
     */
    public function testFluentInterfacesOnTemplateSetter( $value_array )
    {
        $tpl = $this->createTestTemplate( $value_array );
        $ti  = new TextInterpolation( );
        $this->assertInstanceOf('\tomkyle\TextInterpolation', $ti->setTemplate( $tpl ));
    }


    /**
     * @dataProvider provideStringArray
     */
    public function testFluentInterfacesOnContextSetter( $value_array )
    {
        $tpl = $this->createTestTemplate( $value_array );
        $ti  = new TextInterpolation( $tpl );
        $this->assertInstanceOf('\tomkyle\TextInterpolation', $ti->setContext( $value_array ));
    }



    /**
     * @dataProvider provideStringArray
     */
    public function testContextInterceptorsBackAndForth( $value_array )
    {
        $tpl = $this->createTestTemplate( $value_array );
        $ti  = new TextInterpolation( $tpl );
        $this->assertEquals($value_array, $ti->setContext($value_array)->getContext());
    }

    /**
     * @dataProvider provideStringArray
     */
    public function testTemplateInterceptorsBackAndForth( $value_array )
    {
        $tpl = $this->createTestTemplate( $value_array );
        $ti  = new TextInterpolation( );
        $this->assertEquals($tpl, $ti->setTemplate($tpl)->getTemplate());
    }





    public function createTestTemplate( $array )
    {
        $mangle = array();
        $keys   = array_keys($array);

        foreach($keys as $index => $key) {
            array_push($mangle, '{' . $key . '}');
        }

        return implode(' ', $mangle );

    }

    public function provideStringArray()
    {
        return array(
            array(
                array(
                    'given' => "John",
                    'name'  => "Doe",
                    'state' => "Arkansas"
                )
            )
        );
    }


}
