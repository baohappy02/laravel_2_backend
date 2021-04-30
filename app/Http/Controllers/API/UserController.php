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
        // $users = User::all();
        $users = User::where('is_deleted', '!=', '1')->paginate(5);

        return
            $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');

        // dd(UserResource::collection($users));
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

        if (is_null($users)) {
            return $this->sendError('Users not found.');
        }

        return $this->sendResponse(new UserResource($users), 'Users retrieved successfully.');
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

        $dataRequest = $request->only('first_name', 'last_name', 'phone', 'email');

        $user->update($dataRequest);

        if(empty($user)){
            return $this->sendError('Validation Error : ', $validator->errors());       
        }

        return $this->sendResponse(new UserResource($user), 'User updated successfully.');
    }

    public function delete($id) {
        $user = User::find($id);

        $dataInput = [
            'is_deleted' => 1,
        ]; 

        $user->update($dataInput);

        if(empty($user)){
            return $this->sendError('Validation Error : ', $validator->errors());       
        }

        return $this->sendResponse(new UserResource($user), 'User deleted successfully.');


    }

}
