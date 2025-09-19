<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function areas()
    {
        return $this->belongsToMany(Area::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
