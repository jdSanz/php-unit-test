<?php

namespace App\Models;

class User
{
	public $first_name;
	public $last_name;
	public $email;

	public function setFirstName($firstName)
	{
		$this->first_name = trim($firstName);
	}

	public function getFirstName()
	{
		return $this->first_name;
	}

	public function setLastName($lastName)
	{
		$this->last_name = trim($lastName);
	}

	public function getLastName()
	{
		return $this->last_name;
	}

	public function getFullName()
	{
		return $this->first_name.' '.$this->last_name;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getEmailVariables()
	{
		return [
			'full_name' => $this->getFullName(),
			'email' => $this->getEmail(),
		];
	}

	public function saveInDB($dbh)
	{
		$sth = $dbh->prepare('insert into usuarios values(?, ?, ?)');
		return $sth->execute([$this->first_name, $this->last_name, $this->email]);
	}

	public function getFromDB($dbh)
	{
		$sth = $dbh->prepare('select * from usuarios where email = ?');
		$sth->execute([$this->email]);
		return $sth->fetch();
	}

	public function deleteFromDB($dbh)
	{
		$sth = $dbh->prepare('delete from usuarios where email = ?');
		$sth->execute([$this->email]);
		return $sth->fetch();
	}
}