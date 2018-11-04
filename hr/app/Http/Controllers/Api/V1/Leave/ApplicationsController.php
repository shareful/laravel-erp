<?php

namespace App\Http\Controllers\Api\V1\Leave;

use App\Models\Leave\LeaveApplication;
use App\Http\Resources\Leave\LeaveApplicationResource;
use App\Http\Resources\Leave\LeaveApplicationResourceCollection;
use App\Repositories\Leave\LeaveApplicationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

/**
 * class ApplicationsController 
 * Extends App\Http\Controllers\Controller
 *
 * @package App\Http\Controllers\Api\V1\Leave
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class ApplicationsController extends Controller
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
     * GET - api/v1/leave_application/show/{application_id}
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
     * GET - api/v1/leave_applications/list/{user_id}
     *
     * @param String $userId
     * @return \Illuminate\Http\JsonResponse
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
     */
    public function listByAuthUser()
    {
        return $this->listByUser(config('user.id'));
    }
}
    