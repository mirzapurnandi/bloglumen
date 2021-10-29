<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function index()
    {
        $this->middleware('ceklevel:admin');
        $user = User::all();

        return $this->successResponse($user, 'All User');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|string',
            'username'  => 'required|string|unique:users',
            'password'  => 'required|confirmed'
        ]);

        try {
            $user = new User;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->save();

            return $this->successResponse($user, 'Add User Successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('failed', 409);
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $credentials = $request->only(['username', 'password']);
        if (!$token = Auth::attempt($credentials)) {
            return $this->errorResponse('Unauthorized', 401);
        }

        return $this->respondWithToken($token);
    }

    public function profil()
    {
        return response()->json(auth()->user());
    }
}
