<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

//一个话题属于一个分类属于一对一的关系

public function category()
{
      return $this->belongsTo(Category::class);
}

//一个话题属于一个作者属于一对一的关系
public function user()
{
    return $this->belongsTo(User::class);
}

public function scopeWithOrder($query,$order)
{
    //不同的排序使用不同的读取逻辑
    switch ($order) {
      case 'recent':
        $query->recent();
        break;

      default:
        $query->recentReplied();
        break;
    }
    //防止N+1的问题
    return $query->with('user','category');
}

   public function scopeRecentReplied($query)
   {
      return $query->orderBy('updated_at','desc');
   }

   public function scopeRecent($query)
   {
      return $query->orderBy('created_at','desc');
   }
}
