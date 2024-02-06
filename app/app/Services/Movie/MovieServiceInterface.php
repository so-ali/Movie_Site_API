<?php

namespace App\Services\Movie;

use App\Data\MovieData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
interface MovieServiceInterface
{
    public function query();

    public function paginateMovies($page_limit = 15): ?LengthAwarePaginator;

    public function allMovies(): Collection;

    public function storeMovie(MovieData $data);

    public function updateMovie($eloquent, MovieData $data): mixed;

    public function destroyMovie($eloquent): void;
}
