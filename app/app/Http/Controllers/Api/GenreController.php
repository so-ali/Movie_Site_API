<?php

namespace App\Http\Controllers\Api;

use App\Data\GenreData;
use App\Http\Controllers\Controller;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use App\Services\Genre\GenreServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class GenreController extends Controller
{
    public function __construct(
        private GenreServiceInterface $repository
    )
    {
    }

    public function index(): JsonResponse
    {
        return response()->json( Cache::remember( 'genre'.(request()->get('page')??1),now()->addMinutes(5),function (){
            return GenreResource::make($this->repository->paginateGenres(5));
        } ));
    }

    public function store(GenreData $data): JsonResponse
    {
        return response()->json(GenreResource::make($this->repository->storeGenre($data)),
            Response::HTTP_CREATED
        );
    }

    public function show(Genre $genre): JsonResponse
    {
        return response()->json( Cache::remember( 'genre'.$genre->id,now()->addMinutes(5),function () use ($genre){
            return GenreResource::make($genre)->condition(['single']);
        } ));
    }

    public function update(Genre $genre, GenreData $data): JsonResponse
    {
        Cache::forget( 'genre'.$genre->id);
        return response()->json( Cache::remember( 'genre'.$genre->id,now()->addMinutes(5),function () use ($genre,$data){
            return GenreResource::make($this->repository->updateGenre($genre,$data))->condition(['single']);
        } ));
    }

    public function destroy(Genre $genre): JsonResponse
    {
        $this->repository->destroyGenre($genre);
        Cache::delete('genre'.$genre->id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
