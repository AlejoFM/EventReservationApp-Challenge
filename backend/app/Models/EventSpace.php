<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSpace extends Model
{
    use HasFactory;
    protected $fillable = ['name','location', 'description', 'capacity', 'type', 'status'];
    protected $table = 'event_spaces';
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

