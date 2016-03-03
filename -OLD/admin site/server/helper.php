<?php

// Formats a number into cash
function formatCash($cash){
    $input = (String)$cash;
    // Number of digits - 1 / 3 = number of commas
    $numCommas = floor((strlen($input)-1)/3);
    if ($numCommas == 0){
        $formattedCash = "$" . $input;
        return $formattedCash;
        die();
    } else {
        $formattedCash = $input;
        for ($i=1;$i<=$numCommas; $i++){
            $pos = 3 * $i + ($i - 1);
            $front = substr($formattedCash,0,(strlen($formattedCash)-$pos));
            $back = substr($formattedCash,(strlen($formattedCash)-$pos));
            $new = $front . "," . $back;
            $formattedCash = $new;
        }
        $formattedCash = "$" . $formattedCash;
        return $formattedCash;
    }
}

// Formats a number to add ','' between hundreds
function formatNumber($number){
    $input = (String)$number;
    $numCommas = floor((strlen($input)-1)/3);
    if ($numCommas == 0){
        $formattedNum = $input;
        return $formattedNum;
        die();
    } else {
        $formattedNum = $input;
        for ($i=1;$i<=$numCommas; $i++){
            $pos = 3 * $i + ($i - 1);
            $front = substr($formattedNum,0,(strlen($formattedNum)-$pos));
            $back = substr($formattedNum,(strlen($formattedNum)-$pos));
            $new = $front . "," . $back;
            $formattedNum = $new;
        }
        return $formattedNum;
    }
}

// Formats the altislife playtime hours to actual hours
function playtimeToRealtime($timeInput, $displayType="short"){
    $timeArray = explode(".",$timeInput);
    $hours = $timeArray[0];
    $mins = 0;
    
    if (count($timeArray) > 1){
        $mins = $timeArray[1];
        
        if ($mins == "25"){
            $mins = "15";
        } elseif ($mins == "5"){
            $mins = "30";
        } elseif ($mins == "75"){
            $mins = "45";
        }
    }
    
    if ($displayType == "long"){
        return $hours . " hours, " . $mins . " minutes";
    } else {
        return $hours . "h, " . $mins . "m";
    }
}


?>