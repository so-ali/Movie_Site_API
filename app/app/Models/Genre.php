<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    use HasFactory;
    protected $guarded;
    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('U');
    }
}
