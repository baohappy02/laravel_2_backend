<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;    
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Validator;
use App\Http\Resources\User as UserResource;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return
            $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
    }

       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexWithTrashed()
    {
        $users = User::withTrashed()->get();
        return
            $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
    }


       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOnlyTrashed()
    {
        $users = User::onlyTrashed()->get();
        return
            $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::find($id);
        // $users = User::where('id', '$id');

        if (is_null($users)) {
            return $this->sendError('Users not found.');
        }

        return $this->sendResponse(new UserResource($users), 'Users retrieved successfully.');
    }


     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restoreById($id)
    {
        // $users = User::withTrashed()->where('id', $id)->restore();
        $users = User::withTrashed()
        ->where('id', $id)->restore();
        
        // print_r($id);die;
        if (is_null($users)) {
            return $this->sendError('Users not found.');
        }
        // $user->restore();
        return $this->sendResponse(new UserResource($users), 'User restored successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataRequire = $request->only(
            'first_name',
            'last_name', 
            'phone', 
            'email'
        ) + [
            'password' => Hash::make($request->input('password'))
        ];

        $user = User::create($dataRequire);

        if(!$user){
            return $this->sendError('Validation Error : ', $validator->errors());       
        }

            return $this->sendResponse(new UserResource($user), 'User created successfully.');
    }


    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $dataRequest = $request->only('first_name', 'last_name', 'phone');

        if($user != null){
            
            $user->update($dataRequest);
            return $this->sendResponse(new UserResource($user), 'User updated successfully.');
        }

        return $this->sendError('User not found');       
        
    }

    public function delete($id) {

        $user = User::find($id);
       

        if ($user != null) {
            $user->delete();
            return $this->sendResponse(new UserResource($user), 'User deleted successfully.');
        }
        return $this->sendError('User not found ');      

    }

    // public function delete($id) {
    //     $user = User::find($id);
       
    //     if($user != null){
    //         $user->is_active = false;
    //         $user->save();
    //         return $this->sendResponse(new UserResource($user), 'User deleted successfully.');
    //     }

    //     return $this->sendError('User not found');       
    // }
}
