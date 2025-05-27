<?php

if (!function_exists('calculateBMI')) {
    function calculateBMI($weight, $height)
    {
        $heightInMeters = $height / 100;
        return $weight / ($heightInMeters * $heightInMeters);
    }
}

if (!function_exists('classifyBMI')) {
    function classifyBMI($bmi)
    {
        if ($bmi < 18.5) {
            return "Underweight";
        } elseif ($bmi < 24.9) {
            return "Normal weight";
        } elseif ($bmi < 29.9) {
            return "Overweight";
        } else {
            return "Obese";
        }
    }
}
