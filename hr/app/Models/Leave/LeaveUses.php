<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        return $this->belongsTo(LeaveApplication::class);
    }

    /**
     * Scope a query to only include uses from the date.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $fromDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFromDate($query, $fromDate)
    {
        return $query->whereDate('use_date', '>=', Carbon::parse($fromDate));
    }

    /**
     * Scope a query to only include uses till the date.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $toDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToDate($query, $toDate)
    {
        return $query->whereDate('use_date', '<=', Carbon::parse($toDate));
    }

}
