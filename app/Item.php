<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $fillable = [
        'name', 'description','subcategory_id','image','price','slug','quantity'
    ];

    public function subcategory()
    {
        return $this->belongsTo('App\Subcategory');
    }
    public function orders()
    {

        return $this->belongsToMany('App\order','order_item')->withTimestamps()->withPivot(['quantity']);;

    }
}
