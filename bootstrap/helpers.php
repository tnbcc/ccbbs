<?php

/*
 *通过单前路径生成class
 */
function route_class()
{
   return str_replace('.','-',Route::currentRouteName());
}
