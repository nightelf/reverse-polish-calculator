<?php

namespace ReversePolishCalculator;

use Exception;

/**
 * Class ConsoleApp
 * @package ReversePolishCalculator
 */
class ConsoleApp {

    /**
     * RED ESCAPE CODE
     */
    const ESCAPE_CODE_RED = "\033[0;31m";

    /**
     * RED ESCAPE CODE
     */
    const ESCAPE_CODE_GREEN = "\033[0;32m";

    /**
     * RED ESCAPE CODE
     */
    const ESCAPE_CODE_LIGHT_BLUE = "\033[1;34m";

    /**
     * NO COLOR ESCAPE CODE
     */
    const ESCAPE_CODE_NO_COLOR = "\033[0m";

    /**
     * @param Calculator $calculator
     */
    public function run(Calculator $calculator) {

        print "\nReverse Polish Calculator:\nType 'q' + <enter> to quit when done.\n";
        $operators = implode(' ', $calculator->getOperators());
        $lastInput = false;

        while (!$lastInput) {
            $item = readline("Enter a number or operator ({$operators}) or command(q, c, s):\n");

            if ("q" == $item) {
                $lastInput = true;
            } else if ("c" == $item) {
                $calculator->clear();
                $this->outputInfo('Calculator stack cleared.');
            } else if ("s" == $item) {
                $currentStack = $calculator->getStack();
                if ($currentStack) {
                    $message = 'Current stack: top --> ' . implode(', ', $calculator->getStack()) . ' --> bottom';
                } else {
                    $message = "Current stack: empty";
                }
                $this->outputInfo($message);
            } else if (is_numeric($item)) {

                $calculator->push($item);
            } else if ($calculator->isOperator($item)) {

                try {
                    $currentStackTop = $calculator->performOperation($item);
                    $this->outputSuccess($currentStackTop);
                } catch (Exception $e) {
                    $this->outputError($e->getMessage());
                }
            } else {
                $this->outputError("Unknown command or operation.");
            }
        }
    }

    /**
     * @param $error
     */
    public function outputSuccess($error) {
        echo  "\n" . static::ESCAPE_CODE_GREEN . $error . static::ESCAPE_CODE_NO_COLOR  . "\n\n";
    }
    /**
     * @param $info
     */
    public function outputInfo($info) {
        echo  "\n" . static::ESCAPE_CODE_LIGHT_BLUE . $info . static::ESCAPE_CODE_NO_COLOR  . "\n\n";
    }

    /**
     * @param $error
     */
    public function outputError($error) {
        echo  "\n" . static::ESCAPE_CODE_RED . $error . static::ESCAPE_CODE_NO_COLOR  . "\n\n";
    }
}