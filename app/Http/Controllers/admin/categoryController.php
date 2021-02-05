<?php

namespace App\Http\Controllers\admin;
use App\category;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\categoryResource;
use App\Http\Resources\subcategoryResource;
use App\Http\Controllers\Controller;

class categoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index()
    {
        return categoryResource::collection(category::latest()->get());
    }
    public function store(Request $request)
    {
        $slug= trim(preg_replace("/[^a-z0-9_\s\-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $request['name']), '-');
        $slug=preg_replace('/\s+/', '-', $slug);
        $category=category::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'user_id' => 1,
            'slug' =>$slug
        ]);
        return response()->json(new categoryResource($category), 200);
    }
    public function update(Request $request,$id)
    {
        $category=category::findOrFail($id);
        $slug= trim(preg_replace("/[^a-z0-9_\s\-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $request['name']), '-');
        $slug=preg_replace('/\s+/', '-', $slug);
        $category->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'user_id' => 1,
            'slug' =>$slug
        ]);
        return response()->json(new categoryResource($category), 200);
    }
    public function destroy($id)
    {
        category::findOrFail($id)->delete();

        return response()->json('success', 200);
    }

    public function show($id)
    {
        category::findOrFail($id);

        return response()->json(new categoryResource($category) . new subcategoryResource($category->subcategories) , 200);
    }


}
