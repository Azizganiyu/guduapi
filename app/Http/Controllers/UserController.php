<?php

namespace App\Http\Controllers;

use App\Http\Requests\createUser;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(){
        $data = User::paginate(20);
        return response()->json(['data' => $data, 'message' => 'Users Retreived'], 200);
    }

    public function register(createUser $request){
        $user = new User;
        $user->email = $request->email;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->photo_url = $request->photo_url;
        $user->role = 4;
        $user->status = true;
        $user->password = bcrypt($request->password);

        if(!$user->save()){
            return response()->json(['message' => 'Error Creating User'], 500);
        }

        return response()->json(['message' => 'User successfully created'], 201);
    }

    public function block(Request $request, User $user = null){
        if($user){
            $user->update(['status' => 0]);
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $user = User::find($id);
                $user->update(['status' => 0]);
            }
        }
        return response()->json(['message' => 'User(s) successfull blocked'], 200);
    }

    public function unblock(Request $request, User $user = null){
        if($user){
            $user->update(['status' => 1]);
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $user = User::find($id);
                $user->update(['status' => 1]);
            }
        }
        return response()->json(['message' => 'User(s) successfull unblocked'], 200);
    }

    public function delete(Request $request, User $user = null){
        if($user){
            $user->delete();
        }
        elseif($request->ids){
            foreach($request->ids as $id){
                $user = User::find($id);
                $user->delete();
            }
        }
        return response()->json(['message' => 'User(s) successfull deleted'], 200);
    }
}
