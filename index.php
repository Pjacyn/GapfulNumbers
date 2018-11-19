<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GapfulNumber {

    public $generatorResult;
    protected $searchingNumbers;
    protected $generatorQuantity;

    public function __construct() {
        $this->searchingNumbers = $_GET['numbers'] ?? '';
        $this->generatorQuantity = $_GET['quantity'] ?? '';
        if (!empty($this->searchingNumbers)) {
            foreach (str_getcsv($this->searchingNumbers) as $number) {
                if (strlen($number) <= 2 OR ! is_numeric($number))
                    continue;
                $this->printResult($number);
            }
        }
        if (!empty($this->generatorQuantity)) {
            if (strlen($this->generatorQuantity) > 0 && is_numeric($this->generatorQuantity)) {
                $result = $this->turbOptimumBruteForce();
            }
        }
    }

    function printResult($number, $printFalse = true) {
        if ($this->isGapful($number))
            echo '<span style="color:green">' . $number . ' - is gapful</span>';
        else if ($printFalse)
            echo '<span style="color:red">' . $number . ' - is not gapful</span>';
        echo '<br>';
    }

    function isGapful($number) {
        $number = (string) $number;
        $firstNumber = (float) $number[0];
        $lastNumber = (float) $number[strlen($number) - 1];
        $divider = (float) $firstNumber . $lastNumber;
        if ($divider == 0)
            return false;
        if ($number % $divider == 0)
            return true;
        return false;
    }

    function turbOptimumBruteForce() {
        $iterationNumber = 0;
        $number = 100;
        while ($this->generatorQuantity > $iterationNumber) {
            if ($this->isGapful($number)) {
                $this->generatorResult .= $number . ',';
                $number++;
                $iterationNumber++;
            } else
                $number++;
        }
    }

}

$gapfulNumber = new GapfulNumber();
?>
<h1>Gapful number checker</h1>
<form id="numbers_from" action='#' method="GET">
    <label>Enter numbers with ','</label>
    <textarea form="numbers_from" name='numbers' style="width: 520px; height: 75px;"><?= $_GET['numbers'] ?? '' ?></textarea>
    <button type='submit'>Submit</button>
</form>
<h1>Gapful number generator</h1>
<form id="numbers_from" action='#' method="GET" style="margin-bottom: 400px;">
    <label>Enter number</label>
    <input name="quantity" value='<?= $_GET['quantity'] ?? '' ?>'/>
    <textarea form="numbers_from" readonly=""><?= $gapfulNumber->generatorResult ?? '' ?></textarea>
    <button type='submit'>Submit</button>
</form>

