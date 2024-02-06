<?php

namespace App\Services\Crew;

use App\Data\CrewData;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;


interface CrewServiceInterface
{
    public function query();

    public function paginateCrews($page_limit = 15): ?LengthAwarePaginator;

    public function allCrews(): Collection;

    public function storeCrew(CrewData $data);

    public function updateCrew($eloquent,CrewData $data): mixed;

    public function destroyCrew($eloquent): void;
}
