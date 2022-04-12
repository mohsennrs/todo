<?php
 
namespace Hattori\ToDo\Resources;
 
use Hattori\ToDo\Resources\TaskResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
 
class TaskCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => TaskResource::collection($this->collection),
            'status' => 'success'
        ];
    }
}