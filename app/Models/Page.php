<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'crawler', 'user_id', 'status'];
    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = 'page';
    }

    // public function getContentAttribute($value)
    // {
    //     return short_code($value);
    // }
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
