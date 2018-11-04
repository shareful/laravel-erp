<?php

namespace App\Repositories\Leave;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Models\Leave\LeaveApplication;
use App\Models\Leave\LeaveUses;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

/**
 * class LeaveApplicationRepository 
 * Extends App\Repositories\BaseRepository
 *
 * @package App\Repositories\Leave
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class LeaveApplicationRepository extends BaseRepository
{
    /**
     * LeaveApplicationRepository constructor.
     *
     * @param App\Models\Leave\LeaveApplication
     * @return void
     */
	public function __construct(LeaveApplication $model)
    {
       // set the model
       $this->model = $model;
    }

	/**
     * Save New Leave application
     *
     * @param array
     * @return App\Models\Leave\LeaveApplication
     */
    public function create(array $data)
    {
        $application = $this->model->create([
            'user_id' => config('user.id'),
            'start_date' => Carbon::parse($data['start_date']),
            'end_date' => Carbon::parse($data['end_date']),
            'leave_type' => $data['leave_type'],
            'reason' => $data['reason'],
        ]);

        $application->status = LeaveApplication::STATUS_PENDING;
        $application->save();
        return $application;
    }

    /**
     * Approve Leave Application
     *
     * @param int
     * @return bool
     */
    public function approve($id)
    {
        $application = $this->model->find($id);
        if ($application AND $application->status == LeaveApplication::STATUS_PENDING) {
            
            DB::beginTransaction();

            try {                
                $application->status = LeaveApplication::STATUS_APPROVED;
                $application->save();

                // Insert records into leave uses
                $period = CarbonPeriod::create($application->start_date, $application->end_date);

                // Iterate over the period
                $leaveUses = [];
                foreach ($period as $date) {
                    $leave = new LeaveUses();
                    $leave->user_id = $application->user_id;
                    $leave->use_date = $date->format('Y-m-d');
                    
                    $leaveUses[] = $leave;
                }
                $application->leaveUses()->saveMany($leaveUses);

                DB::commit();
                return $application;
            } catch (Exception $e) {
                DB::rollback();
                return false;
            }            
        }

        return false;
    }

    /**
     * Deny Leave Application
     *
     * @param int
     * @return App\Models\Leave\LeaveApplication|bool
     */
    public function deny($id)
    {
        $application = $this->model->find($id);
        if ($application AND $application->status == LeaveApplication::STATUS_PENDING) {
            $application->status = LeaveApplication::STATUS_DENIED;
            $application->save();
            return $application;
        }

        return false;
    }

    /**
     * List of application by user
     *
     * @param string
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function AllByUser(string $userId)
    {
        return $this->model->where('user_id', $userId)->orderBy('id', 'desc')->get();
    }

}
