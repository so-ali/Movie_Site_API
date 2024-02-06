<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
            return [
                'crews' => CrewResource::collection($this->crews),
                'genres' => GenreResource::collection($this->genres),
            ];
        })];
    }
}
