<?php

namespace ReversePolishCalculator\Operator;

use ReversePolishCalculator\Calculator;

/**
 * Interface OperatorInterface
 * @package ReversePolishCalculator\Operator
 */
Interface OperatorInterface {

    /**
     * @param Calculator $calculator
     * @return float
     */
    public function perform(Calculator $calculator) : float;

    /**
     * @return string
     */
    public function getOperator() : string;

    /**
     * @param Calculator $calculator
     * @return string[]
     */
    public function validate(Calculator $calculator) : array;
}