<?php


namespace ReversePolishCalculator;

use ReversePolishCalculator\Operator\OperatorInterface,
    SplStack,
    Exception;

/**
 * Class Calculator
 * @package ReversePolishCalculator
 */
class Calculator {

    /**
     * @var SplStack
     */
    private $stack;

    /**
     * OperatorAbstract[]
     */
    private $operators = [];

    /**
     * Calculator constructor.
     */
    public function __construct() {
        $this->clear();
    }

    /**
     * @param float $number
     */
    public function push(float $number) {
        $this->stack->push($number);
    }

    /**
     * @return float
     */
    public function pop() : float {
        return $this->stack->pop();
    }

    /**
     * @return int
     */
    public function count() : int {
        return count($this->stack);
    }

    /**
     * @param int $position
     * @return float|null null if offset doesn't exist
     */
    public function peek(int $position) {

        if ($this->stack->offsetExists($position)) {
            return $this->stack->offsetGet($position);
        }
        return null;
    }

    /**
     * Clear the stack contents
     */
    public function clear() {
        unset($this->stack);
        $this->stack = new SplStack();
    }

    /**
     * Clear the stack contents
     */
    public function getStack() {
        $items = [];
        foreach ($this->stack as $item) {
            $items[] = $item;
        }
        return $items;
    }

    /**
     * @param string $operator
     * @return float
     * @throws Exception
     */
    public function performOperation(string $operator) : float {

        if ($this->isOperator($operator)) {
            if ($errors = $this->operators[$operator]->validate($this)) {
                throw new Exception(implode('. ', $errors));
            }
            $number = $this->operators[$operator]->perform($this);
            $this->push($number);
            return $number;
        }

        return $this->stack->current();
    }

    /**
     * @param OperatorInterface $operator
     */
    public function registerOperator(OperatorInterface $operator) {
        $this->operators[$operator->getOperator()] = $operator;
    }

    /**
     * @param string $operator
     * @return bool
     */
    public function isOperator(string $operator) : bool {
        return isset($this->operators[$operator]);
    }

    /**
     * @return string[]
     */
    public function getOperators() : array {
        return array_keys($this->operators);
    }
}