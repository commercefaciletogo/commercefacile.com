<?php

function qs_url($path = null, $qs = array(), $secure = null)
{
    $url = app('url')->to($path, $secure);
    if (count($qs)){

        foreach($qs as $key => $value){
            $qs[$key] = sprintf('%s=%s',$key, urlencode($value));
        }
        $url = sprintf('%s?%s', $url, implode('&', $qs));
    }
    return $url;
}