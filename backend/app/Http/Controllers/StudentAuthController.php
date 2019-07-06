<?php

namespace App\Http\Controllers;


use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentAuthController extends Controller
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
                'client_secret' => 'gNth9MRLjpubqy2Dmh0rbc4Eb6Vbv795Zju9VOsK',
                'username' => $identifier,
                'password' => $password,
                'scope' => '',
                'theNewProvider'=> 'api',
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

        if (empty(Student::where('username', $request->username)->first())){
            $student = Student::firstOrNew(['username' => $request->username]); //checks whether it is new user with this email
            $student->username = $request->username;
            $student->name = $request->name;
//            $student->email = $request->email;

            $student->password = bcrypt($request->password); //password through bcrypt
            $student->save();

            $response = $this->get_token($request->username, $request->password);

            return response(
                [
                    'data' => json_decode((string)$response->getBody(), true),
                    'message'=>'success'
                ],
                200);
        }
        else
            return response()->json(
                [
                    'data'=>[],
                    'message'=>'Student with such username already exists'
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

        $student = Student::where('username', $request->username)->first(); //gets user with email
        if (!$student) {
            //returns error if user does not exists
            return response()->json(
                [
                    'data' => [],
                    'message' => 'Student not found. Check credentials'
                ],
                404);
        }
        if (Hash::check($request->password, $student->password)) { //checks passwords

            $response = $this->get_token($request->username, $request->password);

            return response([
                'data' => json_decode((string)$response->getBody(), true),
                'name'=> $student->username,
                'msg'=>'success'
            ],
                201);
        }
        return response()->json(
            [
                'message' => 'Username or password is wrong. Check credentials',
                'data' => []
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
