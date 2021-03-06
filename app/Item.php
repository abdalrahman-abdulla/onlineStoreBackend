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
        return $this->belongsToMany('App\order','order_item')->withTimestamps()->withPivot(['quantity']);
    }
    public function deleteImageFromGoogleDrive()
    {
        $files = collect(\Storage::disk('google')->listContents('/', false));
        foreach($files as $file) {
            if ($file['filename'].'.'.$file['extension'] == $this->image) {
                \Storage::disk('google')->deleteDirectory($file['path']);
                break;
            }
        }
        return 'done';
    }

    public function getImageList()
    {
        return collect(\Storage::disk('google')->listContents('/', false));
    }

    public function getImageFromGoogleDrive()
    {
        $files = collect(\Storage::disk('google')->listContents('/', false));
        foreach($files as $file) {
            if ($file['filename'].'.'.$file['extension'] == $this->image) {
                return 'https://drive.google.com/thumbnail?id=' . $file['path'];
                break;
            }
        }
        return false;
    }

}
