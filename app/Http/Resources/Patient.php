<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Patient extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'pesel' => $this->pesel,
            'created_at' => Carbon::parse($this->created_at)->format('d.m.Y'),
            'is_alive' => $this->is_alive,
            'clinic' => $this->user->clinic,
            'diseases' => $this->diseases->pluck('name'),
            'events' => $this->events->pluck('event_type_id'),
        ];
    }
}
