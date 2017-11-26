<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

require 'mocks/DatabaseMock.php';

class UserDatabaseTest extends DatabaseMock
{
	protected $connection;
	protected $user;

	protected function setUp()
	{
		$this->connection = $this->getConnection()->getConnection();
		$this->user = new \App\Models\User;
		parent::setUp();
	}

    public function getDataSet()
    {
        return $this->createXMLDataSet(dirname(__FILE__).'/_files/databaseXML.xml');
    }

    public function save_new_user_into_database()
    {

    }

    /** @test */
    public function save_user_with_email_already_registered_throws_PDOException()
    {
    	$this->expectException(PDOException::class);
    	
		$this->user->setEmail('diego@gmail.com');
		$this->user->saveInDB($this->connection);
    }
}