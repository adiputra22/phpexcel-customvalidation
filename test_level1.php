<?php

function check($paramStr, $userIndex) {
    $msg = "";

    if( $paramStr != "" ) {
        
        $arrayParamStr = str_split($paramStr);
        
        if($arrayParamStr[$userIndex] == "(") {
            
            $listOpenTag = [];
            $listCloseTag = [];
            
            foreach( $arrayParamStr as $key=>$value ) {
                
                if($value == "(") {
                    array_push($listOpenTag, $key);
                }

                if($value == ")") {
                    array_push($listCloseTag, $key);
                }

            }
            
            arsort($listOpenTag);
            
            $gold_value = "";

            foreach($listCloseTag as $close_key => $close_value) {
                $ketemu = 0;
                foreach($listOpenTag as $open_key => $open_value) {
                    if( $close_value > $open_value ) {
                        
                        if($open_value == $userIndex) {
                            $gold_value = $close_value;
                            $ketemu = 1;
                            break;
                        }else {
                            unset($listOpenTag[$open_key]);
                            break;
                        }

                    }
                }

                if($ketemu == 1) {
                    break;
                }
                
            }

            $msg = $gold_value;

        } else {
            $msg = "Parameter 2 not valid open tag";
        }

    } else {
        $msg = "Parameter 1 empty string";
        // $paramStr empty
    }

    return $msg;
}

$paramStr = "a (b c (d e (f) g) h) i (j k)";
$userIndex = 2;

$result = check($paramStr, $userIndex);
print($result);