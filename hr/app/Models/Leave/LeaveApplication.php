<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

/**
 * class LeaveApplication 
 * Extends Illuminate\Database\Eloquent\Model
 *
 * @package App\Models\Leave
 * @author Shareful Islam <km.shareful@gmail.com>
 * 
 * @SWG\Definition(
 *      definition="LeaveApplication",
 *      required={"start_date", "end_date", "leave_type", "reason"},
 *      type="object",
 *      @SWG\Property(
 *          property="id",
 *          description="Leave Application Id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="start_date",
 *          description="Date From",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="end_date",
 *          description="Date Thru",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="leave_type",
 *          description="Type of Leave",
 *          type="string",
 *          enum={"Sick", "Casual", "Earned", "Maternity", "Paternity"}
 *      ),
 *      @SWG\Property(
 *          property="reason",
 *          description="Reason of Leave",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="Status of the Application",
 *          type="string",
 *          enum={"Pending", "Approved", "Denied"}
 *      )
 * )
 */
class LeaveApplication extends Model
{
    /**
     * The constants for Sick Types supprted.
     *
     * @var string
     */
    const TYPE_SICK = 'Sick';
    const TYPE_CASUAL = 'Casual';
    const TYPE_EARNED = 'Earned';
    const TYPE_MATERNITY = 'Maternity';    
    const TYPE_PATERNITY = 'Paternity';    

    /**
     * The constants for Leave Application Status supprted.
     *
     * @var string
     */
    const STATUS_PENDING = 'Pending';    
    const STATUS_APPROVED = 'Approved';    
    const STATUS_DENIED = 'Denied';    

    /**
     * MySql Table name.
     *
     * @var string
     */
    protected $table = "hr_leave_applications";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'start_date', 'end_date', 'leave_type', 'reason'];

    
    /**
     * Leave Uses for the application
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leaveUses()
    {
        return $this->hasMany(LeaveUses::class, 'application_id', 'id');
    }


}
