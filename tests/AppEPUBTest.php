<?php

namespace InfinityNext\Tests\Sleuth;

use InfinityNext\Sleuth\Detectives\epubDetective as epubDetective;

class AppEPUBTest extends \PHPUnit_Framework_TestCase
{
    public function testEPUB()
    {
        $detective = new EpubDetective;
        $detective->check(__DIR__ . "/files/normal.epub");
        $this->assertEquals('epub', $detective->getExtension());
    }

    /**
     * @expectedException \InfinityNext\Sleuth\Exceptions\CaseNotSolved
     */
    public function testZIP()
    {
        $detective = new EpubDetective;
        $detective->check(__DIR__ . "/files/normal.zip");
        $detective->getExtension();
    }
}
