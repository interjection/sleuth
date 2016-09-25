<?php

namespace InfinityNext\Tests\Sleuth;

use InfinityNext\Sleuth\Detectives\PdfDetective as PdfDetective;

class AppPDFTest extends \PHPUnit_Framework_TestCase
{
    public function testGood()
    {
        $detective = new PdfDetective;
        $detective->check(__DIR__ . "/files/normal.pdf");
        $this->assertEquals('pdf', $detective->getExtension());
    }
}
