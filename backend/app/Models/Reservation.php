<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'event_space_id', 'event_name', 'start_time', 'end_time', 'status'];
    protected $table = 'reservations';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eventspace()
    {
        return $this->belongsTo(EventSpace::class);
    }
}
