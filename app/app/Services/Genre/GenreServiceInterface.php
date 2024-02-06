<?php

namespace App\Services\Genre;

use App\Data\GenreData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GenreServiceInterface
{
    public function query();

    public function paginateGenres($page_limit = 15): ?LengthAwarePaginator;

    public function allGenres(): Collection;

    public function storeGenre(GenreData $data);

    public function updateGenre($eloquent, GenreData $data): mixed;

    public function destroyGenre($eloquent): void;
}
