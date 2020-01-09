<?php

function reverseDate6($date) {
    return substr($date, 6, 2)."-".substr($date, 3, 2)."-".substr($date, 0, 2);
}

function reverseDate8($date) {
    return substr($date, 8, 2)."-".substr($date, 5, 2)."-".substr($date, 0, 4);
}

function applyUrlImgDir($url) {
    return 'static/img/'.$url;
}

?>