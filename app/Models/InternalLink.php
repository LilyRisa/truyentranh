<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalLink extends Model
{
    use HasFactory;
    protected $table = 'internal_link';

    public static function getSetting(){
        return static::whereIn('id',[1,2])->get();
    }

    public static function getInterlink(){
        return static::whereNotIn('id',[1,2])->get();
    }
}
