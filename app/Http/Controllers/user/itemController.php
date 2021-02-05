<?php

namespace App\Http\Controllers\user;
use App\Http\Resources\itemResource;
use App\Http\Resources\subcategoryResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\Subcategory;
use App\category;
use App\Http\Resources\userCategoryResourrce;
class itemController extends Controller
{
    public function index($slug)
    {
        try {
            $slug= trim(preg_replace("/[^a-z0-9_\s\-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "",$slug), '-');
            $slug=preg_replace('/\s+/', '-', $slug);
            $sub=Subcategory::where('slug',$slug)->first();
            return [new subcategoryResource($sub),itemResource::collection($sub->items)];
        } catch (\Throwable $th) {
            return itemResource::collection(
                Item::where(function ($query) use($slug) {
                    $query->where('name', 'like', '%' . $slug . '%')
                        ->orWhere('description', 'like', '%' . $slug . '%');
                })
                ->get());
        }
    }

    public function categorypage($slug)
    {
        return $slug;
        $subcategory=Subcategory::where('slug',$slug)->first();
        return  itemResource::collection($subcategory->items);
    }
    public function item($slug)
    {
        return  new itemResource(Item::where('slug',$slug)->first());
    }

    public function categories()
    {
        return userCategoryResourrce::collection(category::all());

    }
    public function homedata(Request $request)
    {
        return[
            'items' => itemResource::collection(Item::orderBy('id', 'desc')->take(6)->get()) ,
            'items2' => itemResource::collection(Item::take(6)->get()) ,
            'subcategories' => subcategoryResource::collection(Subcategory::orderBy('id', 'desc')->take(10)->get())
        ];
    }
}
