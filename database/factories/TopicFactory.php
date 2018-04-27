<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {

  //随机生成小段落
  $sentence = $faker->sentence();
  //随机获取一个月之内的时间
  $updated_at = $faker->dateTimeThisMonth();
  //创建时间不能晚于修改时间
  $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
         'title' => $sentence,
         'body' => $faker->text(),
         'excerpt' => $sentence,
         'created_at' => $created_at,
         'updated_at' => $updated_at,      
    ];
});
