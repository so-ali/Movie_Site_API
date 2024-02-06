<?php

namespace App\Data;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;

class CrewData extends Data
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $family,
        public readonly ?string $role,
        public readonly ?string $birthdate,
    )
    {
    }

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'family' => ['required', 'string'],
            'role' => ['required', 'string'],
            'birthdate' => ['required', 'date_format:Y-m-d'],
        ];
    }
}
