<?php

namespace ReversePolishCalculator;

use Exception;

/**
 * Class ConsoleApp
 * @package ReversePolishCalculator
 */
class ConsoleApp {

    /**
     * @param Calculator $calculator
     */
    function run(Calculator $calculator) {

        print "\nReverse Polish Calculator:\nType 'q' + <enter> to quit when done.\n";
        $operators = implode(' ', $calculator->getOperators());
        $lastInput = false;

        while (!$lastInput) {
            $item = readline("Enter a number or operator ({$operators}):\n");

            if ("q" == $item) {
                $lastInput = true;
            } else if (is_numeric($item)) {

                $calculator->push($item);
            } else if ($calculator->isOperator($item)) {

                try {
                    $currentStackTop = $calculator->performOperation($item);
                    echo $currentStackTop . "\n";
                } catch (Exception $e) {
                    echo $e->getMessage() . "\n";
                }
            } else {
                echo "Unknown command or operation.\n";
            }
        }
    }
}