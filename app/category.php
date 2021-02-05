<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $fillable = [
        'name', 'description','user_id','slug'
    ];

    public function subcategories()
    {
        return $this->hasMany('App\Subcategory');
    }

}
