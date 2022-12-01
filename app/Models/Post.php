<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Rate;
use Cache;

class Post extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = 'post';
    }

    // ghi đè thuộc tính mặc định

    public function getDescAttribute()
    {
        if(!empty($this->attributes['description'])){
            return get_limit_content($this->attributes['description'], 250);
        }

        if(!empty($this->attributes['meta_description'])){
            return get_limit_content($this->attributes['meta_description'], 250);
        }

        $value = get_limit_content($this->attributes['content'], 250);
        return $value;
        
    }

    // public function getContentAttribute($value)
    // {
    //     return short_code($value);
    // }

    public function rate()
    {
        return $this->hasMany(Rate::class);
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_primary_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'category_post', 'post_id', 'category_id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'tag_post', 'post_id', 'tag_id');
    }

    static function getPosts($params) {
        $key_cache = md5(serialize($params));
        if(Cache::has($key_cache)){
            return Cache::get($key_cache);
        }
        extract($params);
        $data = self::where([
            'status' => 1,
            ['displayed_time', '<=', Post::raw('NOW()')]
        ]);

        if (isset($category_id)) {
            $data_id = Category::listItemChild($category_id,'id');
            $id = [$category_id];
            foreach($data_id as $T){
                $id[] = $T->id;
            }
            $data = $data->select('post.*', 'category_post.post_id', 'category_post.category_id','category_post.is_primary')->Join('category_post', 'category_post.post_id', '=', 'post.id');
            if(!empty($id)){
                $data = $data->whereIn('category_post.category_id', $id);
            }else{
                $data = $data->where('category_post.category_id', $category_id);
            }
            if (!empty($only_primary_category)) {
                $data = $data->where('category_post.is_primary', 1);
            }
        }

        if (isset($tag_id)) {
            $data = $data->select('post.*', 'tag_post.post_id', 'tag_post.tag_id')->Join('tag_post', 'tag_post.post_id', '=', 'post.id');
            $data = $data->where('tag_post.tag_id', $tag_id);
        }

        if (isset($info_category)) {
            $data = $data->with('category');
        }

        if (isset($get_category)) {
            $data = $data->with('categories');
        }
        if (isset($author)) {
            $data = $data->with('user');
        }

        if (isset($status)) {
            $data = $data->where($status);
        }

        if(isset($exclude)){
            $data = $data->whereNotIn('post.id', $exclude);
        }
        $offset = $offset ?? 0;
        $limit = $limit ?? 10;

        $data = $data->orderBy('post.displayed_time', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->groupBy('post.id')
            ->get();
        Cache::set($key_cache, $data, now()->addHours(12));
        return $data;
    }

    static function getCount($params) {
        $key_cache = md5(serialize($params).'count');
        if(Cache::has($key_cache)){
            return Cache::get($key_cache);
        }
        extract($params);
        $data = self::where([
            'status' => 1,
            ['displayed_time', '<=', Post::raw('NOW()')]
        ]);

        if (isset($category_id)) {
            $data_id = Category::listItemChild($category_id,'id');
            $id = [$category_id];
            foreach($data_id as $T){
                $id[] = $T->id;
            }
            $data = $data->join('category_post', 'category_post.post_id', '=', 'post.id');
            if(!empty($id)){
                $data = $data->whereIn('category_post.category_id', $id);
            }else{
                $data = $data->where('category_post.category_id', $category_id);
            }
            
            if (!empty($only_primary_category)) {
                $data = $data->where('category_post.is_primary', 1);
            }
        }

        if (isset($tag_id)) {
            $data = $data->select('post.*', 'tag_post.post_id', 'tag_post.tag_id')->Join('tag_post', 'tag_post.post_id', '=', 'post.id');
            $data = $data->where('tag_post.tag_id', $tag_id);
        }
        
        if(isset($exclude)){
            $data = $data->whereNotIn('post.id', $exclude);
        }
        $count_data = $data->groupBy('post.id')->get()->count();
        Cache::set($key_cache, $count_data, now()->addHours(12));

        return $count_data;
    }
}

