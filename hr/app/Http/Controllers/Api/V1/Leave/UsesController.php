<?php

namespace App\Http\Controllers\Api\V1\Leave;

use App\Models\Leave\LeaveApplication;
use App\Models\Leave\LeaveUses;
use App\Http\Resources\Leave\LeaveApplicationResource;
use App\Http\Resources\Leave\LeaveUsesResourceCollection;
use App\Repositories\Leave\LeaveUsesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

/**
 * class UsesController 
 * Extends App\Http\Controllers\Controller
 *
 * @package App\Http\Controllers\Api\V1\Leave
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class UsesController extends Controller
{
 
    /**
     * Leave Uses Repository.
     *
     * @var App\Repositories\Leave\LeaveUsesRepository
     */
    protected $leaveUsesRepo;

    /**
     * UsesController constructor.
     *
     * @param App\Repositories\Leave\LeaveUsesRepository
     * @return void
     */
    public function __construct(LeaveUsesRepository $leaveUsesRepo)
    {
       $this->leaveUsesRepo = $leaveUsesRepo;
    }


    /**
     * Leave already uses by an user
     * GET - api/v1/leave/uses/{user_id}?from_date=2018-11-01&to_date=2018-11-05
     *
     * @param string $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function listByUser(string $userId, Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $data = $this->leaveUsesRepo->AllByUser($userId, $fromDate, $toDate);

        return response()->json([
            'status' => 'Success',
            'data' => [
                'total' => sizeof($data),
                'list' => new LeaveUsesResourceCollection($data)
            ]
        ], 200);
    }

    /**
     * Return list of applications of auth user
     * GET - api/v1/leave/my/uses?from_date=2018-11-01&to_date=2018-11-05
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listByAuthUser(Request $request)
    {
        return $this->listByUser(config('user.id'), $request);
    }
}
    