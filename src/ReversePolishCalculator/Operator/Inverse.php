<?php


namespace ReversePolishCalculator\Operator;

use ReversePolishCalculator\Calculator;

/**
 * Class Add
 * @package ReversePolishCalculator\Operator
 */
class Inverse extends UnaryOperatorAbstract {

    /**
     * @var string
     */
    const RANGE_ERROR_INVALID_NUMBER = "Cannot take the inverse of zero";

    /**
     * @var string
     */
    const INVERSE_OFFSET = 0;

    /**
     * @param Calculator $calculator
     * @return float
     */
    public function perform(Calculator $calculator) : float {

        return 1 / $calculator->pop();
    }

    /**
     * @return string
     */
    public function getOperator() : string {
        return 'i';
    }

    /**
     * @param Calculator $calculator
     * @return string[]
     */
    public function validate(Calculator $calculator) : array {

        $errors = parent::validate($calculator);
        $stackTop = $calculator->peek(self::INVERSE_OFFSET);
        if (null !== $stackTop && $stackTop == 0) {
            $errors[] = static::RANGE_ERROR_INVALID_NUMBER;
        }
        return $errors;
    }
}