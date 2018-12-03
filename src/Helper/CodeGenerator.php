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
        $lettersPart = $this->getCharsPart($this->letters, $this->maxLettersCount);
        $numbersPart = $this->getCharsPart($this->numbers, $this->maxNumbersCount);
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
