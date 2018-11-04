<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Models\User;
use Carbon\Carbon;

/**
 * class UserResource 
 * Extends Illuminate\Http\Resources\Json\ResourceCollection
 *
 * @package App\Http\Resources
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class UserResource extends Resource
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
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        
        return $data;
    }
}
