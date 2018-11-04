<?php

namespace App\Http\Controllers\Api\V1\Leave;

use App\Models\Leave\LeaveApplication;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Leave\LeaveApplicationResource;
use App\Repositories\Leave\LeaveApplicationRepository;
use Illuminate\Validation\Rule;

/**
 * class SubmitApplicationController 
 * Extends App\Http\Controllers\Controller
 *
 * @package App\Http\Controllers\Api\V1\Leave
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class SubmitApplicationController extends Controller
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
     * Submit a Leav of Application api
     * POST api/v1/leave/apply
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
     * PUT api/v1/leave_application/approve/{application_id}
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
			//Return on success
	        return response()->json([
	            'status' => 'Failed',
	        ], 200);
		}	
    }

    /**
     * Leave Application Deny API
     * PUT api/v1/leave_application/deny/{application_id}
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
			//Return on success
	        return response()->json([
	            'status' => 'Failed',
	        ], 200);
		}	
    }
}
