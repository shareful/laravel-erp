<?php

namespace App\Http\Resources\Leave;

use Illuminate\Http\Resources\Json\Resource;

/**
 * class LeaveApplicationResource 
 * Extends Illuminate\Http\Resources\Json\ResourceCollection
 *
 * @package App\Http\Resources\Leave
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class LeaveApplicationResource extends Resource
{
    /**
     * Transform the resource into an array.
     * Signature compatible with Illuminate\Http\Resources\Json\JsonResource::toArray($request)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data =  [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'leave_type' => $this->leave_type,
            'reason' => $this->reason,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        
        return $data;
    }
}
