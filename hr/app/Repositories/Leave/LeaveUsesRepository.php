<?php

namespace App\Repositories\Leave;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Models\Leave\LeaveUses;

/**
 * class LeaveUsesRepository 
 * Extends App\Repositories\BaseRepository
 *
 * @package App\Repositories\Leave
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class LeaveUsesRepository extends BaseRepository
{
    /**
     * LeaveUsesRepository constructor.
     *
     * @param App\Models\Leave\LeaveUses
     * @return void
     */
	public function __construct(LeaveUses $model)
    {
       // set the model
       $this->model = $model;
    }

	/**
     * Save New Leave Uses 
     *
     * @param array
     * @return App\Models\Leave\LeaveUses
     */
    public function create(array $data)
    {
        return $this->model->create([
            'user_id' => $data['user_id'],
            'application_id' => $data['application_id'],
            'use_date' => $data['use_date'],
        ]);
    }

    /**
     * List of uses by user
     *
     * @param string
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function AllByUser(string $userId, string $fromDate=null, string $toDate=null)
    {
        $model = $this->model->where('user_id', $userId);
        if (!is_null($fromDate)) {
            $model = $model->fromDate($fromDate);
        }
        if (!is_null($toDate)) {
            $model = $model->toDate($toDate);
        }

        return $model->orderBy('use_date', 'desc')->get();        
    }

}
