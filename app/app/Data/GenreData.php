<?php

namespace App\Data;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;

class GenreData extends Data
{
    public function __construct(
        public readonly ?string $name,
    )
    {
    }

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }
}
