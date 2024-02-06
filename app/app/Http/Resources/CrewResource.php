<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CrewResource extends JsonResource
{
    use ConditionTrait;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request) + [$this->whenCondition('single', function () {
                return ['movies' => MovieResource::collection($this->movies)];
            })];
    }
}
