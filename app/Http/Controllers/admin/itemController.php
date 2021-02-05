<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\itemResource;
use App\Subcategory;
use App\Item;
use File;
class itemController extends Controller
{
    public function index(Request $request)
    {
       return !$request['subcategory_id'] ?  itemResource::collection(Item::latest()->get()) :  itemResource::collection(Item::where('subcategory_id',$request['subcategory_id'])->orderBy('id', 'DESC')->get());

    }

    public function store(Request $request)
    {

        $Subcategory=Subcategory::findOrFail($request['subcategory']);
        $slug= trim(preg_replace("/[^a-z0-9_\s\-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $request['name']), '-');
        $slug=preg_replace('/\s+/', '-', $slug);

        $name=$slug . time() . '.'. explode( '/' ,explode (':',substr($request->photo,0,strpos($request->photo,';')))[1])[1];
        $img=\Image::make($request->photo)->save(public_path("img\items\\").$name);
        $img->resize(400, 400, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });

        try {
            $item=Item::create([
                'name' => $request['name'],
                'description' => $request['description'],
                'image' => $name,
                'price' => $request['price'],
                'quantity' => $request['quantity'],
                'subcategory_id' => $Subcategory->id,
                'slug' => $slug,
            ]);
        } catch (\Throwable $th) {
            $item=Item::create([
                'name' => $request['name'],
                'description' => $request['description'],
                'image' => $name,
                'price' => $request['price'],
                'quantity' => $request['quantity'],
                'subcategory_id' => $Subcategory->id,
                'slug' => $slug . time(),
            ]);
        }


        return response()->json(new itemResource($item), 200);
    }

    public function update(Request $request,$id)
    {
        $item=Item::findOrFail($id);
        $Subcategory=Subcategory::findOrFail($request['subcategory']);
        $slug= trim(preg_replace("/[^a-z0-9_\s\-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $request['name']), '-');
        $slug=preg_replace('/\s+/', '-', $slug);
        $item->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'price' =>  $request['price'],
            'quantity' => $request['quantity'],
            'subcategory_id' => $request['subcategory'],
            'slug' => $slug,
        ]);
        if($request->photo){
            $name=$slug . time() . '.'. explode( '/' ,explode (':',substr($request->photo,0,strpos($request->photo,';')))[1])[1];
            $img=\Image::make($request->photo)->save(public_path("img\items\\").$name);
            $img->resize(400, 400, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            $item->image=$name;
            $item->save;
        }
        return response()->json(new itemResource($item), 200);
    }
    public function destroy($id)
    {
        $item=Item::findOrFail($id);
        File::delete(public_path("img\items\\").$item->image);
        $item->delete();

        return response()->json('success', 200);
    }



    public function savePhoto(Request $request)
    {
        if($request->photo)
        {
            $name= time() . '.'. explode( '/' ,explode (':',substr($request->photo,0,strpos($request->photo,';')))[1])[1];
            \Image::make($request->photo)->save(public_path("img\items\\").$name)->resize(600, 600);
        }
        return 'success';
    }
}
