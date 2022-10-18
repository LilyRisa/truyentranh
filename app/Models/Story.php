<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = 'story';
    }

    public function getThumbnailAttribute()
    {
        return \Config::get('app.url').$this->attributes['thumbnail'];
    }

    public function chapter(){
        return $this->hasMany(Chapter::class, 'story_id','id');
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'story_category', 'story_id', 'category_id');
    }
    public function tags(){
        return $this->belongsToMany(Tag::class, 'story_tags', 'story_id', 'tags_id');
    }
}
