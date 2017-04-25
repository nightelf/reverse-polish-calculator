<?php

namespace Integration;

use PHPUnit\Framework\TestCase,
    ReversePolishCalculator\Operator,
    ReversePolishCalculator\CalculatorBuilder;

/**
 * Class CalculatorTest
 * @package Integration
 */
class CalculatorTest extends TestCase {

    /**
     * @param float[] $stack
     * @param string[] $operators
     * @param float $expectedResult
     * @dataProvider operationsDataProvider
     */
    public function testOperations($stack, $operators, $expectedResult) {

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

    /**
     * @param float[] $stack
     * @param string[] $operators
     * @param float $expectedError
     * @dataProvider errorMessageDataProvider
     */
    public function testException($stack, $operators, $expectedError) {

        $calculator = CalculatorBuilder::buildCalculator();

        // add items to the stack
        foreach($stack as $number) {
            $calculator->push($number);
        }

        $this->expectException(\Exception::class);
        try {
            // perform operations
            foreach ($operators as $operator) {
                $calculator->performOperation($operator);
            }
            $this->fail('Should have thrown an exception');
        } catch (Exception $e) {
            $this->assertContains($expectedError, $e->getMessage()); // Exception occurred
        }
    }

    /**
     * @return array
     */
    public function errorMessageDataProvider() {
        return [
            [ 'stack' => [5], 'operators' => ['+'], 'expectedError' => Operator\Add::DOMAIN_ERROR_INVALID_STACK ],  // addition
            [ 'stack' => [5], 'operators' => ['-'], 'expectedError' => Operator\Subtract::DOMAIN_ERROR_INVALID_STACK ],  // subtraction
            [ 'stack' => [5], 'operators' => ['*'], 'expectedError' => Operator\Multiply::DOMAIN_ERROR_INVALID_STACK ],  // multiplication
            [ 'stack' => [42], 'operators' => ['/'], 'expectedError' => Operator\Divide::DOMAIN_ERROR_INVALID_STACK ],  // division
            [ 'stack' => [42, 0], 'operators' => ['/'], 'expectedError' => Operator\Divide::RANGE_ERROR_INVALID_NUMBER ],  // division
            [ 'stack' => [], 'operators' => ['i'], 'expectedError' => Operator\Inverse::DOMAIN_ERROR_INVALID_STACK ],  // inverse
            [ 'stack' => [0], 'operators' => ['i'], 'expectedError' => Operator\Inverse::RANGE_ERROR_INVALID_NUMBER ],  // inverse
            [ 'stack' => [2], 'operators' => ['**'], 'expectedError' => Operator\Exponent::DOMAIN_ERROR_INVALID_STACK ],  // exponent
        ];
    }
}
