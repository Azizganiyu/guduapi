<?php

namespace App\Http\Controllers;

use App\Http\Requests\createUser;
use App\Http\Requests\updateUser;
use App\Models\Address;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function getAddress(){
        $data = auth()->user()->address;
        return response()->json(['data' => $data, 'message' => 'Address Retreived'], 200);
    }

    public function saveAddress(Request $request)
    {

        $user_id = auth()->user()->id;

       Address::updateOrCreate(
            ['user_id' => $user_id],
            [
                'address' => $request->address,
                'state' => $request->state,
                'city' => $request->city,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
            ]
        );

        return response()->json(['message' => 'Address successfully saved'], 201);
    }

    public function updateUser(updateUser $request){
        $id = auth()->user()->id;
        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        if($user->save()){
             return response()->json(['message' => 'user successfully updated'], 200);
        }
        else{
            return response()->json(['message' => 'An error has occured, unable to update user'], 500);
        }
    }

    public function changePassword(Request $request){
        $request->validate([
            'password' => 'required',
            'new_password' => 'required',
            'confirm_new_password' => 'required',
        ]);

        $user = User::where('email', auth()->user()->email)->first();
        if ( ! Hash::check($request->password, $user->password, [])) {
            return response()->json([
                'message' => 'Invalid Password'
            ], 500);
        }

        if($request->new_password != $request->confirm_new_password){
            return response()->json(['message' => 'Password does not match'], 400);
        }

        $user->password = bcrypt($request->new_password);

        if(!$user->save()){
            return response()->json(['message' => 'Error changing password'], 500);
        }

        return response()->json(['message' => 'Password successfully changed!'], 200);
    }
}
