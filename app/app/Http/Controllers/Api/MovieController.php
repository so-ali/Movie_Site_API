<?php

namespace App\Http\Controllers\Api;

use App\Data\MovieData;
use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Services\Movie\MovieServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class MovieController extends Controller
{
    public function __construct(
        private MovieServiceInterface $repository
    )
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(MovieResource::make($this->repository->paginateMovies()));
    }

    public function store(MovieData $data): JsonResponse
    {
        return response()->json(MovieResource::make($this->repository->storeMovie($data))->condition(['single']),
            Response::HTTP_CREATED
        );
    }

    public function show(Movie $movie): JsonResponse
    {
        return response()->json(Cache::remember('movie' . $movie->id, now()->addMinutes(5), function () use ($movie) {
            return MovieResource::make($movie)->condition(['single']);
        }));
    }

    public function update(Movie $movie, MovieData $data): JsonResponse
    {
        Cache::forget('movie' . $movie->id);
        return response()->json(Cache::remember('movie' . $movie->id, now()->addMinutes(5), function () use ($movie, $data) {
            return MovieResource::make($this->repository->updateMovie($movie, $data))->condition(['single']);
        }));
    }

    public function destroy(Movie $movie): JsonResponse
    {
        $this->repository->destroyMovie($movie);
        Cache::delete('movie' . $movie->id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
