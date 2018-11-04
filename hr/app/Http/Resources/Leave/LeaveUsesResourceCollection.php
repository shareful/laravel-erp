<?php

namespace App\Http\Resources\Leave;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * class LeaveUsesResourceCollection 
 * Extends Illuminate\Http\Resources\Json\ResourceCollection
 *
 * @package App\Http\Resources\Leave
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class LeaveUsesResourceCollection extends ResourceCollection
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
        $data = $this->collection->transform(function ($uses) {
            $tmp = [
                'id' => $uses->id,
                'user_id' => $uses->user_id,
                'use_date' => $uses->use_date,
                'application_id' => $uses->application_id,
                'created_at' => $uses->created_at,
                'updated_at' => $uses->updated_at,
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
