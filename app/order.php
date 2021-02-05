<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $fillable = [
        'name', 'phone','location','total_price','user_id','shipping'
    ];
    public function items()
    {

            return $this->belongsToMany('App\Item','order_item')->withTimestamps()->withPivot(['quantity']);;

    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
