<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;

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

    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {

            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }
}
