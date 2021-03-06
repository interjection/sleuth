<?php

use \InfinityNext\Sleuth\Detectives\ffmpegDetective as AudioDetective;

class AudioOGGTest extends PHPUnit_Framework_TestCase
{
	public function testOGG()
	{
		$detective = new AudioDetective;
		$detective->check(__DIR__ . "/files/normal.ogg");
		$this->assertEquals('ogg', $detective->getExtension());
	}
	
	public function testOGG()
	{
		$detective = new AudioDetective;
		$detective->check(__DIR__ . "/files/normal.ogg");
		$this->assertEquals('ogg', $detective->getExtension());
	}
}
