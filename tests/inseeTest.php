<?php

//class eZINSEETest extends ezpTestCase
class eZINSEETest extends PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "INSEE unit test case" );
    }

    protected function setUp()
    {
        parent::setUp();
    }


    public function testValidINSEE()
    {
		$this->assertEquals( INSEE::validate( '177022A00100229' ), true ); // Corse
		$this->assertEquals( INSEE::validate( '253012A07300444' ), true ); // Corse        
        $this->assertEquals( INSEE::validate( '177025626004544' ), true );
        $this->assertEquals( INSEE::validate( '253077507300483' ), true );
        $this->assertEquals( INSEE::validate( '188057208107893' ), true );        
    }
	/*
    public function testInvalidINSEE()
    {
        $this->assertEquals( INSEE::validate( '353072B07300483' ), false );
        $this->assertEquals( INSEE::validate( '253072C07300483' ), false );
    }

    public function testEmptyINSEEAsInvalid()
    {
        $this->assertEquals( INSEE::validate( '' ), false );
        $this->assertEquals( INSEE::validate( ' ' ), false );
    }
    */
}
?>
