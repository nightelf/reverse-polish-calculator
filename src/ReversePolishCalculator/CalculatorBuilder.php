<?php

namespace ReversePolishCalculator;

use ReversePolishCalculator\Operator;

/**
 * Class CalculatorBuilder
 * @package ReversePolishCalculator
 */
class CalculatorBuilder {

    /**
     * @var Calculator
     */
    protected $calculator;

    /**
     * CalculatorBuilder constructor.
     */
    public function __construct() {
        $this->calculator = new Calculator();
    }

    /**
     * Set the operators
     */
    public function setOperators() {

        $this->calculator->registerOperator(new Operator\Add());
        $this->calculator->registerOperator(new Operator\Divide());
        $this->calculator->registerOperator(new Operator\Multiply());
        $this->calculator->registerOperator(new Operator\Subtract());
        $this->calculator->registerOperator(new Operator\Exponent());
        $this->calculator->registerOperator(new Operator\Inverse());
    }

    /**
     * @return Calculator
     */
    public function getCalculator() {
        return $this->calculator;
    }

    /**
     * @return Calculator
     */
    public static function buildCalculator() {

        $calculatorBuilder = new CalculatorBuilder();
        $calculatorBuilder->setOperators();
        return $calculatorBuilder->getCalculator();
    }
}