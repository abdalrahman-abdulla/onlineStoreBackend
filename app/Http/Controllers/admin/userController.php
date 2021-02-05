<?php

namespace App\Http\Controllers\admin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\userResource;
use App\Http\Controllers\Controller;

class userController extends Controller
{
    public function index()
    {
        return userResource::collection(User::all());
    }
    public function store(Request $request)
    {
        $user=User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
        ]);
        return response()->json(new userResource($user), 200);
    }
    public function update(Request $request,$id)
    {
        $validator=$this->validate($request , [
            'name'=>'required',
            "email"=>"required|email|max:128|unique:users,email,".$request->id.",id",
            "phone"=>"required|digits:11|unique:users,phone,".$request->id.",id",
            "password"=>"sometimes|string|min:8",
        ],[
            'required' => 'هذا الحقل مطلوب',
            'email.unique' => " البريد الالكتروني مستخدم مسبقا",
            'phone.unique' => "  رقم الهاتف مستخدم مسبقا",
        ]);
        $userData=$request->all();
        if($request->password && !empty($request->password)){
            $userData['password']=Hash::make($request->password);
        }
        if($id='me'){
            $user = User::findOrFail(auth()->user()->id);
        } else {
            $user=User::findOrFail($id);
        }
        $user->update($userData);
        return response()->json(new userResource($user), 200);
    }
}
