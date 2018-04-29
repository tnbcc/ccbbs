<?php

/*
 *通过单前路径生成class
 */
function route_class()
{
   return str_replace('.','-',Route::currentRouteName());
}

//生成话题摘录 对文件的截取

function make_excerpt($value,$length = 200)
{
   $excerpt = trim(preg_replace('/\r\n|\r|\n+/',' ',strip_tags($value)));
   return str_limit($excerpt,$length);
}
