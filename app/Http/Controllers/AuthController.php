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
        $this->middleware('ceklevel:admin', ['except' => ['login', 'register', 'profil']]);
    }

    public function index()
    {
        $user = User::with('post')->get();

        return $this->successResponse($user, 'All User');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|string',
            'username'  => 'required|string|unique:users',
            'password'  => 'required|confirmed'
        ], [
            'name.required' => ":attribute value tidak boleh kosong",
            'username.required' => ":attribute value tidak boleh kosong",
            'username.unique' => ":attribute sudah tersedia, harap ganti :attribute yang lain.",
            'password.required' => ":attribute value tidak boleh kosong",
            'password.confirmed' => ":attribute tidak sama dengan :attribute Konfirmasi",
        ]);

        try {
            $user = new User;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
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
        /*
            $user = User::with('transaction')->find(Auth::user()->id);
            return $this->successResponse($user, 'User');
        */
        return response()->json(auth()->user());
    }
}
