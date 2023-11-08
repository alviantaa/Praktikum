<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    protected function jwt(User $user)
    {
        $payload = [
            'iss' => 'lumen-jwt', //issuer of the token
            'sub' => $user->id, //subject of the token
            'iat' => time(), //time when JWT was issued.
            'exp' => time() + 60 * 60 //time when JWT will expire
        ];
        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    // private function base64url_encode(String $data): String
    // {
    //     $base64 = base64_encode($data); // ubah json string menjadi base64
    //     $base64url = strtr($base64, '+/', '-_'); // ubah char '+' -> '-' dan '/' -> '_'
    //     return rtrim($base64url, '='); // menghilangkan '=' pada akhir string
    // }

    // private function sign(String $header, String $payload, String $secret): String
    // {
    //     $signature = hash_hmac('sha256', "{$header}.{$payload}", $secret, true);
    //     $signature_base64url = $this->base64url_encode($signature);
    //     return $signature_base64url;
    // }

    // private function jwt(array $header, array $payload, String $secret): String
    // {
    //     $header_json = json_encode($header);
    //     $payload_json = json_encode($payload);
    //     $header_base64url = $this->base64url_encode($header_json);
    //     $payload_base64url = $this->base64url_encode($payload_json);
    //     $signature_base64url = $this->sign($header_base64url, $payload_base64url, $secret);
    //     $jwt = "{$header_base64url}.{$payload_base64url}.{$signature_base64url}";
    //     return $jwt;
    // }

    public function register(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
        return response()->json([
            'status' => 'Success',
            'message' => 'new user created',
            'data' => [
                'user' => $user,
            ]
        ],200);
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
            'status' => 'Error',
            'message' => 'user not exist',
            ], 404);
        }
        if (!Hash::check($password, $user->password)) {
            return response()->json([
            'status' => 'Error',
            'message' => 'wrong password',
            ], 400);
        }
        $user->token = $this->jwt($user); //
        $user->save();
        return response()->json([
            'status' => 'Success',
            'message' => 'successfully login',
            'data' => [
                'user' => $user,
            ]
        ], 200);
    }
}