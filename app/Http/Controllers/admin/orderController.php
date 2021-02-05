<?php

namespace App\Http\Controllers\admin;
use App\Http\Resources\orderItemResource;
use App\Http\Resources\ordersResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\order;
class orderController extends Controller
{
    public function index(Request $request)
    {
        $order=order::all();
        return ordersResource::collection($order);
    }

    public function destroy($id)
    {
        order::findOrFail($id)->delete();

        return response()->json('success', 200);
    }

    public function show($id)
    {
        $order=order::findOrFail($id);

        return response()->json(new orderItemResource($order), 200);
    }
}
