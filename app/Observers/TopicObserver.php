<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    //生成话题摘录使用模型监控器在话题创建前写进数据库
    public function saving(Topic $topic)
    {
       //防止XSS攻击
       $topic->body = clean($topic->body, 'user_topic_body');
       $topic->excerpt = make_excerpt($topic->body);
    }
}
