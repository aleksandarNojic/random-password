<?php

namespace Nojic\RandomPassword;

use Exception;

class RandomPassword
{
    const MIN_LENGTH_LOWER = 1;
    const MIN_LENGTH_UPPER = 2;
    const MIN_LENGTH_NUM = 1;
    const MIN_LENGTH_SPECIAL_CHAR = 1;

    private $strength, $length;

    /**
     * RandomPassword constructor
     *
     * @param integer $strength
     * @param integer $length
     */
    public function __construct(int $strength = 1, int $length = 6)
    {
        $this->strength = $strength;
        $this->length = $length;
    }

    public function generate()
    {
        if (!in_array($this->strength, [1, 2, 3])) {
            throw new Exception('The first argument should be password strength from 1 to 3');
        }

        if ($this->length < 6) {
            throw new Exception('The second argument should be password length with at least 6 characters');
        }

        switch ($this->strength) {
            case 1:
                return $this->weakPswd();
            case 2:
                return $this->mediumPswd();
            case 3:
                return $this->strongPswd();
        }
    }

    public function weakPswd()
    {
        $string = '';

        $upperMax = rand(self::MIN_LENGTH_UPPER, $this->length - self::MIN_LENGTH_LOWER);
        $string .= $this->generateChars(true, $upperMax);
        $string .= $this->generateChars(false, $this->length - strlen($string));

        return str_shuffle($string);
    }

    public function mediumPswd()
    {
        $string = '';

        $upperMax = rand(self::MIN_LENGTH_UPPER, $this->length - self::MIN_LENGTH_LOWER - self::MIN_LENGTH_NUM);
        $string .= $this->generateChars(true, $upperMax);

        $maxLower = rand(self::MIN_LENGTH_LOWER, $this->length - self::MIN_LENGTH_NUM - strlen($string));
        $string .= $this->generateChars(false, $maxLower);

        $maxNumLength = $this->length - strlen($string);
        $string .= $this->randomNums($maxNumLength, 2, 5);

        return str_shuffle($string);
    }

    public function strongPswd()
    {
        $string = '';
        $upperMax = rand(self::MIN_LENGTH_UPPER, $this->length - self::MIN_LENGTH_LOWER - self::MIN_LENGTH_NUM - self::MIN_LENGTH_SPECIAL_CHAR);
        $string .= $this->generateChars(true, $upperMax);

        $maxLower = rand(self::MIN_LENGTH_LOWER, $this->length - self::MIN_LENGTH_NUM - self::MIN_LENGTH_SPECIAL_CHAR - strlen($string));
        $string .= $this->generateChars(false, $maxLower);

        $maxNumLength = rand(self::MIN_LENGTH_NUM, $this->length - self::MIN_LENGTH_SPECIAL_CHAR - strlen($string));
        $string .= $this->randomNums($maxNumLength, 2, 5);

        $maxSpec = $this->length - strlen($string);
        $string .=  $this->specChars($maxSpec);

        return str_shuffle($string);
    }

    /**
     * Get random character
     *
     * @return string
     */
    private function randomChar()
    {
        $abc = 'abcdefghijklmnopqrstuvwxyz';

        return $abc[rand(0, strlen($abc) - 1)];
    }

    /**
     * Get uppercase or lowercase claimed length characters
     *
     * @param boolean $upper
     * @param integer $max
     * 
     * @return string
     */
    private function generateChars(bool $upper, int $maxLength)
    {
        $chars = '';

        for ($i = 0; $i < $maxLength; $i++) {
            $chars .= $upper ? strtoupper($this->randomChar()) : $this->randomChar();
        }

        return $chars;
    }

    /**
     * Get claimed length numbers from 2 to 5
     *
     * @param integer $maxLength
     * 
     * @return string
     */
    private function randomNums(int $maxLength, int $from, int $to)
    {
        $nums = '';

        for ($i = $maxLength; $i > 0; $i--) {
            $nums .= rand($from, $to);
        }

        return $nums;
    }

    /**
     * Get special claimed length special characters
     *
     * @param integer $max
     * 
     * @return string
     */
    private function specChars(int $maxLength)
    {
        $specialChars = str_shuffle('!#$%&(){}[]=');
        $str = '';

        for ($i = 0; $i < $maxLength; $i++) {
            $str .= $specialChars[$i];
        }

        return $str;
    }
}