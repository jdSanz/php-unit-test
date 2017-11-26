<?php

use PHPUnit\Framework\TestCase;
/*
 * Podemos ver los distintos asserts en
 * https://phpunit.de/manual/current/en/appendixes.assertions.html
 */

class SampleTest extends TestCase
{
	public function testTrueAssertsToTrue()
	{
		$this->assertTrue(true);
	}
}