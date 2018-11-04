<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;

/**
 * class RegisterController 
 * Extends App\Http\Controllers\Controller
 *
 * @package App\Http\Controllers\Api\V1
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class RegisterController extends Controller
{
    /**
     * User Repository.
     *
     * @var App\Repositories\UserRepository
     */
    protected $userRepo;

    /**
     * RegisterController constructor.
     *
     * @param App\Repositories\UserRepository
     * @return void
     */
    public function __construct(UserRepository $userRepo)
    {
       $this->userRepo = $userRepo;
    }

    /**
     * Register an user
     * POST - api/v1/register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $user = $this->userRepo->create($request->only($this->userRepo->getModel()->fillable));

        $token = JWTAuth::fromUser($user);

        //Return on success
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
}
