<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function scopeTrending($query, $take = 3)
    {
        return $query->orderBy('reads', 'desc')->take($take);
    }

    public static function popular($take = 3)
    {
        return self::trending($take)->get();
    }
}
