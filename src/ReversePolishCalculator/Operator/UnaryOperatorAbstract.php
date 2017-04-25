<?php

namespace ReversePolishCalculator\Operator;

use ReversePolishCalculator\Calculator;

/**
 * Class UnaryOperatorAbstract
 * @package ReversePolishCalculator\Operator
 */
abstract class UnaryOperatorAbstract implements OperatorInterface {

    /**
     * @var string
     */
    const DOMAIN_ERROR_INVALID_STACK = "Unary operators require one number on the stack";

    /**
     * @param Calculator $calculator
     * @return string[]
     */
    public function validate(Calculator $calculator) : array {

        return $calculator->count() == 0 ? [ static::DOMAIN_ERROR_INVALID_STACK ] : [];
    }
}
