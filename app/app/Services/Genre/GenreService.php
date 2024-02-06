<?php

namespace App\Services\Genre;

use App\Data\GenreData;
use App\Models\Genre;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GenreService  implements GenreServiceInterface
{
    public function query(): Builder
    {
        return Genre::query();
    }

    public function paginateGenres($page_limit = 15): ?LengthAwarePaginator
    {
       return $this->query()->paginate($page_limit);
    }

    public function allGenres(): Collection
    {
        return $this->query()->get();
    }

    public function storeGenre(GenreData $data): Model|Builder
    {
        $data = $data->toArray();
        $data['slug'] = Str::slug($data['name']);

        return Genre::firstOrCreate(['slug'=>$data['slug']],$data);
    }

    public function updateGenre($eloquent, GenreData $data): mixed
    {
        $data = $data->toArray();
        $data['slug'] = Str::slug($data['name']);
        $eloquent->update($data);
        return $eloquent;
    }

    public function destroyGenre($eloquent): void
    {
        $eloquent->delete();
    }
}
