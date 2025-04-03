<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../site/fonctionsLIG.php';

class FonctionsLIGTest extends TestCase {

    public function testLoiInverseGaussienne() {
        $result = loi_inverse_gaussienne(1.0, 2.0, 3.0);
        $this->assertIsFloat($result, "Le résultat doit être un float");
    }

    public function testMethodeRectanglesMedians() {
        $result = methode_rectangles_medians(1000, 2.0, 3.0, 10.0);
        $this->assertIsFloat($result, "Le résultat doit être un float");
    }

    public function testMethodeTrapezes() {
        $result = methode_trapezes(1000, 2.0, 3.0, 10.0);
        $this->assertIsFloat($result, "Le résultat doit être un float");
    }

    public function testMethodeSimpson() {
        $result = methode_simpson(1000, 2.0, 3.0, 10.0);
        $this->assertIsFloat($result, "Le résultat doit être un float");
    }

    public function testEcartType() {
        $result = ecart_type(2.0, 3.0);
        $this->assertIsFloat($result, "Le résultat doit être un float");
        $this->assertGreaterThan(0, $result, "L'écart-type doit être positif");
    }
}
