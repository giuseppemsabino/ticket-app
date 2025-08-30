<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function projects()
    {
        return $this->belongsTo(Project::class);
    }

    public function areas()
    {
        return $this->belongsTo(Area::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function statuses()
    {
        return $this->belongsTo(Status::class);
    }
}
