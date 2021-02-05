<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [
        'name', 'description','category_id','slug'
    ];
    public function category()
    {
        return $this->belongsTo('App\category');
    }
    public function items()
    {
        return $this->hasMany('App\Item');
    }
}
