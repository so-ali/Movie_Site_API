<?php

namespace App\Services\Crew;

use App\Data\CrewData;
use App\Models\Crew;

use App\Services\Genre\GenreServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CrewService  implements CrewServiceInterface
{
    public function query(): Builder
    {
        return Crew::query();
    }

    public function paginateCrews($page_limit = 15): ?LengthAwarePaginator
    {
        return $this->query()->paginate($page_limit);
    }

    public function allCrews(): Collection
    {
        return $this->query()->get();
    }

    public function storeCrew(CrewData $data): Model|Builder
    {
        return Crew::firstOrCreate(['name'=>$data->name,'family'=>$data->family,'role'=>$data->role],$data->toArray());
    }

    public function updateCrew($eloquent, CrewData $data): mixed
    {
        $eloquent->update($data->toArray());
        return $eloquent;
    }

    public function destroyCrew($eloquent): void
    {
        $eloquent->delete();
    }
}
