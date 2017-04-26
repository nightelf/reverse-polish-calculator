<?php

namespace Unit;

use PHPUnit\Framework\TestCase,
    PHPUnit_Framework_MockObject_MockObject as MockObject,
    ReversePolishCalculator\Operator\OperatorInterface,
    ReversePolishCalculator\Calculator;

/**
 * Class CalculatorTest
 * @package Unit
 */
class CalculatorTest extends TestCase {

    /**
     * @param $numbersIn
     * @dataProvider firstInLastOutDataProvider
     */
    public function testFirstInFirstLastOut($numbersIn) {

        $calculator = new Calculator();
        foreach ($numbersIn as $numberIn) {
            $calculator->push($numberIn);
        }

        $numbersOut = [];
        while($calculator->count()) {
            $numbersOut[] = $calculator->pop();
        }

        $this->assertNotEquals($numbersIn, $numbersOut);
        $this->assertEquals($numbersIn, array_reverse($numbersOut));
    }

    /**
     * @param $numbersIn
     * @dataProvider firstInLastOutDataProvider
     */
    public function testClear($numbersIn) {

        $calculator = new Calculator();
        foreach ($numbersIn as $numberIn) {
            $calculator->push($numberIn);
        }
        $calculator->clear();
        $this->assertEquals(0, $calculator->count());
    }

    /**
     * @param $numbersIn
     * @dataProvider firstInLastOutDataProvider
     */
    public function testGetStack($numbersIn) {

        $calculator = new Calculator();
        foreach ($numbersIn as $numberIn) {
            $calculator->push($numberIn);
        }
        $stack = $calculator->getStack();
        $this->assertNotEquals($numbersIn, $stack);
        $this->assertEquals($numbersIn, array_reverse($stack));
    }

    /**
     * @return array
     */
    public function firstInLastOutDataProvider() {
        return [
            [ 'numbersIn' => [ 5, 7, 9, 10.56, 5, 89, 6.66 ] ],
            [ 'numbersIn' => [ 555, 100, -22, -10.5544, 0, -1001, 8.88 ] ],
        ];
    }

    /**
     * Test register operator
     */
    public function testRegisterOperator() {

        $operatorSymbol1 = '$$';
        $operator1 = $this->getOperatorInterfaceMock($operatorSymbol1);

        $operatorSymbol2 = '##';
        $operator2 = $this->getOperatorInterfaceMock($operatorSymbol2);

        $this->assertTrue($operator1 instanceof OperatorInterface);
        $this->assertTrue($operator2 instanceof OperatorInterface);

        $calculator = new Calculator();
        $calculator->registerOperator($operator1);

        $this->assertTrue($calculator->isOperator($operatorSymbol1));
        $this->assertFalse($calculator->isOperator($operatorSymbol2));
    }

    /**
     * Test get operators
     */
    public function testGetOperators() {

        $operatorSymbol1 = '$$';
        $operator1 = $this->getOperatorInterfaceMock($operatorSymbol1);

        $operatorSymbol2 = '##';
        $operator2 = $this->getOperatorInterfaceMock($operatorSymbol2);

        $calculator = new Calculator();
        $calculator->registerOperator($operator1);
        $calculator->registerOperator($operator2);

        $operators = $calculator->getOperators();
        $this->assertEquals(2, count($operators));
        $this->assertContains($operatorSymbol1, $operators);
        $this->assertContains($operatorSymbol2, $operators);
    }

    /**
     * Test get operators
     */
    public function testOverloadOperator() {

        $operatorSymbol = '$$';
        $operator1 = $this->getOperatorInterfaceMock($operatorSymbol);
        $operator2 = $this->getOperatorInterfaceMock($operatorSymbol);

        $calculator = new Calculator();
        $calculator->registerOperator($operator1);
        $calculator->registerOperator($operator2);

        $operators = $calculator->getOperators();
        $this->assertEquals(1, count($operators));
        $this->assertContains($operatorSymbol, $operators);
    }

    /**
     * @param $symbol
     * @return MockObject
     */
    protected function getOperatorInterfaceMock($symbol) {

        $operator = $this->getMockBuilder('ReversePolishCalculator\Operator\OperatorInterface')
            ->getMock();
        $operator->method('getOperator')
            ->willReturn($symbol);
        return $operator;
    }
}
