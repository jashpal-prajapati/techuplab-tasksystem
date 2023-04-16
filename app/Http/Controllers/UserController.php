<?php

/**
 * Controller
 * PHP version 8.2
 *
 * @category App\Http\Controllers
 * @package  Task System
 * @author   Jashpal <prajapati_jashpal18@yahoo.com>
 * @license  <prajapati_jashpal18@yahoo.com> N/A
 * @link     Jashpal <prajapati_jashpal18@yahoo.com>
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;

/**
 * Controller
 * PHP version 8.2
 *
 * @category App\Http\Controllers
 * @package  Task System
 * @author   Jashpal <prajapati_jashpal18@yahoo.com>
 * @license  <prajapati_jashpal18@yahoo.com> N/A
 * @link     Jashpal <prajapati_jashpal18@yahoo.com>
 */
class UserController extends Controller
{
    /**
     * User Registration
     *
     * @author Jashpal <prajapati_jashpal18@yahoo.com>
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if($validator->fails()) {
            $res = [
                'status' => false,
                'messages' => $validator->errors()
            ];
            return response()->json($res, 422);
        }

        $userData = $request->all();
        $userData['password'] = bcrypt($userData['password']);
        $user = User::create($userData);

        $data['status'] = false;
        $data['message'] = 'User not register succesfully !!'; 
        if($user) {
            $data['status'] = true;
            $data['message'] = 'User register succesfully !!';

            return response()->json($data, 201);
        }

        return response()->json($data, 400);
    }

    /**
     * User Login
     *
     * @author Jashpal <prajapati_jashpal18@yahoo.com>
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $res = [
            'status' => false,
            'data' => [],
            'message' => 'Invalid login !!'
        ];

        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
            $user = Auth::user();
            $data['token'] = $user->createToken('token')->plainTextToken;
            $data['name'] = $user->name;

            $res = [
                'status' => true,
                'data' => $data,
                'message' => 'User login successfully !!'
            ];

            return response()->json($res, 200);
        }

        return response()->json($res, 401);
    }
}
