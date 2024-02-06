<?php

namespace Database\Factories;

use App\Models\Crew;
use App\Models\Genre;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fake = Faker::create();
        $title = $fake->words();
        return [
            'title' => ucfirst(implode( ' ', $title)),
            'slug' => (Str::slug(implode( ' ', $title))),
            'rank' => ($fake->numberBetween(50,100)),
            'year' => Carbon::parse($fake->year),
            'description' => ($fake->text),
        ];
    }

    public function setMainData(object $object): MovieFactory
    {
        return $this->state(fn(array $attributes) => [
            'title' => ($object->title),
            'slug' => (Str::slug($object->title)),
            'rank' => ($object->rank),
            'year' => Carbon::parse($object->year),
            'description' => ($object->description),
        ]);
    }
}
