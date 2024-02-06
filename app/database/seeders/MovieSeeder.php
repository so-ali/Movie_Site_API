<?php

namespace Database\Seeders;

use App\Models\Crew;
use App\Models\Genre;
use App\Models\Movie;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_file_data = database_path('seeders/Data/movies.json');
        if (file_exists($category_file_data)) {
            $movies = json_decode(file_get_contents($category_file_data));
            foreach ($movies as $movie) {
                $object = Movie::factory()->setMainData($movie);

                $movieModel = $object->create();
                foreach ($movie->crews as $crew) {
                    $crewModel = Crew::firstOrCreate([
                        'name' => $crew->name,
                        'family' => $crew->family,
                        'role' => $crew->role,
                        'birthdate' => Carbon::parse($crew->birthdate),
                    ],[
                        'name' => $crew->name,
                        'family' => $crew->family,
                        'role' => $crew->role,
                        'birthdate' => Carbon::parse($crew->birthdate),
                    ]);
                    $movieModel->crews()->attach($crewModel);
                }
                foreach ($movie->genres as $genre) {
                    $genreModel = Genre::firstOrCreate(['slug' => Str::slug($genre)],[
                        'name' => $genre,
                        'slug' => Str::slug($genre)
                    ]);
                    $movieModel->genres()->attach($genreModel);
                }
            }
        }
        Movie::factory()->times(50)->create();
    }

}

