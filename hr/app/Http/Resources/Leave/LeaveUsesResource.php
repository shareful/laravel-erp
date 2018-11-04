<?php

namespace App\Http\Resources\Leave;

use Illuminate\Http\Resources\Json\Resource;

/**
 * class LeaveUsesResource 
 * Extends Illuminate\Http\Resources\Json\ResourceCollection
 *
 * @package App\Http\Resources\Leave
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class LeaveUsesResource extends Resource
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
            'use_date' => $this->use_date,
            'application_id' => $this->application_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        
        return $data;
    }
}
