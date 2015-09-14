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

function  sort_users_by($column, $body)
{
    $direction = (Input::get('direction') == 'asc') ? 'desc' : 'asc';
    $link = link_to_route('admin.searchUsers', $body, ['sortBy' => $column, 'direction' => $direction]);
    $icon = '';
    if(Input::get('sortBy') == $column) {
        $icon =  '<i class="fa fa-sort-' . e(Input::get('direction')) . '"></i>';
    }
    return $link . $icon;

}

function getSortComponents($sort)
{
    $sortArray = array_keys(Config::get('sort'));

   if( ! in_array($sort, $sortArray)) {
        $sort = $sortArray[0];
   }

   return explode('-', $sort);
}