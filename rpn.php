<?php

class RPN
{

    public static $pattern;

    /**
     * Calculate
     * Take a pattern and calculate the results.
     * @param $pattern
     * @example RPN::Calculate("3 2 -")
     * @return int
     */

    public static function Calculate($pattern)
    {
        // Could have used a simple getter here...
        self::$pattern = $pattern;
        $numbers = array();

        $pattern_array = explode(' ', str_replace("  ", " ", trim(self::$pattern)));
        $acceptable_operators = array("+", "-", "/", "*");
        $calculationResult='';

        if (count($pattern_array) == 1)
            return 'RPN::Calculate() requires more than 2 characters.';
        elseif ( !in_array(end($pattern_array), $acceptable_operators) )
            return 'RPN::Calculate() requires the last character to be an operator';

        foreach ($pattern_array as $value) {
            if (is_numeric($value)) {
                $numbers[] = $value;
            } elseif (in_array($value, $acceptable_operators)) {
                $first_number = array_pop($numbers);
                $second_number = array_pop($numbers);

                switch ($value) {
                    case '+':
                        $calculationResult = $second_number + $first_number;
                        break;
                    case '-':
                        $calculationResult = $second_number - $first_number;
                        break;
                    case '/':
                        $calculationResult = $second_number / $first_number;
                        break;
                    case '*':
                        $calculationResult = $second_number * $first_number;
                        break;
                }
                array_push($numbers, $calculationResult);
            } else {
                return 'RPN::Calculate() found an invalid character of '.$value . '. This character is not allowed.';
            }
        }
        return $calculationResult;
    }
}

echo '<h1>Test Cases</h1>';
echo '<P><b>Return</b>: '.RPN::Calculate("5") . '<br /><b>Pattern</b>: ' . RPN::$pattern; // Throws error
echo '<P><b>Return</b>: '.RPN::Calculate("3 | 2 +") . '<br /><b>Pattern</b>: ' . RPN::$pattern; // Throws error
echo '<P><b>Return</b>: '.RPN::Calculate("1 5") . '<br /><b>Pattern</b>: ' . RPN::$pattern; // Throws error
echo '<P><b>Return</b>: '.RPN::Calculate("3 2 -") . '<br /><b>Pattern</b>: ' . RPN::$pattern; //1
echo '<P><b>Return</b>: '.RPN::Calculate("3 11 5 + -") . '<br /><b>Pattern</b>: ' . RPN::$pattern; //-13
echo '<P><b>Return</b>: '.RPN::Calculate("3 11 + 5 -") . '<br /><b>Pattern</b>: ' . RPN::$pattern; //9
echo '<P><b>Return</b>: '.RPN::Calculate("2 3 11 + 5 - *") . '<br /><b>Pattern</b>: ' . RPN::$pattern; //18
echo '<P><b>Return</b>: '.RPN::Calculate("3 2 * 11 - ") . '<br /><b>Pattern</b>: ' . RPN::$pattern;//-5
echo '<P><b>Return</b>: '.RPN::Calculate("2 1 12 3 / - + ") . '<br /><b>Pattern</b>: ' . RPN::$pattern; //-1
?>