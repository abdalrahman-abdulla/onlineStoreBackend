<?php

namespace App\Http\Controllers\admin;
use App\category;
use App\Subcategory;
use Illuminate\Http\Request;
use App\Http\Resources\subcategoryResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\itemResource;

class subcategoryController extends Controller
{
    public function index(Request $request)
    {
       return !$request['category_id']?  subcategoryResource::collection(Subcategory::all()) :  subcategoryResource::collection(Subcategory::where('category_id',$request['category_id'])->get());

    }
    public function store(Request $request)
    {
        $slug= trim(preg_replace("/[^a-z0-9_\s\-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $request['name']), '-');
        $slug=preg_replace('/\s+/', '-', $slug);
        $category=category::findOrFail($request['category']);
        try {
            $subcategory=Subcategory::create([
                'name' => $request['name'],
                'description' => $request['description'],
                'category_id' => $category->id,
                'slug' =>$slug
            ]);
        } catch (\Throwable $th) {
            $subcategory=Subcategory::create([
                'name' => $request['name'],
                'description' => $request['description'],
                'category_id' => $category->id,
                'slug' =>$slug . time()
            ]);
        }
        return response()->json(new subcategoryResource($subcategory), 200);
    }
    public function update(Request $request,$id)
    {
        $Subcategory=Subcategory::findOrFail($request['id']);
        $slug= trim(preg_replace("/[^a-z0-9_\s\-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $request['name']), '-');
        $slug=preg_replace('/\s+/', '-', $slug);
        $subcategory=Subcategory::findOrFail($id);
        $subcategory->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'category_id' => $request['category'],
            'slug' =>$slug
        ]);
        return response()->json(new subcategoryResource($subcategory), 200);
    }

    public function destroy($id)
    {
        Subcategory::findOrFail($id)->delete();

        return response()->json('success', 200);
    }

    public function show($id)
    {
        $subcategory=Subcategory::findOrFail($id);
        $subcategory['items']=itemResource::collection($subcategory->items);
        return response()->json($subcategory ,202);
    }
}
