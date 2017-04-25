<?php


namespace ReversePolishCalculator\Operator;

use ReversePolishCalculator\Calculator;

abstract class BinaryOperatorAbstract implements OperatorInterface {

    /**
     * @var string
     */
    const DOMAIN_ERROR_INVALID_STACK = "Binary operators require 2 numbers on the stack";

    /**
     * @param Calculator $calculator
     * @return string[]
     */
    public function validate(Calculator $calculator) : array {

        return $calculator->count() < 2 ? [ static::DOMAIN_ERROR_INVALID_STACK ] : [];
    }
}