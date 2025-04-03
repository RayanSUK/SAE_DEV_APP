<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../site/fonctions.php';

class FonctionsTest extends TestCase {

    public function testCaptcha() {
        session_start(); // Démarrer la session pour stocker le captcha

        $result = Captcha();

        // Vérifier que deux nombres ont été retournés
        $this->assertCount(2, $result, "Captcha doit retourner un tableau avec deux éléments.");

        // Vérifier que les valeurs sont des entiers entre 0 et 9
        $this->assertIsInt($result[0], "Le premier nombre doit être un entier.");
        $this->assertIsInt($result[1], "Le deuxième nombre doit être un entier.");
        $this->assertGreaterThanOrEqual(0, $result[0], "Le premier nombre doit être >= 0.");
        $this->assertLessThanOrEqual(9, $result[0], "Le premier nombre doit être <= 9.");
        $this->assertGreaterThanOrEqual(0, $result[1], "Le deuxième nombre doit être >= 0.");
        $this->assertLessThanOrEqual(9, $result[1], "Le deuxième nombre doit être <= 9.");

        // Vérifier que la somme est stockée correctement dans $_SESSION
        $this->assertEquals($_SESSION['captcha'], $result[0] + $result[1], "Le résultat du Captcha doit être correct.");
    }

    public function testRc4() {
        $key = "secret";
        $data = "HelloWorld";

        $encrypted = rc4($key, $data);
        $decrypted = rc4($key, $encrypted);

        // Vérifier que le texte déchiffré est identique au texte d'origine
        $this->assertEquals($data, $decrypted, "RC4 doit déchiffrer correctement le texte.");

        // Vérifier que le chiffrement produit une sortie différente du texte d'origine
        $this->assertNotEquals($data, $encrypted, "RC4 ne doit pas produire la même sortie que l'entrée.");
    }
}
