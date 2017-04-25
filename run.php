<?php

require_once "./vendor/autoload.php";

$calculator = ReversePolishCalculator\CalculatorBuilder::buildCalculator();
(new ReversePolishCalculator\ConsoleApp)->run($calculator);

