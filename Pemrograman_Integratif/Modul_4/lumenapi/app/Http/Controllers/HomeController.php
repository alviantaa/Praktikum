<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index (Request $request)
    {
        return 'Hello, from lumen! We got your request from endpoint: ' . $request->path();
    }

    public function hello()
    {
        $data['status'] = 'Success';
        $data['message'] = 'Hello, from lumen!';
        return (new Response($data, 201))->header('Content-Type', 'application/json');
    }

    public function defaultUser()
    {
        $user = User::create([
            'name' => 'Nahida',
            'email' => 'nahida@akademiya.ac.id',
            'password' => 'smol'
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'default user created',
            'data' => [
            'user' => $user,]
        ],200);
    }
    public function createUser(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'new user created',
            'data' => [
            'user' => $user,]
        ],200);
    }
    public function getUsers()
    {
        $users = User::all();
        return response()->json([
            'status' => 'Success',
            'message' => 'all users grabbed',
            'data' => [
            'users' => $users,]
        ],200);
    }
}
