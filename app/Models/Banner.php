<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cache;

class Banner extends Model
{
    use HasFactory;

    public static $_tree = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'banner';
    }



}
