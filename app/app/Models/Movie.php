<?php

namespace App\Models;


use Abbasudo\Purity\Traits\Sortable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;


class Movie extends Model
{
    use HasFactory;
    use Searchable;
    use Sortable;
    protected $sortFields = [
        'rank',
        'year',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'year' => 'datetime',
    ];
    protected $guarded;
    public function crews(): BelongsToMany
    {
        return $this->belongsToMany(Crew::class);
    }
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('U');
    }
    public function toSearchableArray(): array
    {
        return [
            'title'=>$this->title,
            'slug'=>$this->slug,
            'description'=>$this->description,
        ];
    }
}
