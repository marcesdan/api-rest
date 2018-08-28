<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\AuthService;


class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService= $authService;
    }
    /**
     * Register a new UserRequest
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // si la validación no pasa, se devuelve una respuesta con los errores pertinentes
        $input = $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'administrador' => '',
        ]);

        $user = $this->authService->register($input);

        return
            response()->json([
                'user' => (new UserResource($user)),
        ], 200);
    }

    /**
     * Login user generating a Personal Access Token
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = $request->user();
            $token = $user->createToken('MyApp')->accessToken;
            return
                response()->json([
                'data' => [
                    'user' => (new UserResource($user)),
                    'token' => $token,
                ]], 200);
        } else {
            return
                response()->json([
                    'error' => 'Unauthorised'
                ], 401);
        }
    }

    /**
     * Logout user (Revoke the token)
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return
            response()->json([],204);
    }

    /**
     * Logout user (Revoke all tokens)
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logoutAll(Request $request)
    {
        $tokens = $request->user()->tokens;
        foreach($tokens as $token) {
            $token->revoke();
        }
        return
            response()->json([],204);
    }
}
