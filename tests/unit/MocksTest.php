<?php

use PHPUnit\Framework\TestCase;

class MockTest extends TestCase
{
	/* No se pueden mockear métodos final, private o static
	 * Utilizamos mocks o stubs para reemplazar componentes de los cuales el SUT (Subject Under Test) depende
	 * Así hacemos el test independiente. 
	 *
	 *
	*/

	/** @test */
	public function simple_stub()
	{
		$stubDivision = $this->createMock(\App\Calculator\Division::class);
		$stubDivision->method('calculate')
			 ->willReturn(15);

		$stubAddition = $this->createMock(\App\Calculator\Addition::class);
		$stubAddition->method('calculate')
		 	 ->willReturn(12);

		$calculator = new \App\Calculator\Calculator;
		$calculator->setOperations([$stubDivision, $stubAddition]);

		$this->assertCount(2, $calculator->getOperations());
		$this->assertInternalType('array', $calculator->calculate());
		$this->assertEquals(15, $calculator->calculate()[0]);
		$this->assertEquals(12, $calculator->calculate()[1]);
	}

	/** 
	 * @test
	 * @dataProvider additionArguments
	 */
	public function method_get_multiple_arguments($arg)
	{
		$stubAddition = $this->createMock(\App\Calculator\Addition::class);
		$stubAddition->method('calculate')
					 ->will($this->returnArgument($arg[0]));

		$calculator = new \App\Calculator\Calculator;
		$calculator->setOperation($stubAddition);
		
		$this->assertEquals($arg[0], $calculator->calculate());
	}

	public function additionArguments()
	{
		return [[5],[10],[15],[20]];
	}

	/** @test */
	public function method_maps_values()
	{
        // Create a stub for the SomeClass class.
        $stub = $this->createMock(\App\Calculator\Test::class);

        // Create a map of arguments to return values.
        $map = [
            ['Hello', 'world', 'Hello world'],
            ['Me llamo', 'Diego', 'Me llamo Diego']
        ];

        // Configure the stub.
        $stub->method('unify_texts')
             ->will($this->returnValueMap($map));

        // $stub->doSomething() returns different values depending on
        // the provided arguments.
        $this->assertEquals('Hello world', $stub->unify_texts('Hello', 'world'));
        $this->assertEquals('Me llamo Diego', $stub->unify_texts('Me llamo', 'Diego'));
	}

	/** @test */
	public function method_returns_callback()
	{
		$stub = $this->createMock(\App\Calculator\Test::class);
		$stub->method('unify_texts')
			 ->will($this->returnCallback(function($arg1, $arg2){
			 	return $arg1 . ' ' . $arg2;
			 }));

		$this->assertEquals('Hola que tal', $stub->unify_texts('Hola', 'que tal'));
	}

	/** @test */
	public function method_returns_different_values_on_consecutive_calls()
	{
		$stub = $this->createMock(\App\Calculator\Test::class);
		$stub->method('unify_texts')
			 ->will($this->onConsecutiveCalls(1,2,3,4,5));

		$this->assertEquals(1, $stub->unify_texts('', ''));
		$this->assertEquals(2, $stub->unify_texts('', ''));
		$this->assertEquals(3, $stub->unify_texts('', ''));
		$this->assertEquals(4, $stub->unify_texts('', ''));
		$this->assertEquals(5, $stub->unify_texts('', ''));
	}

	/** @test */
	public function method_returns_exception()
	{
		$this->expectException(Exception::class);

		$stub = $this->createMock(\App\Calculator\Test::class);
		$stub->method('unify_texts')
			 ->will($this->throwException(new Exception));

		$stub->unify_texts('aa', 'bb');
	}
	/*
	$stub = $this->getMockBuilder
			->setMethods(array('__construct'))
    		->setConstructorArgs(array('http://jtreminio.com'))

	$mockBuilder = $this->getMockBuilder(Observer::class)
                         ->setMethods(['update'])
                         ->getMock();
	$observer->expects($this->once())
     ->method('update')
     ->with($this->equalTo('something'));
	*/
}
