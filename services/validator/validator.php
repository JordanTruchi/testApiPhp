<?php

function isEmpty($value) {
    if($value === "" || $value === null || sizeOf($value) === 0) return false;
    return true;
}

?>