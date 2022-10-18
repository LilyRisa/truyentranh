<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use Cache;

class Category extends Model
{
    use HasFactory;

    public static $_tree = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'category';
    }

    static function getTree(){
        $key_cache = 'category__getTree';

        if(Cache::has($key_cache)){
            return Cache::get($key_cache);
        }
        self::_getTree();
        Cache::set('category__getTree', self::$_tree , now()->addHours(12));
        return self::$_tree;
    }
    public function post(){
        return $this->belongsToMany(Post::class, 'category_post', 'category_id', 'post_id');
    }

    public function story(){
        return $this->belongsToMany(Story::class, 'story_category', 'category_id', 'story_id');
    }

    private static function _getTree($parent_id = null, $prefix_title = ''){
        $listChild = parent::where('parent_id', $parent_id)->get();
        if (!empty($listChild)) foreach ($listChild as $item) {
            self::$_tree[$item->id] = [
                'id' => $item->id,
                'title' => $prefix_title.$item->title,
                'parent_id' => $item->parent_id,
                'slug' => $item->slug,
                'count' => self::CountPostchildren($item->id),
            ];
            self::_getTree($item->id, $prefix_title.'---');
        }
    }

    public static function CountPostchildren($id){
        $countPost = 0;
        $listCateChild = self::ChildRecursive($id);
        $list_id_category = [];

        foreach($listCateChild as $item){
            $list_id_category[] = $item->id;
        }
        $countPost = Post::whereHas('Categories', function($query) use ($list_id_category){
            $query->whereIn('category_post.category_id', $list_id_category);
        })->get()->count();

        return $countPost;
    }

    public static function listItemChild($id,...$select){
        $key_cache = md5($id.'listItemChild'.json_encode($select));
        if(Cache::has($key_cache)){
            return Cache::get($key_cache);
        }
        $data = self::select(...$select)->where('parent_id', $id)->get();
        Cache::set($key_cache, $data, now()->addHours(12));
        return $data;
    }

    private static function ChildRecursive($id){
        $ls = [];
        $cate = parent::with('children')->where('id', $id)->first();
        $ls[] = $cate;
        if($cate->children->count() == 0) return $ls;
        foreach($cate->children as $item){
            $ls = array_merge($ls,self::ChildRecursive($item->id));
        }
        return $ls;
    }

    public function children(){
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id' );
    }
    public function childrenRecursive() {
        return $this->children()->with('childrenRecursive');
    }
    public function parentRecursive() {
        return $this->parent()->with('parentRecursive');
    }
}
