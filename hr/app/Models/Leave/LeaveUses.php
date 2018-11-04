<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

/**
 * class LeaveUses 
 * Extends Illuminate\Database\Eloquent\Model
 *
 * @package App\Models\Leave
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class LeaveUses extends Model
{

    /**
     * MySql Table name.
     *
     * @var string
     */
    protected $table = "hr_leave_uses";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['use_date', 'user_id', 'application_id'];

    /**
     * Application Reference
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leaveApplication()
    {
        //Has one category
        return $this->belongsTo(LeaveApplication::class);
    }
}
