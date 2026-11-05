<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'duration', 'fee', 'start_date'];

    protected function casts(): array
    {
        return ['fee' => 'decimal:2', 'start_date' => 'date'];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
