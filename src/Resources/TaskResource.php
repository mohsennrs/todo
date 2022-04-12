<?php

namespace Hattori\ToDo\Resources;

use Hattori\ToDo\Resources\LabelResource;
use Illuminate\Http\Resources\Json\JsonResource;
class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'labels' => LabelResource::collection($this->labels)
        ];
    }
}
