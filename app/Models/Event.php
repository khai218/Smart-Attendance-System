<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    // Specify the table name since Laravel expects 'events' by default
    protected $table = 'event';

    // Define the fillable fields for mass assignment
    protected $fillable = ['name', 'location', 'time_start','time_end'];

    // Ensure the 'timestamp' is treated as a Carbon instance
    protected $casts = [
        'timestamp' => 'datetime',
    ];

    // Automatically generate UUID for event_id
    public static function boot()
    {
        parent::boot();
    
        static::creating(function ($event) {
            $event->event_id = (string) Str::uuid();
        });
    }
}