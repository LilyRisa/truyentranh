<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_Category extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'post_id', 'is_primary'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = 'category_post';
    }
}
