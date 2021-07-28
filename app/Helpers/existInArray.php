<?php

function existInArray($array, $string)
{
    foreach ($array as $key => $value) {
        if ($value === $string) {
            return true;
        };
    }
    return false;
}
