<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\BuilderModel\ChapterSort;
use Cache;

class Story extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = 'story';
    }

    public function newEloquentBuilder($query)
    {
        return new ChapterSort($query);
    }

    public function getChapterAttribute()
    {
        $getNumberFromString = function ($string){
            $int = (int) filter_var($string, FILTER_SANITIZE_NUMBER_INT);
            if($int < 0){
                return $int*-1;
            }
            return $int;
        };
        
        $data = $this->relations['chapter'];
        $data = $data->mapWithKeys(function($item) use ($getNumberFromString){
            return [$getNumberFromString($item->title) => $item];
        });
        $data = $data->sortKeysUsing(function($a,$b){
            if ($a==$b) return 0;
            return ($a<$b)?1:-1;
        });
        return $data;
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

    static function getStorys($params) {
        $key_cache = md5(serialize($params));
        if(Cache::has($key_cache)){
            return Cache::get($key_cache);
        }
        extract($params);

        $orderby = 'created_at';

        if (isset($category_id)) {
            $data_id = Category::listItemChild($category_id,'id');
            $data = new self;
            $id = [$category_id];
            foreach($data_id as $T){
                $id[] = $T->id;
            }
            $data = $data->select('story.*', 'story_category.story_id', 'story_category.category_id','story_category.is_primary')->Join('story_category', 'story_category.story_id', '=', 'story.id');
            if(!empty($id)){
                $data = $data->whereIn('story_category.category_id', $id);
            }else{
                $data = $data->where('story_category.category_id', $category_id);
            }
            if (!empty($only_primary_category)) {
                $data = $data->where('story_category.is_primary', 1);
            }
        }
        if(isset($order_by)){
            $orderby = $order_by;
        }

        if(isset($title)){
            $data = $data->where('story.title','like', "%$title%");
        }

        if(isset($status)){
            $data = $data->where('story.is_update', $status);
        }
        
        if (isset($tag_id)) {
            $data = $data->select('story.*', 'story_tags.story_id', 'story_tags.tag_id')->Join('story_tags', 'story_tags.story_id', '=', 'story.id');
            $data = $data->where('story_tags.tag_id', $tag_id);
        }
        if(isset($chapter) && $chapter){
            $data = $data->with('chapter');
        }

        if (isset($info_category)) {
            $data = $data->with(['categories' => function($q){
                return $q->where('is_primary', 1);
            }]);
        }

        if (isset($get_category)) {
            $data = $data->with('categories');
        }
        if(isset($exclude)){
            $data = $data->whereNotIn('story.id', $exclude);
        }
        $offset = $offset ?? 0;
        $limit = $limit ?? 10;

        $data = $data->orderBy('story.'.$orderby, 'desc')
            ->offset($offset)
            ->limit($limit)
            ->groupBy('story.id')
            ->get();
        Cache::set($key_cache, $data, now()->addHours(12));
        return $data;
    }

    static function getCount($params) {
        $key_cache = md5(serialize($params).'count');
        if(Cache::has($key_cache)){
            return Cache::get($key_cache);
        }
        $data = new self;
        extract($params);

        if (isset($category_id)) {
            $data_id = Category::listItemChild($category_id,'id');
            $id = [$category_id];
            foreach($data_id as $T){
                $id[] = $T->id;
            }
            $data = $data->join('story_category', 'story_category.story_id', '=', 'story.id');
            if(!empty($id)){
                $data = $data->whereIn('story_category.category_id', $id);
            }else{
                $data = $data->where('story_category.category_id', $category_id);
            }
            
            if (!empty($only_primary_category)) {
                $data = $data->where('story_category.is_primary', 1);
            }
        }

        if (isset($tag_id)) {
            $data = $data->select('story.*', 'story_tags.story_id', 'story_tags.tag_id')->Join('story_tags', 'story_tags.story_id', '=', 'story.id');
            $data = $data->where('story_tags.tag_id', $tag_id);
        }
        
        if(isset($exclude)){
            $data = $data->whereNotIn('story.id', $exclude);
        }
        $count_data = $data->groupBy('story.id')->get()->count();
        Cache::set($key_cache, $count_data, now()->addHours(12));

        return $count_data;
    }
}
