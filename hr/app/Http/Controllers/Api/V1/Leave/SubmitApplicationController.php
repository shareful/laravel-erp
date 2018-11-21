<?php

namespace App\Http\Controllers\Api\V1\Leave;

use App\Models\Leave\LeaveApplication;
use App\Http\Controllers\Api\V1\ApiBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Leave\LeaveApplicationResource;
use App\Repositories\Leave\LeaveApplicationRepository;
use Illuminate\Validation\Rule;

/**
 * class SubmitApplicationController 
 * Extends App\Http\Controllers\Api\V1\ApiBaseController
 *
 * @package App\Http\Controllers\Api\V1\Leave
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class SubmitApplicationController extends ApiBaseController
{
    /**
     * Leave Application Repository.
     *
     * @var App\Repositories\Leave\LeaveApplicationRepository
     */
    protected $leaveAppRepo;

    /**
     * SubmitApplicationController constructor.
     *
     * @param App\Repositories\Leave\LeaveApplicationRepository
     * @return void
     */
    public function __construct(LeaveApplicationRepository $leaveAppRepo)
    {
       $this->leaveAppRepo = $leaveAppRepo;
    }

    /**
     * Submit a Leave Application api
     * POST api/v1/leave/apply
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *      path="/leave/apply",
     *      summary="Leave Application",
     *      tags={"LeaveApplication"},
     *      description="Submit an application for leave.",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="start_date",
     *          in="formData",
     *          description="Start Date",
     *          required=true,
     *          type="string",
     *          format="date",
     *          @SWG\Schema(type="string"),
     *      ),
     *      @SWG\Parameter(
     *          name="end_date",
     *          in="formData",
     *          description="End Date",
     *          required=true,
     *          type="string",
     *          format="date",
     *          @SWG\Schema(type="string"),
     *      ),
     *      @SWG\Parameter(
     *          name="leave_type",
     *          in="formData",
     *          description="Type of Leave",
     *          required=true,
     *          type="string",
     *          enum={"Sick", "Casual", "Earned", "Maternity", "Paternity"},
     *          @SWG\Schema(type="string"),
     *      ),
     *      @SWG\Parameter(
     *          name="reason",
     *          in="formData",
     *          description="Reason for Leave",
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
     *                  description="status",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="object",
     *                  @SWG\Property(
     *                      type="object",
     *                      property="leave_application",
     *                      description="Leave application details",
     *                      @SWG\Schema(
     *                          @SWG\Items(ref="#/definitions/LeaveApplication"),
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response="400",
     *          description="Validation failed.",
     *      )
     * )     
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => ['required'],
            'end_date' => ['required'],
            'leave_type' => [
				'required',
				Rule::in([
					LeaveApplication::TYPE_SICK, 
					LeaveApplication::TYPE_CASUAL, 
					LeaveApplication::TYPE_EARNED, 
					LeaveApplication::TYPE_MATERNITY,
					LeaveApplication::TYPE_PATERNITY,
				])
			],
			'reason' => ['required'],
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $leaveApplication = $this->leaveAppRepo->create($request->only($this->leaveAppRepo->getModel()->fillable));

        
        //Return on success
        return response()->json([
            'status' => 'Success',
            'data' => [
                'leave_application' => new LeaveApplicationResource($leaveApplication)
            ],
        ], 200);
    }

    /**
     * Leave Application Approve API
     * PUT api/v1/leave_application/approve/{applicationId}
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Put(
     *      path="/leave_application/approve",
     *      summary="Approve Application",
     *      tags={"LeaveApplication"},
     *      description="Approve Leave Application.",
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
     *      ),
     *      @SWG\Response(
     *          response="400",
     *          description="failed.",
     *      )
     * )     
     */
    public function approve($id, Request $request)
    {
    	$application = $this->leaveAppRepo->approve($id);

    	if ($application instanceof LeaveApplication) {
			//Return on success
	        return response()->json([
	            'status' => 'Success',
	            'data' => [
	                'leave_application' => new LeaveApplicationResource($application)
	            ],
	        ], 200);
		} else {
			//Return on Failed
	        return response()->json([
	            'status' => 'Failed',
	        ], 400);
		}	
    }

    /**
     * Leave Application Deny API
     * PUT api/v1/leave_application/deny/{applicationId}
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Put(
     *      path="/leave_application/deny",
     *      summary="Deny Application",
     *      tags={"LeaveApplication"},
     *      description="Deny Leave Application.",
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
     *      ),
     *      @SWG\Response(
     *          response="400",
     *          description="failed.",
     *      )
     * )     
     */
    public function deny($id, Request $request)
    {
    	$application = $this->leaveAppRepo->deny($id);

    	if ($application instanceof LeaveApplication) {
			//Return on success
	        return response()->json([
	            'status' => 'Success',
	            'data' => [
	                'leave_application' => new LeaveApplicationResource($application)
	            ],
	        ], 200);
		} else {
			//Return on Failed
	        return response()->json([
	            'status' => 'Failed',
	        ], 400);
		}	
    }
}
