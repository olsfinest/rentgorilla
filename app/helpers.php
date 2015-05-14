<?php

function nullIfEmpty($string) {
    $string = trim($string);
    return empty($string) ? null : $string;
}

function getCity($location)
{
    $segments = explode('-', $location);
    array_pop($segments);
    return ucwords(implode(' ' , $segments));

}

function getProvince($location)
{
    $segments = explode('-', $location);
    $length = count($segments);
    return mb_strtoupper($segments[$length - 1]);
}

function getCityAndProvince($location)
{
    $city = getCity($location);
    $province = getProvince($location);
    return $city . ', ' .  $province;
}

function getNoPhoto($size)
{
    return "/img/no-photo/{$size}-no-photo-icon.jpg";
}