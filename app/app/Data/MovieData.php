<?php

namespace App\Data;
use Spatie\LaravelData\Data;

class MovieData extends Data
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $rank,
        public readonly ?string $year,
        public readonly ?string $description,
        public readonly ?string $slug,

    )
    {
    }

    public static function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'rank' => ['required', 'numeric'],
            'year' => ['required', 'date_format:Y'],
            'description' => ['required', 'string'],
            'slug' => ['required', 'string','unique:movies'],
        ];
    }
}
