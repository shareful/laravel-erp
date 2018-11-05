<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;

/**
 * class AuthController 
 * Extends App\Http\Controllers\Api\V1\ApiBaseController
 *
 * @package App\Http\Controllers\Api\V1
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class AuthController extends ApiBaseController
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
     *
     * @SWG\Post(
     *      path="/login",
     *      summary="User Login",
     *      tags={"User"},
     *      description="Login toUser Account. On successfull return user details with JWT token",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="email",
     *          in="body",
     *          description="User Email Address",
     *          required=true,
     *          type="string",
     *          @SWG\Schema(type="string"),
     *      ),
     *      @SWG\Parameter(
     *          name="password",
     *          in="body",
     *          description="User Password",
     *          required=true,
     *          type="string",
     *          @SWG\Schema(type="string"),
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="status",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="object",
     *              )
     *          )
     *      )
     * )     
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
     *
     * @SWG\Get(
     *      path="/me",
     *      summary="Authenticated User",
     *      tags={"User"},
     *      description="Get the authenticated User. On successfull return logged in user details with JWT token",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="status",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="object",
     *              )
     *          )
     *      )
     * )     
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
     *
     * @SWG\Get(
     *      path="/logout",
     *      summary="User Logout",
     *      tags={"User"},
     *      description="Log the user out (Invalidate the token)",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )          
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
     *
     * @SWG\Get(
     *      path="/refresh",
     *      summary="Refresh Token",
     *      tags={"User"},
     *      description="Regenerate user JWT token",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="status",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="object"
     *              )
     *          )
     *      )
     * )          
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
