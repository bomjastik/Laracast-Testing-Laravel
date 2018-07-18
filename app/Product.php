<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'price'
    ];

    public function name()
    {
        return $this->name;
    }

    public function price()
    {
        return $this->price;
    }
}
