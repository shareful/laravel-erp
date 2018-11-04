<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;

/**
 * class AuthController 
 * Extends App\Http\Controllers\Controller
 *
 * @package App\Http\Controllers\Api\V1
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class AuthController extends Controller
{
    /**
     * User Repository.
     *
     * @var App\Repositories\UserRepository
     */
    protected $userRepo;

    /**
     * AuthController constructor.
     *
     * @param App\Repositories\UserRepository
     * @return void
     */
    public function __construct(UserRepository $userRepo)
    {       
       $this->userRepo = $userRepo;
    }

    /**
     * Login and Get a JWT via given credentials.
     * POST - api/v1/login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }

        return response()->json([
            'status' => 'Success',
            'data' => [
                'user' => new UserResource(auth()->user()),
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ],
        ], 200);        
    }

    /**
     * Get the authenticated User
     * GET - api/v1/me
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth()->user();
        // $token = JWTAuth::fromUser($user);
        $token = auth()->fromUser($user);

        return response()->json([
            'status' => 'Success',
            'data' => [
                'user' => new UserResource($user),
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ],
        ], 200);        
    }

    /**
     * Log the user out (Invalidate the token).
     * GET - api/v1/logout
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    /**
     * Refresh a token.
     * GET - api/v1/refresh
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = auth()->refresh();

        return response()->json([
            'status' => 'Success',
            'data' => [
                'user' => new UserResource(auth()->user()),
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ],
        ], 200);
    }

}
