<?php


namespace ReversePolishCalculator\Operator;

use ReversePolishCalculator\Calculator;

/**
 * Class Add
 * @package ReversePolishCalculator\Operator
 */
class Subtract extends BinaryOperatorAbstract {

    /**
     * @param Calculator $calculator
     * @return float
     */
    public function perform(Calculator $calculator) : float {

        return -1 * $calculator->pop() + $calculator->pop();
    }

    /**
     * @return string
     */
    public function getOperator() : string {
        return '-';
    }
}