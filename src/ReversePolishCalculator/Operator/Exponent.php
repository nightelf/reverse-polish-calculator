<?php


namespace ReversePolishCalculator\Operator;

use ReversePolishCalculator\Calculator;

/**
 * Class Add
 * @package ReversePolishCalculator\Operator
 */
class Exponent extends BinaryOperatorAbstract {

    /**
     * @param Calculator $calculator
     * @return float
     */
    public function perform(Calculator $calculator) : float {

        $exponent = $calculator->pop();
        return $calculator->pop() ** $exponent;
    }

    /**
     * @return string
     */
    public function getOperator() : string {
        return '**';
    }
}