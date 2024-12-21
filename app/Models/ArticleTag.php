<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleTag extends Model
{
    protected $guarded = [];
    public static function get($articleId)
    {
        $result = [];
        $data = static::where('article_id', $articleId)->select(['tag_id'])->get();
        foreach($data as $one) {
            $tag = Tag::where('id', $one['tag_id'])->first();
            $result[] = $tag->id;
        }
        return $result;
    }
}
