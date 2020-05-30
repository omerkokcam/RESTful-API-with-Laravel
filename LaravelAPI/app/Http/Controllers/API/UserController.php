<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();
        $user = new User();
        $user->name = $input['name'];
        $user->email = $input["email"];
        $user->email_verified_at = now();
        $user->password = bcrypt($input["password"]);
        $user->remember_token = Str::random(10);
        $user -> save();
        return response()->json([
            "data" => $user,
            "message" => "User created."
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if($user)
            return response($user,200);
        else
            return response(["message" => "User not found"],404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $input = $request->all();
        if($user) {
            $user->update($input);
            return response(["message" => "User is updated."],200) ;;
        }
        else
            return response(["message" => "User not found"],404) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user){
            $user->delete();
            return response(["message" => "User is deleted."],200);
        }
        else{
            return response(["message" => "User is not found"],404) ;
        }
    }
    public function custom(){

//        $user2 = User::find(2);
//        return new UserResource($user2);

        $users = User::all();
//        return UserResource::collection($users);
//        return new UserCollection($users);
        return UserResource::collection($users)->additional([
           'meta' => $users->count(),
        ]);

    }
}
