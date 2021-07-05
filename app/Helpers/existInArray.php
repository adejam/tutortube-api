<?php

function existInArray($array, $string)
{
    foreach ($array as $key => $value) {
        return $value === $string;
    }
}
