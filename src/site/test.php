<?php
use PHPUnit\Framework\TestCase;
require("fonctions.php");
require("fonctionsLIG.php");
class FunctionTests extends TestCase
{

    public function testLoiInverseGaussienne()
    {
        $this->assertEquals(0, loi_inverse_gaussienne(0, 1, 1));
        $this->assertEquals(0, loi_inverse_gaussienne(1, 1, 0));
        $this->assertGreaterThan(0, loi_inverse_gaussienne(1, 1, 1));
    }

    public function testMethodeRectanglesMedians()
    {
        $this->assertGreaterThan(0, methode_rectangles_medians(10, 1, 1, 1));
    }

    public function testMethodeTrapezes()
    {
        $this->assertGreaterThan(0, methode_trapezes(10, 1, 1, 1));
    }

    public function testMethodeSimpson()
    {
        $this->expectException(Exception::class);
        methode_simpson(3, 1, 1, 1);

        $this->assertGreaterThan(0, methode_simpson(4, 1, 1, 1));
    }

    public function testEcartType()
    {
        $this->assertEquals(1, ecart_type(1, 1));
        $this->assertEquals(sqrt(8), ecart_type(2, 1));
    }

    public function testCaptcha()
    {
        session_start();
        list($num1, $num2) = Captcha();
        $this->assertTrue(is_int($num1) && $num1 >= 0 && $num1 <= 9);
        $this->assertTrue(is_int($num2) && $num2 >= 0 && $num2 <= 9);
        $this->assertEquals($num1 + $num2, $_SESSION['captcha']);
    }

    public function testRc4()
    {
        $key = "Key";
        $data = "Plaintext";
        $encrypted = rc4($key, $data);
        $decrypted = rc4($key, $encrypted);
        $this->assertEquals($data, $decrypted);
    }
}

