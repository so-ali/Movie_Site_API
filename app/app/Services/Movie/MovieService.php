<?php

namespace App\Services\Movie;

use App\Data\CrewData;
use App\Data\GenreData;
use App\Data\MovieData;
use App\Models\Movie;
use App\Services\Crew\CrewService;
use App\Services\Genre\GenreService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MovieService implements MovieServiceInterface
{
    public function query(): \Laravel\Scout\Builder|Builder
    {
        if (request()->has('search')) {
            return Movie::search(request()->get('search'));
        }

        return Movie::sort();
    }

    public function paginateMovies($page_limit = 15): ?LengthAwarePaginator
    {
        return $this->query()->paginate($page_limit);
    }

    public function allMovies(): Collection
    {
        return $this->query()->get();
    }

    public function storeMovie(MovieData $data): Model|Builder
    {
        $genreService = new GenreService();
        $crewService = new CrewService();
        $movie = Movie::query()->create($data->toArray());
        if(request()->has('genres')){
            foreach (request()->get('genres') as $genre){
                $genre = $genreService->storeGenre(GenreData::from(['name'=>$genre]));
                $movie->genres()->attach($genre);
            }
        }
        if(request()->has('crews')){
            foreach (request()->get('crews') as $crew){
                $crew = $crewService->storeCrew(CrewData::from([
                    'name'=>$crew['name'],
                    'family'=>$crew['family'],
                    'role'=>$crew['role'],
                    'birthdate'=>$crew['birthdate'],
                ]));
                $movie->crews()->attach($crew);
            }
        }

        return $movie;
    }

    public function updateMovie($eloquent, MovieData $data): mixed
    {
        $eloquent->update($data->toArray());
        return $eloquent;
    }

    public function destroyMovie($eloquent): void
    {
        $eloquent->delete();
    }
}
