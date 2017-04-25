<?php


namespace ReversePolishCalculator\Operator;

use ReversePolishCalculator\Calculator;

/**
 * Class Add
 * @package ReversePolishCalculator\Operator
 */
class Divide extends BinaryOperatorAbstract {

    /**
     * @var string
     */
    const RANGE_ERROR_INVALID_NUMBER = "Cannot divide by zero";

    /**
     * @var string
     */
    const DIVISOR_OFFSET = 0;

    /**
     * @param Calculator $calculator
     * @return float
     */
    public function perform(Calculator $calculator) : float {

        return 1 / $calculator->pop() * $calculator->pop();
    }

    /**
     * @return string
     */
    public function getOperator() : string {
        return '/';
    }

    /**
     * @param Calculator $calculator
     * @return string[]
     */
    public function validate(Calculator $calculator) : array {

        $errors = parent::validate($calculator);
        $stackTop = $calculator->peek(self::DIVISOR_OFFSET);
        if (null !== $stackTop && $stackTop == 0) {
            $errors[] = static::RANGE_ERROR_INVALID_NUMBER;
        }
        return $errors;
    }
}