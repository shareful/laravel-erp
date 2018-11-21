<?php

namespace App\Http\Controllers\Api\V1\Leave;

use App\Models\Leave\LeaveApplication;
use App\Models\Leave\LeaveUses;
use App\Http\Resources\Leave\LeaveApplicationResource;
use App\Http\Resources\Leave\LeaveUsesResourceCollection;
use App\Repositories\Leave\LeaveUsesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\ApiBaseController;
use Auth;

/**
 * class UsesController 
 * Extends App\Http\Controllers\Api\V1\ApiBaseController
 *
 * @package App\Http\Controllers\Api\V1\Leave
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class UsesController extends ApiBaseController
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
     * GET - api/v1/leave/uses/{userId}?from_date=2018-11-01&to_date=2018-11-05
     *
     * @param string $userId
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *      path="/leave/uses/{userId}",
     *      summary="Leave uses of an user.",
     *      tags={"LeaveUses"},
     *      description="Leave already uses by an user.",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="userId",
     *          in="path",
     *          description="Id of the User",
     *          required=true,
     *          type="integer",
     *          format="int32",
     *      ),
     *      @SWG\Parameter(
     *          name="from_date",
     *          in="query",
     *          description="Date From",
     *          required=true,
     *          type="string",
     *          format="date",
     *      ),
     *      @SWG\Parameter(
     *          name="to_date",
     *          in="query",
     *          description="Date Thru",
     *          required=true,
     *          type="string",
     *          format="date",
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
     * Leave already used by auth user
     * GET - api/v1/leave/my/uses?from_date=2018-11-01&to_date=2018-11-05
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *      path="/leave/my/uses",
     *      summary="Leave uses of loggedin user.",
     *      tags={"LeaveUses"},
     *      description="Return leave already used by loggedin user.",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="from_date",
     *          in="query",
     *          description="Date From",
     *          required=true,
     *          type="string",
     *          format="date",
     *      ),
     *      @SWG\Parameter(
     *          name="to_date",
     *          in="query",
     *          description="Date Thru",
     *          required=true,
     *          type="string",
     *          format="date",
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
    public function listByAuthUser(Request $request)
    {
        return $this->listByUser(config('user.id'), $request);
    }
}
    