<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\DB;
// use App\Models\Post;

class ShortCode extends Model
{
    use HasFactory;
    protected $fillable = ['slug', 'content', 'crawler', 'status'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = 'shortcode';
    }

}