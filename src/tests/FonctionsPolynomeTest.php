<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../site/fonctionsPolynome.php'; // Ajuste le chemin selon ton projet

class FonctionsPolynomeTest extends TestCase
{
    public function testDiscriminant()
    {
        $this->assertEquals(1, discriminant(1, -3, 2));
        $this->assertEquals(0, discriminant(1, -2, 1));
        $this->assertEquals(-3, discriminant(1, 1, 1));
    }

    public function testRacineReelle1()
    {
        $this->assertEquals(1, racineReelle1(1, -3, 2));
    }

    public function testRacineReelle2()
    {
        $this->assertEquals(2, racineReelle2(1, -3, 2));
    }

    public function testRacineUnique()
    {
        $this->assertEquals(1, racineUnique(1, -2));
    }

    public function testRacineComplexe1()
    {
        $this->assertEquals([-0.5, -sqrt(3)/2], racineComplexe1(1, 1, 1));
    }

    public function testRacineComplexe2()
    {
        $this->assertEquals([-0.5, sqrt(3)/2], racineComplexe2(1, 1, 1));
    }
}
