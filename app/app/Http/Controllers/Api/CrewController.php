<?php

namespace App\Http\Controllers\Api;

use App\Data\CrewData;
use App\Http\Controllers\Controller;
use App\Http\Resources\CrewResource;
use App\Models\Crew;
use App\Services\Crew\CrewServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
class CrewController extends Controller
{
    public function __construct(
        private CrewServiceInterface $repository
    )
    {
    }

    public function index(): JsonResponse
    {
        return response()->json( Cache::remember( 'crews'.(request()->get('page')??1),now()->addMinutes(5),function (){
           return CrewResource::make($this->repository->paginateCrews(5));
        } ));
    }

    public function store(CrewData $data): JsonResponse
    {
        return response()->json(
            CrewResource::make($this->repository->storeCrew($data)),
            Response::HTTP_CREATED
        );
    }

    public function show(Crew $crew): JsonResponse
    {
        return response()->json( Cache::remember( 'crew'.$crew->id,now()->addMinutes(5),function () use ($crew){
           return CrewResource::make($crew)->condition(['single']);
        } ));
    }

    public function update(Crew $crew, CrewData $data): JsonResponse
    {
        Cache::forget( 'crew'.$crew->id);
        return response()->json( Cache::remember( 'crew'.$crew->id,now()->addMinutes(5),function () use ($crew,$data){
            return CrewResource::make($this->repository->updateCrew($crew,$data))->condition(['single']);
        } ));

    }

    public function destroy(Crew $crew): JsonResponse
    {

        $this->repository->destroyCrew($crew);
        Cache::delete('crew'.$crew->id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
