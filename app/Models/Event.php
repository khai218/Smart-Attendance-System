<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    // Specify the table name since Laravel expects 'events' by default
    protected $table = 'event';

    // Define the fillable fields for mass assignment
    protected $fillable = ['name', 'location', 'time_held'];

    // Ensure the 'timestamp' is treated as a Carbon instance
    protected $casts = [
        'timestamp' => 'datetime',
    ];
}