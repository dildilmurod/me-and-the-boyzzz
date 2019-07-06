<?php

namespace App\Http\Controllers;


use App\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeacherAuthController extends Controller
{
    public function __construct()
    {

        //$this->middleware('api-auth', ['except' => []]);

    }

    protected function get_token($identifier, $password){
        $http = new Client();
        $response = $http->post(url('oauth/token'), [ //forms token
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => 2,
                'client_secret' => '5SETOl4Z7wwYAtr7O0BclGg2vAudWe62J0apZ0Mv',
                'username' => $identifier,
                'password' => $password,
                'scope' => '',
                'theNewProvider'=>'api_teachers'
            ],
        ]);
        return $response;
    }

    //current function registers users
    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:6',
            'name' => 'required|min:6',
            'password' => 'required|min:6',
        ]);

        if (empty(Teacher::where('username', $request->username)->first())){
            $teacher = Teacher::firstOrNew(['username' => $request->username]); //checks whether it is new user with this email
            $teacher->username = $request->username;
            $teacher->name = $request->name;
//            $teacher->email = $request->email;

            $teacher->password = bcrypt($request->password); //password through bcrypt
            $teacher->save();

            $response = $this->get_token($request->username, $request->password);

            return response(
                [
                    'data' => json_decode((string)$response->getBody(), true),
                    'msg'=>'success'
                ],
                200);
        }
        else
            return response()->json(
                [
                    'data'=>'',
                    'msg'=>'Teacher with such username already exists'
                ],
                401);


    }
    //logins user
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:6',
            'password' => 'required|min:6'
        ]);

        $teacher = Teacher::where('username', $request->username)->first(); //gets user with email
        if (!$teacher) {
            //returns error if user does not exists
            return response()->json(
                [
                    'msg' => 'error',
                    'message' => 'Teacher not found. Check credentials'
                ],
                404);
        }
        if (Hash::check($request->password, $teacher->password)) { //checks passwords

            $response = $this->get_token($request->username, $request->password);

            return response([
                'data' => json_decode((string)$response->getBody(), true),
                'name'=> $teacher->username,
                'msg'=>'success'
            ],
                201);
        }
        return response()->json(
            [
                'msg' => 'error',
                'data' => 'Username or password is wrong. Check credentials'
            ],
            404);

    }



//    public function password_update(Request $request){
//        $this->validate($request, [
//            'phone' => 'required',
//            'password'=>'required',
//            'code' => 'required'
//        ]);
//
//        $user = User::where('phone', $request->phone)->first(); //gets user with email
//        if (!$user) {
//            //returns error if user does not exists
//            return response()->json(
//                [
//                    'status' => 'error',
//                    'message' => 'User not found. Check credentials'
//                ],
//                404);
//        }
//        if($user->code == $request->code){
//            $user->password = bcrypt($request->password);
//            $user->code = '';
//            $user->save();
//            $response = $this->get_token($user->email, $request->password);
//            return response(
//                [
//                    'msg'=>'User password is updated',
//                    'data' => json_decode((string)$response->getBody(), true)
//                ],
//                201);
//        }
//        else{
//            return response()->json(
//                [
//                    'status' => 'error',
//                    'message' => 'Code is not correct. Please try again'
//                ],
//                403);
//        }
//
//    }







}
