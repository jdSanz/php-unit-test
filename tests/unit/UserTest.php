<?php

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

	protected $user;

	// Se ejecutara siempre antes de cada test
	protected function setUp()
	{
		$this->user = new \App\Models\User;
	}

	public function testThatWeCanGetTheFirstName()
	{
		$this->user->setFirstName('Nombre');
		$this->assertEquals($this->user->getFirstName(), 'Nombre');
	}

	public function testThatWeCanGetTheLastName()
	{
		$this->user->setLastName('Apellido');
		$this->assertEquals($this->user->getLastName(), 'Apellido');
	}

	public function testFullNameIsReturned()
	{
		$this->user->setFirstName('Nombre');
		$this->user->setLastName('Apellido');
		$this->assertEquals($this->user->getFullName(), 'Nombre Apellido');
	}

	public function testFirstAndLastNameAreTrimmed()
	{
		$this->user->setFirstName('Nombre      ');
		$this->user->setLastName('      Apellido');
		$this->assertEquals($this->user->getFirstName(), 'Nombre');
		$this->assertEquals($this->user->getLastName(), 'Apellido');
	}

	public function testEmailAddressCanBeSet()
	{
		$this->user->setEmail('email@curso.com');

		$this->assertEquals($this->user->getEmail(), 'email@curso.com');
	}

	/** @test */ //http://docs.phpdoc.org/guides/docblocks.html
	public function email_variables_contains_correct_values()
	{
		$this->user->setFirstName('Nombre');
		$this->user->setLastName('Apellido');
		$this->user->setEmail('email@curso.com');

		$emailVariables = $this->user->getEmailVariables();

		$this->assertArrayHasKey('full_name', $emailVariables);

		$this->assertArrayHasKey('email', $emailVariables);

		$this->assertEquals($emailVariables['full_name'], 'Nombre Apellido');

		$this->assertEquals($emailVariables['email'], 'email@curso.com');
	}
}