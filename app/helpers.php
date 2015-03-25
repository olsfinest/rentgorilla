<?php

function nullIfEmpty($string) {
    return empty(trim($string)) ? null : $string;
}