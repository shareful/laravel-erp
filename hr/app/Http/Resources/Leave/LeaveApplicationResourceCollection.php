<?php

namespace App\Http\Resources\Leave;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * class LeaveApplicationResourceCollection 
 * Extends Illuminate\Http\Resources\Json\ResourceCollection
 *
 * @package App\Http\Resources\Leave
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class LeaveApplicationResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     * Signature compatible with Illuminate\Http\Resources\Json\JsonResource::toArray($request)
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data = $this->collection->transform(function ($application) {
            $tmp = [
                'id' => $application->id,
                'user_id' => $application->user_id,
                'start_date' => $application->start_date,
                'end_date' => $application->end_date,
                'leave_type' => $application->leave_type,
                'reason' => $application->reason,
                'status' => $application->status,
                'created_at' => $application->created_at,
                'updated_at' => $application->updated_at,
            ];

            return $tmp;
        });

        if ($data->count() == 1) {
            // Fixing of sometime collections have one element
            return [$data->first()];
        } else {
            return $data;
        }

    }
}
