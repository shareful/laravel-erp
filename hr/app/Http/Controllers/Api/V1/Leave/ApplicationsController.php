<?php

namespace App\Http\Controllers\Api\V1\Leave;

use App\Models\Leave\LeaveApplication;
use App\Http\Resources\Leave\LeaveApplicationResource;
use App\Http\Resources\Leave\LeaveApplicationResourceCollection;
use App\Repositories\Leave\LeaveApplicationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\ApiBaseController;
use Auth;

/**
 * class ApplicationsController 
 * Extends App\Http\Controllers\Api\V1\ApiBaseController
 *
 * @package App\Http\Controllers\Api\V1\Leave
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class ApplicationsController extends ApiBaseController
{
 
    /**
     * Leave Application Repository.
     *
     * @var App\Repositories\Leave\LeaveApplicationRepository
     */
    protected $leaveAppRepo;

    /**
     * ApplicationsController constructor.
     *
     * @param App\Repositories\Leave\LeaveApplicationRepository
     * @return void
     */
    public function __construct(LeaveApplicationRepository $leaveAppRepo)
    {
       $this->leaveAppRepo = $leaveAppRepo;
    }

    /**
     * Return list of application
     * GET - api/v1/leave_applications/list
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *      path="/leave_applications/list",
     *      summary="List of Applications",
     *      tags={"LeaveApplication"},
     *      description="Get the list of applications submitted to leave.",
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
    public function list()
    {
    	$data = $this->leaveAppRepo->all();

    	return response()->json([
            'status' => 'Success',
            'data' => [
                'total' => sizeof($data),
                'list' => new LeaveApplicationResourceCollection($data)
            ]
        ], 200);
    }

    /**
     * Return a detail of an application
     * GET - api/v1/leave_application/show/{applicationId}
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *      path="/leave_application/show/{applicationId}",
     *      summary="Detail of an application",
     *      tags={"LeaveApplication"},
     *      description="Return a detail of an application.",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="applicationId",
     *          in="path",
     *          description="Id of the Application",
     *          required=true,
     *          type="integer",
     *          format="int32",
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
    public function show($id, Request $request)
    {
        $application = $this->leaveAppRepo->show($id);

        return response()->json([
            'status' => 'Success',
            'data' => new LeaveApplicationResource($application)
        ], 200);
    }

    /**
     * Return list of applications applied by a User
     * GET - api/v1/leave_applications/list/{userId}
     *
     * @param String $userId
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *      path="/leave_applications/list/{userId}",
     *      summary="List of Applications applied by a User",
     *      tags={"LeaveApplication"},
     *      description="Return list of applications applied by a User",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="userId",
     *          in="path",
     *          description="Id of the User",
     *          required=true,
     *          type="integer",
     *          format="int32",
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
    public function listByUser(string $userId)
    {
        $data = $this->leaveAppRepo->AllByUser($userId);

        return response()->json([
            'status' => 'Success',
            'data' => [
                'total' => sizeof($data),
                'list' => new LeaveApplicationResourceCollection($data)
            ]
        ], 200);
    }

    /**
     * Return list of applications of auth user
     * GET - api/v1/leave_applications/my/list
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *      path="/leave_applications/my/list",
     *      summary="List of applications of loggedin user",
     *      tags={"LeaveApplication"},
     *      description="Return list of applications of auth user",
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
    public function listByAuthUser()
    {
        return $this->listByUser(config('user.id'));
    }
}
    