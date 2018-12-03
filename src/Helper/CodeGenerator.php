<?php

namespace App\Helper;

use Hoa\Math\Sampler\Random;

/**
 * @property array $letters
 * @property array $numbers
 * @property int $maxLettersCount
 * @property int $maxNumbersCount
 */
class CodeGenerator
{
    private $letters = ['A', 'B', 'C', 'D', 'E', 'F'];
    private $numbers = ['2', '3', '4', '6', '7', '8', '9'];
    private $maxLettersCount = 6;
    private $maxNumbersCount = 4;

    public function generateCode(): string
    {
        $random = new Random();
        $lettersCount = $random->getInteger(0, $this->maxLettersCount);
        $numbersCount = $random->getInteger($lettersCount ? 0 : 1, $this->maxNumbersCount);
        $lettersPart = $this->getCharsPart($this->letters, $lettersCount);
        $numbersPart = $this->getCharsPart($this->numbers, $numbersCount);
        $codeArray = array_merge($lettersPart, $numbersPart);
        shuffle($codeArray);

        return implode($codeArray);
    }

    private function getCharsPart(array $chars, $size): array
    {
        $random = new Random();
        $charsPart = [];
        for ($i = 0; $i < $size; $i++) {
            $randomKey = $random->getInteger(0, $size-1);
            $charsPart[] = $chars[$randomKey];
        }

        return $charsPart;
    }

}
