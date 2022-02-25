<?php

use Nojic\RandomPassword\RandomPassword;
use PHPUnit\Framework\TestCase;

class RandomPasswordTest extends TestCase
{
    public function testWeakPassword(): void
    {
        $service = new RandomPassword(1, 6);
        $pswd = $service->generate();

        $this->assertTrue((bool) preg_match('/^(?=.*?[A-Z])(?=.*?[a-z]).{6,}$/', $pswd));
    }

    public function testMediumPassword(): void
    {
        $service = new RandomPassword(2, 6);
        $pswd = $service->generate();

        $this->assertTrue((bool) preg_match('/^(?=.*?[A-Z][^A-Z]*[A-Z])(?=.*?[a-z])(?=.*?[2-5]).{6,}$/', $pswd));
    }

    public function testStrongPassword(): void
    {
        $service = new RandomPassword(3, 6);
        $pswd = $service->generate();

        $this->assertTrue((bool) preg_match('/^(?=.*?[\[\]!#$%&(){}=])(?=.*?[A-Z][^A-Z]*[A-Z])(?=.*?[2-5])(?=.*?[a-z]).{6,}$/', $pswd));
    }
}
