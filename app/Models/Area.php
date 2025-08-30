<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function projects()
    {
        return $this->belongsTo(Project::class);
    }
}
