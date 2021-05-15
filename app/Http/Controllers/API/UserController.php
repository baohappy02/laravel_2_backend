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
        // $users = User::where('is_deleted', '!=', '1')->paginate(5);

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
        // $users = User::where('id', '$id');

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
        // $dataRequire = $request->only(
        //     'first_name',
        //     'last_name', 
        //     'phone', 
        //     'email'
        // ) + [
        //     'password' => Hash::make($request->input('password'))
        // ];
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'position' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        // $user = User::create($dataRequire);

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        if(!$user){
            return $this->sendError('Validation Error : ', $validator->errors());       
        }

            return $this->sendResponse(new UserResource($user), 'User created successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        // $dataRequest = $request->only('first_name', 'last_name', 'phone', 'email');
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

}
