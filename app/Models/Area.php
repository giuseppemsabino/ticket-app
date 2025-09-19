<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
