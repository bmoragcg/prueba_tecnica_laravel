<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $estado = false;

        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|string',
            'password' => 'required|string',
        ]);



        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $token = JWTAuth::attempt($validator->validated());

        if (!empty($token)) {
            $estado = true;

            return response()->json([
                'token' => $this->createNewToken($token),
                'estado' => $estado,
            ]);
        } else {
            return response()->json([
                'error' => 'Unauthorized',
                'estado' => $estado,
            ]);
        }
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|string|between:2,20',
            'password' => 'required|string|confirmed|min:8',
            'email' => 'required|string|email|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = Usuario::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
        ], 201);
    }

    protected function createNewToken($token)
    {
        $response = [
            'access_token' => $token,
            'estado' => 1,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => auth()->user(),
        ];

        return $response;
    }
}
