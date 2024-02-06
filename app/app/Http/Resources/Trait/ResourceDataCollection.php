<?php

namespace App\Http\Resources\Trait;

use App\Http\Resources\ConditionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ResourceDataCollection extends ResourceCollection
{
    use ConditionTrait;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($collect) use ($request) {
            if ($collect instanceof Model) {
                $array = explode('\\', get_class($collect));
                $resource = 'App\\Http\\Resources\\' . end($array) . 'Resource';

                return $resource::make($collect)->condition($this->condition)->additional($this->additional);
            } else {
                return $collect::make($collect)->condition($this->condition)->additional($this->additional)->toArray($request);
            }
        });
    }
}
