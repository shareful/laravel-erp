<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;

/**
 * class RegisterController 
 * Extends App\Http\Controllers\Api\V1\ApiBaseController
 *
 * @package App\Http\Controllers\Api\V1
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class RegisterController extends ApiBaseController
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
     *
     * @SWG\Post(
     *      path="/register",
     *      summary="Register A User",
     *      tags={"User"},
     *      description="Create User Account. On successfull return user details with JWT token",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="name",
     *          in="formData",
     *          description="User Full Name",
     *          required=true,
     *          type="string",
     *          @SWG\Schema(type="string"),
     *      ),
     *      @SWG\Parameter(
     *          name="email",
     *          in="formData",
     *          description="User Email Address",
     *          required=true,
     *          type="string",
     *          format="email",
     *          @SWG\Schema(type="string"),
     *      ),
     *      @SWG\Parameter(
     *          name="password",
     *          in="formData",
     *          description="User Password",
     *          required=true,
     *          type="string",
     *          @SWG\Schema(type="string"),
     *      ),
     *      @SWG\Parameter(
     *          name="password_confirmation",
     *          in="formData",
     *          description="Password Confirmation",
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
