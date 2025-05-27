<?php



function calculateBMI($weight, $height) {
    $heightInMeters = $height / 100;
    return $weight / ($heightInMeters * $heightInMeters);
}
function classifyBMI($bmi) {
    if ($bmi < 18.5) {
        return "Underweight";
    } elseif ($bmi < 24.9) {
        return "Normal weight";
    } elseif ($bmi < 29.9) {
        return "Overweight";
    } else {
        return "Overweight";
    }
}

$bmi = calculateBMI(45, 170); 
 echo classifyBMI($bmi);
