<?php

namespace Integration;

use PHPUnit\Framework\TestCase,
    ReversePolishCalculator\Calculator,
    ReversePolishCalculator\CalculatorBuilder;

class CalculatorTest extends TestCase {


    /**
     * @param float[] $stack
     * @param string[] $operators
     * @param float $expectedResult
     * @dataProvider operationsDataProvider
     */
    public function testAll($stack, $operators, $expectedResult) {

        $calculator = CalculatorBuilder::buildCalculator();

        // add items to the stack
        foreach($stack as $number) {
            $calculator->push($number);
        }

        // perform operations
        foreach($operators as $operator) {
            $actual = $calculator->performOperation($operator);
        }

        // assertions
        $this->assertEquals($expectedResult, $actual);
    }

    /**
     * @return array
     */
    public function operationsDataProvider() {
        return [
            [ 'stack' => [5, 7], 'operators' => ['+'], 'expectedResult' => 12 ],  // simple addition
            [ 'stack' => [5, 7], 'operators' => ['-'], 'expectedResult' => -2 ],  // simple subtraction
            [ 'stack' => [5, 7], 'operators' => ['*'], 'expectedResult' => 35 ],  // simple multiplication
            [ 'stack' => [42, 7], 'operators' => ['/'], 'expectedResult' => 6 ],  // simple division
            [ 'stack' => [5], 'operators' => ['i'], 'expectedResult' => 0.2 ],  // simple inverse
            [ 'stack' => [2, 3], 'operators' => ['**'], 'expectedResult' => 8 ],  // simple exponent
            [ 'stack' => [3, 2, 1], 'operators' => ['+', '*'], 'expectedResult' => 9 ],  // complex from http://www.calculator.org/rpn.aspx
            [ 'stack' => [1, 2, 3], 'operators' => ['*', '+'], 'expectedResult' => 7 ],  // complex from http://www.calculator.org/rpn.aspx
            [ 'stack' => [3, 9, 5], 'operators' => ['-', '**'], 'expectedResult' => 81 ],  // complex
            [ 'stack' => [32, 2, 3], 'operators' => ['**', '/'], 'expectedResult' => 4 ],  // complex
            [ 'stack' => [100, 55, 5], 'operators' => ['-', 'i', '*'], 'expectedResult' => 2 ],  // complex
        ];
    }
}
