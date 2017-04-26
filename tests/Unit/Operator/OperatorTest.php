<?php

namespace Unit;

use PHPUnit\Framework\TestCase,
    PHPUnit_Framework_MockObject_MockObject as MockObject,
    ReversePolishCalculator\Operator;

/**
 * Class OperatorTest
 * @package Unit
 */
class OperatorTest extends TestCase {

    /**
     * @param string $class
     * @param float[] $numbers
     * @param float $expectedResult
     * @dataProvider performDataProvider
     */
    public function testPerform($class, $numbers, $expectedResult) {

        $calculator = $this->getCalculatorMock($numbers);
        $operatorName = 'ReversePolishCalculator\Operator\\' . $class;
        $operator = new $operatorName();
        $result = $operator->perform($calculator);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function performDataProvider() {
        return [
            [ 'class' => 'Add',  'numbers' => [2, 3], 'expectedResult' => 5 ],
            [ 'class' => 'Subtract',  'numbers' => [3, 2], 'expectedResult' => -1 ],
            [ 'class' => 'Multiply',  'numbers' => [2, 3], 'expectedResult' => 6 ],
            [ 'class' => 'Divide',  'numbers' => [3, 12], 'expectedResult' => 4 ],
            [ 'class' => 'Exponent',  'numbers' => [3, 2], 'expectedResult' => 8 ],
            [ 'class' => 'Inverse',  'numbers' => [2], 'expectedResult' => 0.5 ],
        ];
    }

    /**
     * @param string $class
     * @param int $count
     * @param float $peek
     * @param string $error
     * @dataProvider validateDataProvider
     */
    public function testValidate($class, $count, $peek, $error) {

        $calculator = $this->getCalculatorMock(null, $count, $peek);
        $operatorName = 'ReversePolishCalculator\Operator\\' . $class;
        $operator = new $operatorName();
        $result = $operator->validate($calculator);
        $this->assertEquals(1, count($result));
        $this->assertContains($error, $result);
    }

    /**
     * @return array
     */
    public function validateDataProvider() {
        return [
            [ 'class' => 'Add',  'count' => 1, 'peek' => 1, 'error' => Operator\BinaryOperatorAbstract::DOMAIN_ERROR_INVALID_STACK ],
            [ 'class' => 'Subtract',  'count' => 1, 'peek' => 1, 'error' => Operator\BinaryOperatorAbstract::DOMAIN_ERROR_INVALID_STACK ],
            [ 'class' => 'Multiply',  'count' => 1, 'peek' => 1, 'error' => Operator\BinaryOperatorAbstract::DOMAIN_ERROR_INVALID_STACK ],
            [ 'class' => 'Divide',  'count' => 1, 'peek' => 1, 'error' => Operator\BinaryOperatorAbstract::DOMAIN_ERROR_INVALID_STACK ],
            [ 'class' => 'Divide',  'count' => 2, 'peek' => 0, 'error' => Operator\Divide::RANGE_ERROR_INVALID_NUMBER ],
            [ 'class' => 'Exponent',  'count' => 1, 'peek' => 1, 'error' => Operator\BinaryOperatorAbstract::DOMAIN_ERROR_INVALID_STACK ],
            [ 'class' => 'Inverse',  'count' => 0, 'peek' => 1, 'error' => Operator\UnaryOperatorAbstract::DOMAIN_ERROR_INVALID_STACK ],
            [ 'class' => 'Inverse',  'count' => 1, 'peek' => 0, 'error' => Operator\Inverse::RANGE_ERROR_INVALID_NUMBER ],
        ];
    }

    /**
     * @param string $class
     * @param string $operatorSymbol
     * @dataProvider getOperatorDataProvider
     */
    public function testGetOperator($class, $operatorSymbol) {

        $operatorName = 'ReversePolishCalculator\Operator\\' . $class;
        $operator = new $operatorName();
        $result = $operator->getOperator();
        $this->assertEquals($operatorSymbol, $result);
    }

    /**
     * @return array
     */
    public function getOperatorDataProvider() {
        return [
            [ 'class' => 'Add',  'operator' => '+'],
            [ 'class' => 'Subtract',  'operator' => '-' ],
            [ 'class' => 'Multiply',  'operator' => '*' ],
            [ 'class' => 'Divide',  'operator' => '/' ],
            [ 'class' => 'Exponent',  'operator' => '**' ],
            [ 'class' => 'Inverse',  'operator' => 'i' ],
        ];
    }

    /**
     * @param float[]|null $numbers
     * @param int|null $count
     * @param float|null $peek
     * @return MockObject
     */
    protected function getCalculatorMock($numbers = null, $count = null, $peek = null) {

        $calculator = $this->getMockBuilder('ReversePolishCalculator\Calculator')
            ->getMock();
        if ($numbers !== null) {
            $calculator->method('pop')
                ->will($this->onConsecutiveCalls(...$numbers));
        }
        if ($count !== null) {
            $calculator->method('count')
                ->willReturn($count);
        }
        if ($peek !== null) {
            $calculator->method('peek')
                ->willReturn($peek);
        }
        return $calculator;
    }
}
