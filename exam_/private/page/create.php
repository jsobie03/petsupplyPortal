<?php
    function calculateSum($a = []){
        return array_sum($a);
    }

$arrNumbers = [1,2,3,4,5];
$getSum = calculateSum($arrNumbers);
echo $getSum();
?>